<?php

namespace App\Controllers;

use App\Models\KulinerModel;
use App\Models\ReviewModel;

class Jelajah extends BaseController
{
    protected $kulinerModel;
    protected $reviewModel;

    public function __construct()
    {
        $this->kulinerModel = new KulinerModel();
        $this->reviewModel  = new ReviewModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $kuliner = $db->table('kuliner')
            ->select('kuliner.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = kuliner.kategori_id', 'left')
            ->get()
            ->getResultArray();

        return view('jelajah/index', [
            'kuliner' => $kuliner
        ]);
    }

    public function detail($id)
    {
        $data = [
            'kuliner' => $this->kulinerModel->find($id),
            'review'  => $this->reviewModel->where('kuliner_id', $id)->findAll()
        ];

        return view('jelajah/detail', $data);
    }
}