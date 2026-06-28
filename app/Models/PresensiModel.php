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
}