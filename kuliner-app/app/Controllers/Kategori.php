<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        // Supaya tidak perlu tulis "new KategoriModel" berkali-kali
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Data Kategori',
            'kategori' => $this->kategoriModel->findAll()
        ];

        return view('kategori/index', $data);
    }

    // --- TAMBAHKAN FUNGSI INI ---
    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori'
        ];

        return view('kategori/create', $data);
    }

    // --- TAMBAHKAN FUNGSI INI UNTUK SIMPAN DATA ---
    public function save()
    {
        $this->kategoriModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);

        // Setelah simpan, balik ke halaman tabel
        return redirect()->to('/kategori');
    }
}