<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tabel_users';
    protected $primaryKey       = 'id_user';
    // protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    protected $allowedFields    = [
        'username', 'email', 'password', 'nama', 'role'
    ];

    // Fungsi: cari user berdasarkan username ATAU email
    public function findByUsernameOrEmail(string $input){
        return $this->where('username', $input)
                    ->orWhere('email', $input)
                    ->first(); // ambil 1 baris saja
    }

    // Ambil semua user, bisa filter by role
    public function getAllUsers(string $role = null)
    {
        if ($role) {
            return $this->where('role', $role)->findAll();
        }
        return $this->findAll();
    }

    // protected bool $allowEmptyInserts = false;
    // protected bool $updateOnlyChanged = true;

    // protected array $casts = [];
    // protected array $castHandlers = [];

    // // Dates
    // protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];
}
