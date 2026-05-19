<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KulinerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'          => 1,
                'nama'        => 'Kopi Disapa',
                'alamat'      => 'Jl. Imam Bonjol No. 161, Semarang',
                'kategori_id' => 1, // Pastikan ID 1 ini ada di KategoriSeeder kamu (misal: Cafe)
                'lat'         => '-6.9826',
                'lng'         => '110.4092',
                'foto'        => 'default.jpg'
            ],
            [
                'id'          => 2,
                'nama'        => 'Lumpia Gang Lombok',
                'alamat'      => 'Gang Lombok No. 11, Purwodinatan',
                'kategori_id' => 2, // Pastikan ID 2 ini ada di KategoriSeeder kamu (misal: Restoran)
                'lat'         => '-6.9739',
                'lng'         => '110.4245',
                'foto'        => 'default.jpg'
            ],
        ];

        // Nonaktifkan foreign key check sementara supaya bisa truncate/bersihkan data lama
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $this->db->table('kuliner')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');

        // Masukkan data baru
        $this->db->table('kuliner')->insertBatch($data);
    }
}