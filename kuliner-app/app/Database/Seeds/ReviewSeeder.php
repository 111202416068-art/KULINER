<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kuliner_id' => 1, // Mengulas Kopi Disapa
                'user_id'    => 2, // Pastikan ID 2 ini ada di UserSeeder kamu (misal akun moorlaila)
                'rating'     => 5,
                'isi'        => 'Tempatnya nyaman banget buat nugas, kopinya mantap!'
            ],
            [
                'kuliner_id' => 2, // Mengulas Lumpia Gang Lombok
                'user_id'    => 2, // User yang sama (ID 2) juga mengulas tempat ini
                'rating'     => 5,
                'isi'        => 'Kuliner legendaris Semarang, rasanya gak pernah berubah, top!'
            ],
        ];

        $this->db->table('review')->truncate();
        $this->db->table('review')->insertBatch($data);
    }
}