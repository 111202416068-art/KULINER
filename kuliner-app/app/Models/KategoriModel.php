<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori'; // GANTI INI (Tadinya 'id')
    protected $allowedFields = ['nama_kategori'];
}