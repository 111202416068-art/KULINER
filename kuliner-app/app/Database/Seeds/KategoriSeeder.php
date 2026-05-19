<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kategori' => 'Cafe'],
            ['nama_kategori' => 'Restoran'],
            ['nama_kategori' => 'Street Food']
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}