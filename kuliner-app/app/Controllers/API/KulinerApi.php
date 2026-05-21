<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\KulinerModel;

class KulinerApi extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $model = new KulinerModel();
        
        // Mengambil data kuliner lengkap dengan nama kategorinya
        $data = $model->select('kuliner.*, kategori.nama_kategori')
                      ->join('kategori', 'kategori.id_kategori = kuliner.kategori_id', 'left')
                      ->findAll();

        if ($data) {
            return $this->respond([
                'status'    => 200,
                'error'     => null,
                'messages'  => 'Data kuliner berhasil ditemukan',
                'data'      => $data
            ], 200);
        }

        return $this->failNotFound('Data kuliner masih kosong.');
    }
}