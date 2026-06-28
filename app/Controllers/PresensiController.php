<?php

namespace App\Controllers;

use App\Models\PresensiModel;
use App\Models\KelasModel;

class PresensiController extends BaseController
{
    protected $presensiModel;
    protected $sesiModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->presensiModel = new PresensiModel();
        $this->kelasModel    = new KelasModel();
    }

    public function index()
    {
        return session()->get('role') === 'mahasiswa'
            ? $this->mahasiswa()
            : $this->dosen();
    }

    // ── MAHASISWA ──────────────────────────────────────────
    private function mahasiswa()
    {
        $id_user    = session()->get('id_user');
        $waktuSkrng = date('H:i:s');

        // Ambil semua sesi hari ini dan mendatang
        $sesiMendatang = $this->sesiModel->getSesiMendatang();

        // Cek status presensi tiap sesi
        $statusPresensi = [];
        foreach ($sesiMendatang as $sesi) {
            $statusPresensi[$sesi['id_sesi']] = $this->presensiModel->sudahPresensi(
                $id_user,
                $sesi['id_sesi']
            );
        }

        return view('presensi/mahasiswa', [
            'sesiMendatang'  => $sesiMendatang,
            'statusPresensi' => $statusPresensi,
            'waktuSkrng'     => $waktuSkrng,
            'riwayat'        => $this->presensiModel->getRiwayatMahasiswa($id_user),
        ]);
    }

    // Proses klik tombol presensi
    public function store()
    {
        if (session()->get('role') !== 'mahasiswa') {
            return redirect()->to('/dashboard');
        }

        $id_user = session()->get('id_user');
        $id_sesi = $this->request->getPost('id_sesi');
        $status  = $this->request->getPost('status');

        // Cek duplikat
        if ($this->presensiModel->sudahPresensi($id_user, $id_sesi)) {
            return redirect()->to('/presensi')->with('error', 'Kamu sudah presensi untuk sesi ini!');
        }

        // Cek jam — tombol hadir hanya bisa diklik saat jam mulai tiba
        $sesi = $this->sesiModel->find($id_sesi);
        if ($status === 'Hadir' && date('H:i:s') < $sesi['jam_mulai']) {
            return redirect()->to('/presensi')->with('error', 'Presensi Hadir belum bisa dilakukan sebelum jam mulai!');
        }

        $this->presensiModel->insert([
            'id_user'     => $id_user,
            'id_sesi'     => $id_sesi,
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
        $id_sesi  = $this->request->getGet('id_sesi');

        // Ambil semua kelas milik dosen
        $kelasDosen = $this->kelasModel
                           ->where('id_dosen', $id_dosen)
                           ->findAll();

        // Ambil sesi dari kelas-kelas dosen
        $sesiList = [];
        foreach ($kelasDosen as $k) {
            $sesiKelas = $this->sesiModel->getSesiByKelas($k['id_kelas']);
            foreach ($sesiKelas as $s) {
                $s['nama_kelas'] = $k['nama_kelas'];
                $sesiList[]      = $s;
            }
        }

        // Sort by tanggal
        usort($sesiList, fn($a, $b) => strtotime($b['tanggal']) - strtotime($a['tanggal']));

        $presensiList = [];
        if ($id_sesi) {
            $presensiList = $this->presensiModel->getPresensiBySesi($id_sesi);
        }

        return view('presensi/dosen', [
            'sesiList'     => $sesiList,
            'presensiList' => $presensiList,
            'id_sesi'      => $id_sesi,
        ]);
    }

    // Koreksi status presensi
    public function koreksi(int $id)
    {
        if (!in_array(session()->get('role'), ['dosen', 'admin'])) {
            return redirect()->to('/dashboard');
        }

        $this->presensiModel->update($id, [
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->back()->with('success', 'Status presensi berhasil dikoreksi!');
    }
}