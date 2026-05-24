<?php

namespace App\Controllers;

use App\Models\KulinerModel;
use App\Models\ReviewModel;
use CodeIgniter\Controller;

class Statistik extends Controller
{
    public function index()
    {
        $kulinerModel = new KulinerModel();
        $reviewModel = new ReviewModel();

        // 1. Menggunakan Query Builder langsung dengan nama kolom penghubung 'kategori_id'
        $db = \Config\Database::connect();
        $kategoriData = $db->table('kuliner')
            ->select('kategori.nama_kategori, COUNT(kuliner.id) as jumlah')
            ->join('kategori', 'kategori.id_kategori = kuliner.kategori_id') // 🔥 FIX: Menggunakan kategori_id sesuai database kamu
            ->groupBy('kategori.nama_kategori')
            ->get()
            ->getResultArray();

        // 2. PROTEKSI ANTI ERROR: Cek data tabel review
        if ($reviewModel->countAll() > 0) {
            $rataRatingData = $reviewModel->selectAvg('rating')->first();
            $rataRating = $rataRatingData ? round($rataRatingData['rating'], 1) : 0;
        } else {
            $rataRating = 0; 
        }

        $data = [
            'title'        => 'Statistik Kuliner',
            'totalKuliner' => $kulinerModel->countAll(),
            'totalReview'  => $reviewModel->countAll(),
            'rataRating'   => $rataRating,
            'kategoriData' => $kategoriData
        ];

        return view('statistik/index', $data);
    }
}