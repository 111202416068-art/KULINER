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
        $db = \Config\Database::connect();

        // 1. Ambil data dari input filter (GET)
        $search   = $this->request->getGet('search');
        $kategori_id = $this->request->getGet('kategori');

        $builder = $db->table('kuliner');
        $builder->select('kuliner.*, kategori.nama_kategori, review.rating, review.isi as review_text');
        $builder->join('kategori', 'kategori.id_kategori = kuliner.kategori_id', 'left');
        $builder->join('review', 'review.kuliner_id = kuliner.id', 'left');

        // 2. LOGIKA FILTER
        // Jika ada input pencarian nama atau alamat
        if ($search) {
            $builder->groupStart()
                ->like('kuliner.nama', $search)
                ->orLike('kuliner.alamat', $search)
                ->groupEnd();
        }

        // Jika kategori dipilih
        if ($kategori_id) {
            $builder->where('kuliner.kategori_id', $kategori_id);
        }

        $builder->groupBy('kuliner.id');
        $kuliner = $builder->get()->getResultArray();

        $reviewModel = new \App\Models\ReviewModel();
        $kategoriModel = new \App\Models\KategoriModel();

        $avgData = $reviewModel->selectAvg('rating', 'rating')->first();

        $data = [
            'kuliner'     => $kuliner,
            'kategori'    => $kategoriModel->findAll(),
            'totalReview' => $reviewModel->countAll(),
            'rataRating'  => $avgData['rating'] ?? 0
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
        // 1. Ambil ID dari session (Pastikan saat login ID ini sudah di-set)
        $userId = session()->get('id');

        // Cek jika session kosong, arahkan ke login agar tidak error Foreign Key
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Sesi habis, silakan login kembali.');
        }

        // 2. Inisialisasi variabel $namaFoto agar tidak undefined
        $fileFoto = $this->request->getFile('gambar');

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads', $namaFoto);
        } else {
            $namaFoto = 'default.jpg'; // Nilai default jika tidak upload foto
        }

        $userId = session()->get('id');

        if (!$userId || $userId == 0) {
            return redirect()->back()->with('error', 'Hanya user terdaftar yang bisa menambah data.');
        }

        // 3. Simpan data Kuliner
        $this->kulinerModel->insert([
            'nama'        => $this->request->getPost('nama'),
            'alamat'      => $this->request->getPost('alamat'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'lat'         => $this->request->getPost('lat'),
            'lng'         => $this->request->getPost('lng'),
            'foto'        => $namaFoto, // Variabel $namaFoto sekarang pasti ada
        ]);

        // 4. Ambil ID kuliner yang baru saja disimpan
        $kulinerId = $this->kulinerModel->insertID();

        // 5. Simpan ke tabel Review
        $this->reviewModel->insert([
            'kuliner_id' => $kulinerId,
            'user_id'    => $userId, // Menggunakan variabel $userId dari session
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

        // Ambil data kuliner lengkap dengan ratingnya menggunakan query builder
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
        $this->kulinerModel->save([
            'id'          => $id,
            'nama'        => $this->request->getPost('nama'),
            'alamat'      => $this->request->getPost('alamat'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'lat'         => $this->request->getPost('lat'),
            'lng'         => $this->request->getPost('lng'),
            'rating'      => $this->request->getPost('rating'),
            'review'      => $this->request->getPost('review')
        ]);

        return redirect()->to('/kuliner');
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
            'review'  => $this->reviewModel
                ->where('kuliner_id', $id)
                ->findAll()
        ];

        return view('kuliner/detail', $data);
    }
}
