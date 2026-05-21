<?php

namespace App\Controllers;

use App\Models\KulinerModel;
use App\Models\ReviewModel;
use App\Models\KategoriModel;

class Kuliner extends BaseController
{
    protected $kulinerModel;
    protected $reviewModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->kulinerModel  = new KulinerModel();
        $this->reviewModel   = new ReviewModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        // Aktifkan Custom Helper Bintang untuk merender grafis
        helper('bintang');
        $db = \Config\Database::connect();

        // 1. Ambil data dari input filter (GET)
        $search   = $this->request->getGet('search');
        $kategori_id = $this->request->getGet('kategori');

        $builder = $db->table('kuliner');
        $builder->select('kuliner.*, kategori.nama_kategori, review.rating, review.isi as review_text');
        $builder->join('kategori', 'kategori.id_kategori = kuliner.kategori_id', 'left');
        $builder->join('review', 'review.kuliner_id = kuliner.id', 'left');

        if ($search) {
            $builder->groupStart()
                ->like('kuliner.nama', $search)
                ->orLike('kuliner.alamat', $search)
                ->groupEnd();
        }

        if ($kategori_id) {
            $builder->where('kuliner.kategori_id', $kategori_id);
        }

        $builder->groupBy('kuliner.id');
        $kuliner = $builder->get()->getResultArray();

        $reviewModel = new \App\Models\ReviewModel();
        $kategoriModel = new \App\Models\KategoriModel();
        $avgData = $reviewModel->selectAvg('rating', 'rating')->first();

        // ==========================================
        // CONSUME API EKSTERNAL + CACHING (POIN 5)
        // ==========================================
        if (! $dataCuaca = cache('cuaca_semarang')) {
            $client = \Config\Services::curlrequest();
            try {
                $response = $client->request('GET', 'https://wttr.in/Semarang?format=j1', [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0'
                    ],
                    'timeout' => 5
                ]);

                $rawJson = json_decode($response->getBody(), true);
                $currentCondition = $rawJson['current_condition'][0];
                $dataCuaca = [
                    'temp' => $currentCondition['temp_C'] . '°C',
                    'desc' => $currentCondition['lang_id'][0]['value'] ?? $currentCondition['weatherDesc'][0]['value'],
                    'humidity' => $currentCondition['humidity'] . '%'
                ];

                cache()->save('cuaca_semarang', $dataCuaca, 600);
            } catch (\Exception $e) {
                $dataCuaca = [
                    'temp' => '--',
                    'desc' => 'Gagal memuat data cuaca (Offline)',
                    'humidity' => '--'
                ];
            }
        }

        $data = [
            'kuliner'     => $kuliner,
            'kategori'    => $kategoriModel->findAll(),
            'totalReview' => $reviewModel->countAll(),
            'rataRating'  => $avgData['rating'] ?? 0,
            'cuaca'       => $dataCuaca
        ];

        return view('kuliner/index', $data);
    }

    public function create()
    {
        $kategoriModel = new \App\Models\KategoriModel();
        $data = [
            'kategori' => $kategoriModel->findAll(),
        ];
        return view('kuliner/create', $data);
    }

    public function save()
    {
        $userId = session()->get('id') ?? 1;

        $fileFoto = $this->request->getFile('gambar');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads', $namaFoto);
        } else {
            $namaFoto = 'default.jpg';
        }

        $this->kulinerModel->insert([
            'nama'        => $this->request->getPost('nama'),
            'alamat'      => $this->request->getPost('alamat'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'lat'         => $this->request->getPost('lat'),
            'lng'         => $this->request->getPost('lng'),
            'foto'        => $namaFoto,
        ]);

        $kulinerId = $this->kulinerModel->insertID();

        $this->reviewModel->insert([
            'kuliner_id' => $kulinerId,
            'user_id'    => $userId,
            'rating'     => $this->request->getPost('rating'),
            'isi'        => $this->request->getPost('review')
        ]);

        return redirect()->to('/kuliner')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        if (session()->get('role') == 'pengunjung') {
            return redirect()->to('/kuliner');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('kuliner');
        $builder->select('kuliner.*, review.rating, review.isi as review_text');
        $builder->join('review', 'review.kuliner_id = kuliner.id', 'left');
        $builder->where('kuliner.id', $id);

        $kuliner = $builder->get()->getRowArray();

        if (!$kuliner) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data kuliner ID $id tidak ditemukan.");
        }

        $data = [
            'title'    => 'Edit Data Kuliner',
            'kuliner'  => $kuliner,
            'kategori' => $this->kategoriModel->findAll()
        ];

        return view('kuliner/edit', $data);
    }

    public function update($id)
    {
        // 1. Update data utama di tabel kuliner
        $this->kulinerModel->save([
            'id'          => $id,
            'nama'        => $this->request->getPost('nama'),
            'alamat'      => $this->request->getPost('alamat'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'lat'         => $this->request->getPost('lat'),
            'lng'         => $this->request->getPost('lng'),
        ]);

        // 2. Ambil data rating dan review dari form input
        $ratingInput = $this->request->getPost('rating');
        $reviewInput = $this->request->getPost('review');

        // 3. Cek apakah kuliner ini sudah punya review sebelumnya di database
        $existingReview = $this->reviewModel->where('kuliner_id', $id)->first();

        if ($existingReview) {
            // Jika sudah ada review, kita UPDATE review yang lama
            $this->reviewModel->update($existingReview['id_review'], [
                'rating' => $ratingInput,
                'isi'    => $reviewInput
            ]);
        } else {
            // Jika ternyata belum ada review sama sekali, kita INSERT baru
            $userId = session()->get('id') ?? 1; // Default ke ID 1 jika session kosong
            $this->reviewModel->insert([
                'kuliner_id' => $id,
                'user_id'    => $userId,
                'rating'     => $ratingInput,
                'isi'        => $reviewInput
            ]);
        }

        // 4. Kembali ke halaman utama dashboard dengan pesan sukses
        return redirect()->to('/kuliner')->with('success', 'Data dan Review berhasil diperbarui!');
    }

    public function delete($id)
    {
        if (session()->get('role') == 'pengunjung') {
            return redirect()->to('/kuliner');
        }

        $this->kulinerModel->delete($id);
        return redirect()->to('/kuliner');
    }

    public function detail($id)
    {
        $data = [
            'kuliner' => $this->kulinerModel->find($id),
            'review'  => $this->reviewModel->where('kuliner_id', $id)->findAll()
        ];
        return view('kuliner/detail', $data);
    }
}
