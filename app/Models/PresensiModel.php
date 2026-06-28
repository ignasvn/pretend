<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table      = 'tabel_presensi';
    protected $primaryKey = 'id_presensi';

    protected $allowedFields = [
        'id_user', 'id_kelas', 'tanggal', 'waktu_hadir', 'status', 'keterangan', 'created_at'
    ];

    // Cek apakah mahasiswa sudah presensi hari ini di kelas tertentu
    public function sudahPresensi(int $id_user, int $id_kelas, string $tanggal)
    {
        return $this->where('id_user', $id_user)
                    ->where('id_kelas', $id_kelas)
                    ->where('tanggal', $tanggal)
                    ->first();
    }

    // Ambil riwayat presensi mahasiswa
    public function getRiwayatMahasiswa(int $id_user)
    {
        return $this->select('tabel_presensi.*, tabel_kelas.nama_kelas')
                    ->join('tabel_kelas', 'tabel_kelas.id_kelas = tabel_presensi.id_kelas')
                    ->where('tabel_presensi.id_user', $id_user)
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }

    // Ambil presensi per kelas (untuk dosen)
    public function getPresensiByKelas(int $id_kelas, string $tanggal)
    {
        return $this->select('tabel_presensi.*, tabel_users.nama, tabel_users.username')
                    ->join('tabel_users', 'tabel_users.id_user = tabel_presensi.id_user')
                    ->where('tabel_presensi.id_kelas', $id_kelas)
                    ->where('tabel_presensi.tanggal', $tanggal)
                    ->findAll();
    }

    // Rekap per mahasiswa per kelas dalam rentang tanggal
    public function getRekapByKelas(int $id_kelas, string $dari, string $sampai)
    {
        return $this->select('
                    tabel_users.nama,
                    tabel_users.username,
                    SUM(CASE WHEN status = "Hadir" THEN 1 ELSE 0 END) as total_hadir,
                    SUM(CASE WHEN status = "Sakit" THEN 1 ELSE 0 END) as total_sakit,
                    SUM(CASE WHEN status = "Izin"  THEN 1 ELSE 0 END) as total_izin,
                    SUM(CASE WHEN status = "Alpha" THEN 1 ELSE 0 END) as total_alpha,
                    COUNT(*) as total_pertemuan
                ')
                ->join('tabel_users', 'tabel_users.id_user = tabel_presensi.id_user')
                ->where('tabel_presensi.id_kelas', $id_kelas)
                ->where('tanggal >=', $dari)
                ->where('tanggal <=', $sampai)
                ->groupBy('tabel_presensi.id_user')
                ->findAll();
    }

    // Rekap detail per mahasiswa (semua presensinya)
    public function getDetailMahasiswa(int $id_user, int $id_kelas, string $dari, string $sampai)
    {
        return $this->select('tabel_presensi.*, tabel_kelas.nama_kelas')
                    ->join('tabel_kelas', 'tabel_kelas.id_kelas = tabel_presensi.id_kelas')
                    ->where('tabel_presensi.id_user', $id_user)
                    ->where('tabel_presensi.id_kelas', $id_kelas)
                    ->where('tanggal >=', $dari)
                    ->where('tanggal <=', $sampai)
                    ->orderBy('tanggal', 'ASC')
                    ->findAll();
    }

    // Rekap total presensi mahasiswa untuk dashboard
    public function getRekapMahasiswa(int $id_user)
    {
        return $this->select('
                    SUM(CASE WHEN status = "Hadir" THEN 1 ELSE 0 END) as total_hadir,
                    SUM(CASE WHEN status = "Sakit" THEN 1 ELSE 0 END) as total_sakit,
                    SUM(CASE WHEN status = "Izin"  THEN 1 ELSE 0 END) as total_izin,
                    SUM(CASE WHEN status = "Alpha" THEN 1 ELSE 0 END) as total_alpha,
                    COUNT(*) as total_presensi
                ')
                ->where('id_user', $id_user)
                ->first();
    }

    // Total hadir hari ini
    public function getTotalHadirHariIni(int $id_user = null, string $role = 'admin')
    {
        $builder = $this->where('status', 'Hadir')
                        ->where('tanggal', date('Y-m-d'));

        if ($role === 'dosen' && $id_user) {
            $builder->join('tabel_kelas', 'tabel_kelas.id_kelas = tabel_presensi.id_kelas')
                    ->where('tabel_kelas.id_dosen', $id_user);
        }

        return $builder->countAllResults();
    }

    // Rekap presensi per kelas milik dosen untuk dashboard
    public function getRekapPerKelas(int $id_dosen)
    {
        return $this->select('
                    tabel_kelas.nama_kelas,
                    tabel_kelas.hari,
                    SUM(CASE WHEN tabel_presensi.status = "Hadir" THEN 1 ELSE 0 END) as total_hadir,
                    SUM(CASE WHEN tabel_presensi.status = "Sakit" THEN 1 ELSE 0 END) as total_sakit,
                    SUM(CASE WHEN tabel_presensi.status = "Izin"  THEN 1 ELSE 0 END) as total_izin,
                    SUM(CASE WHEN tabel_presensi.status = "Alpha" THEN 1 ELSE 0 END) as total_alpha,
                    COUNT(*) as total_presensi
                ')
                ->join('tabel_kelas', 'tabel_kelas.id_kelas = tabel_presensi.id_kelas')
                ->where('tabel_kelas.id_dosen', $id_dosen)
                ->groupBy('tabel_presensi.id_kelas')
                ->orderBy('tabel_kelas.hari', 'ASC')
                ->findAll();
    }
}