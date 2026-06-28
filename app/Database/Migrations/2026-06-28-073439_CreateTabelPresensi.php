<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTabelPresensi extends Migration
{
   public function up()
    {
        $this->forge->addField([
            'id_presensi' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'id_kelas' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'waktu_hadir' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Hadir', 'Sakit', 'Izin', 'Alpha'],
            ],
            'keterangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_presensi');
        $this->forge->addForeignKey('id_user', 'tabel_users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kelas', 'tabel_kelas', 'id_kelas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tabel_presensi');
    }

    public function down()
    {
        $this->forge->dropTable('tabel_presensi');
    }
}
