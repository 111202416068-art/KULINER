<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SemuaSeeder extends Seeder
{
    public function run()
    {
        // Memanggil seeder secara berurutan sesuai relasi database
        $this->call('UserSeeder');
        $this->call('KategoriSeeder');
        $this->call('KulinerSeeder');
        $this->call('ReviewSeeder'); // Di-run paling akhir karena butuh data dari User & Kuliner
    }
}