<?php

namespace App\Controllers;

use App\Models\PresensiModel;
use App\Models\KelasModel;
use App\Models\UserModel;

class PresensiController extends BaseController
{
    protected $presensiModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->presensiModel = new PresensiModel();
        $this->kelasModel    = new KelasModel();
    }

    public function index()
    {
        $role = session()->get('role');

        if ($role === 'mahasiswa') {
            return $this->mahasiswa();
        }

        return $this->dosen();
    }

    // ── MAHASISWA ──────────────────────────────────────────
    private function mahasiswa()
    {
        $id_user = session()->get('id_user');
        $hari    = date('l'); // nama hari dalam bahasa Inggris
        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        $hariIni = $hariMap[$hari] ?? '';

        // Ambil kelas yang tersedia hari ini
        $kelasHariIni = $this->kelasModel
                             ->where('hari', $hariIni)
                             ->findAll();

        // Cek status presensi tiap kelas hari ini
        $statusPresensi = [];
        foreach ($kelasHariIni as $kelas) {
            $statusPresensi[$kelas['id_kelas']] = $this->presensiModel->sudahPresensi(
                $id_user,
                $kelas['id_kelas'],
                date('Y-m-d')
            );
        }

        $data = [
            'kelasHariIni'   => $kelasHariIni,
            'statusPresensi' => $statusPresensi,
            'riwayat'        => $this->presensiModel->getRiwayatMahasiswa($id_user),
            'hariIni'        => $hariIni,
        ];

        return view('presensi/mahasiswa', $data);
    }

    // Proses klik tombol presensi oleh mahasiswa
    public function store()
    {
        if (session()->get('role') !== 'mahasiswa') {
            return redirect()->to('/dashboard');
        }

        $id_user  = session()->get('id_user');
        $id_kelas = $this->request->getPost('id_kelas');
        $status   = $this->request->getPost('status');
        $tanggal  = date('Y-m-d');

        // Cegah presensi duplikat
        $sudah = $this->presensiModel->sudahPresensi($id_user, $id_kelas, $tanggal);
        if ($sudah) {
            return redirect()->to('/presensi')->with('error', 'Kamu sudah melakukan presensi untuk kelas ini hari ini!');
        }

        $this->presensiModel->insert([
            'id_user'     => $id_user,
            'id_kelas'    => $id_kelas,
            'tanggal'     => $tanggal,
            'waktu_hadir' => date('H:i:s'),
            'status'      => $status,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/presensi')->with('success', 'Presensi berhasil dicatat!');
    }

    // ── DOSEN ──────────────────────────────────────────────
    private function dosen()
    {
        $id_dosen = session()->get('id_user');
        $tanggal  = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $id_kelas = $this->request->getGet('id_kelas');

        // Ambil kelas milik dosen ini
        $kelasDosen = $this->kelasModel
                           ->where('id_dosen', $id_dosen)
                           ->findAll();

        $presensiList = [];
        if ($id_kelas) {
            $presensiList = $this->presensiModel->getPresensiByKelas($id_kelas, $tanggal);
        }

        $data = [
            'kelasDosen'   => $kelasDosen,
            'presensiList' => $presensiList,
            'tanggal'      => $tanggal,
            'id_kelas'     => $id_kelas,
        ];

        return view('presensi/dosen', $data);
    }

    // Koreksi status presensi oleh dosen
    public function koreksi(int $id)
    {
        if (!in_array(session()->get('role'), ['dosen', 'admin'])) {
            return redirect()->to('/dashboard');
        }

        $status = $this->request->getPost('status');

        $this->presensiModel->update($id, [
            'status' => $status,
        ]);

        return redirect()->back()->with('success', 'Status presensi berhasil dikoreksi!');
    }
}