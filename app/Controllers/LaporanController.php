<?php

namespace App\Controllers;

use App\Models\PresensiModel;
use App\Models\KelasModel;

class LaporanController extends BaseController
{
    protected $presensiModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->presensiModel = new PresensiModel();
        $this->kelasModel    = new KelasModel();

        // Hanya admin & dosen
        if (!in_array(session()->get('role'), ['admin', 'dosen'])) {
            redirect()->to('/dashboard')->send();
            exit;
        }
    }

    public function index()
    {
        $role     = session()->get('role');
        $id_user  = session()->get('id_user');

        // Admin lihat semua kelas, dosen hanya kelasnya sendiri
        $kelas = $role === 'admin'
            ? $this->kelasModel->getAllKelas()
            : $this->kelasModel->where('id_dosen', $id_user)->findAll();

        $id_kelas = $this->request->getGet('id_kelas');
        $dari     = $this->request->getGet('dari')    ?? date('Y-m-01'); // awal bulan ini
        $sampai   = $this->request->getGet('sampai')  ?? date('Y-m-d');  // hari ini

        $rekap = [];
        if ($id_kelas) {
            $rekap = $this->presensiModel->getRekapByKelas($id_kelas, $dari, $sampai);
        }

        $data = [
            'kelas'     => $kelas,
            'rekap'     => $rekap,
            'id_kelas'  => $id_kelas,
            'dari'      => $dari,
            'sampai'    => $sampai,
        ];

        return view('laporan/index', $data);
    }

    // Ekspor ke CSV
    public function exportCsv()
    {
        $id_kelas = $this->request->getGet('id_kelas');
        $dari     = $this->request->getGet('dari')   ?? date('Y-m-01');
        $sampai   = $this->request->getGet('sampai') ?? date('Y-m-d');

        if (!$id_kelas) {
            return redirect()->to('/laporan')->with('error', 'Pilih kelas terlebih dahulu!');
        }

        $rekap = $this->presensiModel->getRekapByKelas($id_kelas, $dari, $sampai);
        $kelas = $this->kelasModel->find($id_kelas);

        // Set header untuk download CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="rekap_' . $kelas['nama_kelas'] . '_' . $dari . '_' . $sampai . '.csv"');

        $output = fopen('php://output', 'w');

        // Header kolom
        fputcsv($output, ['No', 'Nama', 'Username', 'Hadir', 'Sakit', 'Izin', 'Alpha', 'Total Pertemuan']);

        // Data
        foreach ($rekap as $i => $r) {
            fputcsv($output, [
                $i + 1,
                $r['nama'],
                $r['username'],
                $r['total_hadir'],
                $r['total_sakit'],
                $r['total_izin'],
                $r['total_alpha'],
                $r['total_pertemuan'],
            ]);
        }

        fclose($output);
        exit;
    }
}