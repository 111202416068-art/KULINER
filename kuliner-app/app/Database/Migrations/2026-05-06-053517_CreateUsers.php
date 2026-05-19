<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'username'     => [
                'type'           => 'VARCHAR', 
                'constraint'     => 100,
                'unique'         => true
            ],
            'password'     => [
                'type'           => 'VARCHAR', 
                'constraint'     => 255
            ],
            'nama_lengkap' => [
                'type'           => 'VARCHAR', 
                'constraint'     => 150
            ],
            'role'         => [
                'type'           => 'VARCHAR', 
                'constraint'     => 20, 
                'default'        => 'pengunjung'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}