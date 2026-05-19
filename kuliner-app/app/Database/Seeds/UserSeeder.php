<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => '123',
                'nama_lengkap' => 'Administrator',
                'role' => 'admin'
            ],
            [
                'username' => 'user',
                'password' => '123',
                'nama_lengkap' => 'Pengunjung',
                'role' => 'pengunjung'
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}