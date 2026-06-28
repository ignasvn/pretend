<?php

namespace App\Controllers;

use App\Models\PresensiModel;
use App\Models\KelasModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $role    = session()->get('role');
        $id_user = session()->get('id_user');

        $presensiModel = new PresensiModel();
        $kelasModel    = new KelasModel();
        $userModel     = new UserModel();

        if ($role === 'mahasiswa') {
            $rekap = $presensiModel->getRekapMahasiswa($id_user);
            $data  = [
                'nama'          => session()->get('nama'),
                'role'          => $role,
                'total_hadir'   => $rekap['total_hadir']   ?? 0,
                'total_sakit'   => $rekap['total_sakit']   ?? 0,
                'total_izin'    => $rekap['total_izin']    ?? 0,
                'total_alpha'   => $rekap['total_alpha']   ?? 0,
                'total_presensi'=> $rekap['total_presensi']?? 0,
                'riwayat' => array_slice($presensiModel->getRiwayatMahasiswa($id_user), 0, 5),
            ];

        } elseif ($role === 'dosen') {
            $data = [
                'nama'             => session()->get('nama'),
                'role'             => $role,
                'total_kelas'      => $kelasModel->where('id_dosen', $id_user)->countAllResults(),
                'total_hadir_hari' => $presensiModel->getTotalHadirHariIni($id_user, 'dosen'),
                'rekap_kelas'      => $presensiModel->getRekapPerKelas($id_user),
            ];

        } else {
            // Admin
            $data = [
                'nama'             => session()->get('nama'),
                'role'             => $role,
                'total_mahasiswa'  => $userModel->where('role', 'mahasiswa')->countAllResults(),
                'total_dosen'      => $userModel->where('role', 'dosen')->countAllResults(),
                'total_kelas'      => $kelasModel->countAllResults(),
                'total_hadir_hari' => $presensiModel->getTotalHadirHariIni(null, 'admin'),
            ];
        }

        return view('dashboard/index', $data);
    }
}