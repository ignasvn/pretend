<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'admin',
                'email'      => 'admin@pretend.com',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'nama'       => 'Administrator',
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'dosen',
                'email'      => 'dosen@pretend.com',
                'password'   => password_hash('dosen123', PASSWORD_BCRYPT),
                'nama'       => 'Dosen Pertama',
                'role'       => 'dosen',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'mahasiswa',
                'email'      => 'mahasiswa@pretend.com',
                'password'   => password_hash('mahasiswa123', PASSWORD_BCRYPT),
                'nama'       => 'Mahasiswa Pertama',
                'role'       => 'mahasiswa',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tabel_users')->ignore(true)->insertBatch($data);
    }
}
