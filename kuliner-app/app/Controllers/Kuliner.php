<?php

namespace App\Controllers;

use App\Models\KulinerModel;
use App\Models\KategoriModel;
use App\Models\ReviewModel;

class Kuliner extends BaseController
{
    protected $kulinerModel;
    protected $kategoriModel;
    protected $reviewModel;

    public function __construct()
    {
        $this->kulinerModel = new KulinerModel();
        $this->kategoriModel = new KategoriModel();
        $this->reviewModel = new ReviewModel();
        
        // Load helper bawaan dan custom helper bintang
        helper(['bintang', 'url', 'form']);
    }

    public function index()
    {
        $search   = $this->request->getVar('search');
        $kategori = $this->request->getVar('kategori');

        // Mengambil data dari model yang sudah diperbaiki query-nya
        $dataKuliner = $this->kulinerModel->getKulinerWithRating($search, $kategori);

        // Hitung statistik dashboard
        $totalReview = $this->reviewModel->countAllResults();
        $allReviews = $this->reviewModel->findAll();
        $totalRatingValue = 0;
        foreach ($allReviews as $r) {
            $totalRatingValue += (float)$r['rating'];
        }
        $rataRating = $totalReview > 0 ? ($totalRatingValue / $totalReview) : 0;

        // --- CONSUME API CUACA KOTA SEMARANG ---
        $cache = \Config\Services::cache();
        $cuaca = $cache->get('cuaca_semarang');

        if (!$cuaca) {
            try {
                $client = \Config\Services::curlrequest();
                $response = $client->request('GET', 'https://wttr.in/Semarang?format=j1', [
                    'timeout' => 5
                ]);
                $body = json_decode($response->getBody(), true);
                
                if (isset($body['current_condition'][0])) {
                    $cond = $body['current_condition'][0];
                    $cuaca = [
                        'desc'     => isset($cond['lang_id'][0]['value']) ? $cond['lang_id'][0]['value'] : $cond['weatherDesc'][0]['value'],
                        'temp'     => $cond['temp_C'] . '°C',
                        'humidity' => $cond['humidity'] . '%'
                    ];
                    $cache->save('cuaca_semarang', $cuaca, 600);
                }
            } catch (\Exception $e) {
                $cuaca = [
                    'desc'     => 'Informasi cuaca tidak tersedia',
                    'temp'     => '--',
                    'humidity' => '--'
                ];
            }
        }

        $data = [
            'title'       => 'Dashboard Direktori Kuliner',
            'kuliner'     => $dataKuliner,
            'kategori'    => $this->kategoriModel->findAll(),
            'totalReview' => $totalReview,
            'rataRating'  => $rataRating,
            'cuaca'       => $cuaca
        ];

        return view('kuliner/index', $data);
    }

    public function detail($id)
    {
        $data = [
            'title'   => 'Detail Kuliner',
            'kuliner' => $this->kulinerModel->find($id)
        ];
        return view('kuliner/detail', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Data Kuliner',
            'kategori' => $this->kategoriModel->findAll()
        ];
        return view('kuliner/create', $data);
    }

    public function save()
    {
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = 'default.jpg';
        
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads', $namaFoto);
        }

        $this->kulinerModel->save([
            'nama'        => $this->request->getPost('nama'),
            'alamat'      => $this->request->getPost('alamat'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'lat'         => $this->request->getPost('lat'),
            'lng'         => $this->request->getPost('lng'),
            'foto'        => $namaFoto
        ]);

        return redirect()->to('/kuliner');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Data Kuliner',
            'kuliner'  => $this->kulinerModel->find($id),
            'kategori' => $this->kategoriModel->findAll(),
            'review'   => $this->reviewModel->where('kuliner_id', $id)->first()
        ];
        return view('kuliner/edit', $data);
    }

    public function update($id)
    {
        $this->kulinerModel->save([
            'id'          => $id,
            'nama'        => $this->request->getPost('nama'),
            'alamat'      => $this->request->getPost('alamat'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'lat'         => $this->request->getPost('lat'),
            'lng'         => $this->request->getPost('lng'),
        ]);

        $ratingInput = $this->request->getPost('rating');
        $reviewInput = $this->request->getPost('review');

        $existingReview = $this->reviewModel->where('kuliner_id', $id)->first();

        if ($existingReview) {
            $this->reviewModel->update($existingReview['id_review'], [
                'rating' => $ratingInput,
                'isi'    => $reviewInput
            ]);
        } else {
            $userId = session()->get('id') ?? 1;
            $this->reviewModel->insert([
                'kuliner_id' => $id,
                'user_id'    => $userId,
                'rating'     => $ratingInput,
                'isi'        => $reviewInput
            ]);
        }

        return redirect()->to('/kuliner')->with('success', 'Data berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->kulinerModel->delete($id);
        return redirect()->to('/kuliner');
    }
}