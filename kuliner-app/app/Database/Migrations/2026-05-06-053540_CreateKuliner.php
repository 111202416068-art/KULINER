<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKuliner extends Migration
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
            'nama'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 150
            ],
            'alamat'      => [
                'type'           => 'TEXT'
            ],
            'kategori_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true, // Harus unsigned agar cocok dengan kategori
                'null'           => true  // Bisa diset null jika kategori dihapus
            ],
            'lat'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'lng'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'foto'        => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'default.jpg'],
        ]);

        $this->forge->addKey('id', true);
        
        // Relasi: Jika kategori dihapus, kolom kategori_id di sini jadi NULL
        $this->forge->addForeignKey('kategori_id', 'kategori', 'id_kategori', 'SET NULL', 'CASCADE');
        
        $this->forge->createTable('kuliner');
    }

    public function down()
    {
        $this->forge->dropTable('kuliner');
    }
}