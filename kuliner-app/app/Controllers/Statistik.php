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

        // FIX DI SINI
        $kategoriData = $kulinerModel
            ->select('nama, COUNT(*) as jumlah')
            ->groupBy('nama')
            ->findAll();

        $data = [
            'totalKuliner' => $kulinerModel->countAll(),
            'totalReview' => $reviewModel->countAll(),
            'rataRating' => $reviewModel->selectAvg('rating')->first(),
            'kategoriData' => $kategoriData
        ];

        return view('statistik/index', $data);
    }
}