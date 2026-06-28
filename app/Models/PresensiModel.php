<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table      = 'tabel_presensi';
    protected $primaryKey = 'id_presensi';

    protected $allowedFields = [
        'id_user', 'id_sesi', 'waktu_hadir', 'status', 'keterangan', 'created_at'
    ];

    // Cek sudah presensi di sesi ini belum
    public function sudahPresensi(int $id_user, int $id_sesi)
    {
        return $this->where('id_user', $id_user)
                    ->where('id_sesi', $id_sesi)
                    ->first();
    }

    // Riwayat presensi mahasiswa
    public function getRiwayatMahasiswa(int $id_user)
    {
        return $this->select('tabel_presensi.*, tabel_kelas.nama_kelas, tabel_sesi.tanggal, tabel_sesi.jam_mulai')
                    ->join('tabel_sesi', 'tabel_sesi.id_sesi = tabel_presensi.id_sesi')
                    ->join('tabel_kelas', 'tabel_kelas.id_kelas = tabel_sesi.id_kelas')
                    ->where('tabel_presensi.id_user', $id_user)
                    ->orderBy('tabel_sesi.tanggal', 'DESC')
                    ->findAll();
    }

    // Presensi per sesi (untuk dosen)
    public function getPresensiBySesi(int $id_sesi)
    {
        return $this->select('tabel_presensi.*, tabel_users.nama, tabel_users.username')
                    ->join('tabel_users', 'tabel_users.id_user = tabel_presensi.id_user')
                    ->where('tabel_presensi.id_sesi', $id_sesi)
                    ->findAll();
    }

    // Rekap per kelas dalam rentang tanggal
    public function getRekapByKelas(int $id_kelas, string $dari, string $sampai)
    {
        return $this->select('
                    tabel_users.nama,
                    tabel_users.username,
                    SUM(CASE WHEN tabel_presensi.status = "Hadir" THEN 1 ELSE 0 END) as total_hadir,
                    SUM(CASE WHEN tabel_presensi.status = "Sakit" THEN 1 ELSE 0 END) as total_sakit,
                    SUM(CASE WHEN tabel_presensi.status = "Izin"  THEN 1 ELSE 0 END) as total_izin,
                    SUM(CASE WHEN tabel_presensi.status = "Alpha" THEN 1 ELSE 0 END) as total_alpha,
                    COUNT(*) as total_pertemuan
                ')
                ->join('tabel_users', 'tabel_users.id_user = tabel_presensi.id_user')
                ->join('tabel_sesi', 'tabel_sesi.id_sesi = tabel_presensi.id_sesi')
                ->where('tabel_sesi.id_kelas', $id_kelas)
                ->where('tabel_sesi.tanggal >=', $dari)
                ->where('tabel_sesi.tanggal <=', $sampai)
                ->groupBy('tabel_presensi.id_user')
                ->findAll();
    }
}