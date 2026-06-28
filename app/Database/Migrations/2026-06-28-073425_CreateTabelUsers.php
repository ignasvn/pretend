<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTabelUsers extends Migration
{
public function up()
    {
        // 1. Definisikan semua kolom dan tipe datanya
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true, // Membuat username jadi UNIQUE
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'unique'     => true, // Membuat email jadi UNIQUE
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'dosen', 'mahasiswa'],
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        // 2. Tentukan Primary Key-nya
        $this->forge->addKey('id_user', true);

        // 3. Buat nama tabelnya: 'tabel_users'
        $this->forge->createTable('tabel_users', true);
    }

    public function down()
    {
        $this->forge->dropTable('tabel_users', true);
    }
}
