<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users'; // Nama tabel di database
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['username', 'email', 'password']; // Kolom yang boleh diisi
    protected $useTimestamps    = true; // Otomatis mengisi created_at & updated_at
}