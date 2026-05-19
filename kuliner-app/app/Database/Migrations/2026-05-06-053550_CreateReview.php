<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReview extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'kuliner_id'  => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'user_id'     => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true
            ],
            'rating'      => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'isi'         => [
                'type'           => 'TEXT'
            ],
            'created_at'  => [
                'type'           => 'TIMESTAMP',
                'null'           => true
            ],
        ]);

        $this->forge->addKey('id', true);

        // Relasi: Jika kuliner/user dihapus, review otomatis hilang (CASCADE)
        $this->forge->addForeignKey('kuliner_id', 'kuliner', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('review');
    }

    public function down()
    {
        $this->forge->dropTable('review');
    }
}