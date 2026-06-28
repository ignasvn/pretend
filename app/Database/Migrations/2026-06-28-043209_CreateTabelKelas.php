<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTabelKelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelas' => [
                'type'           => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'id_dosen' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'hari' => [
                'type'       => 'ENUM',
                'constraint' => ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu', 'Minggu'],
            ],
            'jam_mulai' => [
                'type' => 'TIME',
            ],
            'jam_selesai' => [
                'type' => 'TIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_kelas');
        $this->forge->addForeignKey('id_dosen', 'tabel_users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tabel_kelas');
    }

    public function down()
    {
        $this->forge->dropTable('tabel_kelas');
    }
}
