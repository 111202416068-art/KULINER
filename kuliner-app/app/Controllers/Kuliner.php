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

    // 🔥 FIX 100% AMAN: MENGGUNAKAN QUERY BUILDER DIRECT KONEKSI DATABASE
    public function save()
    {
        $fileFoto = $this->request->getFile('gambar');
        $namaFoto = 'default.jpg';

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads', $namaFoto);
        }

        // Buka koneksi database langsung untuk menghindari limitasi method model
        $db = \Config\Database::connect();

        // 1. Masukkan data dasar ke tabel kuliner menggunakan query builder langsung
        $db->table('kuliner')->insert([
            'nama'          => $this->request->getPost('nama'),
            'alamat'        => $this->request->getPost('alamat'),
            'kategori_id'   => $this->request->getPost('kategori_id'),
            'lat'           => $this->request->getPost('lat'),
            'lng'           => $this->request->getPost('lng'),
            'foto'          => $namaFoto,
            'harga_voucher' => (int)($this->request->getPost('harga_voucher') ?? 50000)
        ]);

        // 2. 🔥 AMBIL ID BARU: Menggunakan cara paling sakti di MySQL murni via Driver CI4
        $idKulinerBaru = $db->insertID();

        // 3. Tangkap input ulasan perdana & bintang dari form tambah data
        $reviewInput = $this->request->getPost('review');
        $ratingInput = $this->request->getPost('rating') ?? 5;
        $userId      = session()->get('id') ?? 1;

        // 4. Inject otomatis ulasan perdana ke tabel review agar tidak muncul tanda "-"
        if (!empty($reviewInput)) {
            $db->table('review')->insert([
                'kuliner_id' => $idKulinerBaru,
                'user_id'    => $userId,
                'rating'     => $ratingInput,
                'isi'        => htmlspecialchars($reviewInput)
            ]);
        } else {
            // Jika dikosongkan, beri ulasan default sistem agar tidak null "-"
            $db->table('review')->insert([
                'kuliner_id' => $idKulinerBaru,
                'user_id'    => $userId,
                'rating'     => $ratingInput,
                'isi'        => 'Rekomendasi tempat kuliner baru pilihan komunitas.'
            ]);
        }

        return redirect()->to('/kuliner')->with('success', 'Data tempat kuliner, foto, dan ulasan perdana resmi diterbitkan!');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Data Kuliner',
            'kategori' => $this->kategoriModel->findAll(),
            'kuliner'  => $this->kulinerModel->find($id),
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
            $this->reviewModel->update($existingReview['id'], [
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