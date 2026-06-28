<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table      = 'tabel_kelas';
    protected $primaryKey = 'id_kelas';

    protected $allowedFields = [
        'nama_kelas', 'id_dosen', 'tanggal', 'jam_mulai', 'jam_selesai', 'created_at'
    ];

    // Ambil semua kelas beserta nama dosennya (JOIN)
    public function getAllKelas()
    {
        return $this->select('tabel_kelas.*, tabel_users.nama as nama_dosen')
                    ->join('tabel_users', 'tabel_users.id_user = tabel_kelas.id_dosen')
                    ->findAll();
    }

    // Ambil 1 kelas beserta nama dosennya
    public function getKelasById(int $id)
    {
        return $this->select('tabel_kelas.*, tabel_users.nama as nama_dosen')
                    ->join('tabel_users', 'tabel_users.id_user = tabel_kelas.id_dosen')
                    ->where('tabel_kelas.id_kelas', $id)
                    ->first();
    }
}