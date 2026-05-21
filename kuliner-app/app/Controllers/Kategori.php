<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    // Tampilkan data kategori
    public function index()
    {
        $data = [
            'title'    => 'Data Kategori',
            'kategori' => $this->kategoriModel->findAll()
        ];

        return view('kategori/index', $data);
    }

    // Form tambah kategori
    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori'
        ];

        return view('kategori/create', $data);
    }

    // Simpan kategori baru
    public function save()
    {
        $this->kategoriModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);

        return redirect()->to('/kategori');
    }

    // Form edit kategori
    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Kategori',
            'kategori' => $this->kategoriModel->find($id)
        ];

        return view('kategori/edit', $data);
    }

    // Update kategori
    public function update($id)
    {
        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);

        return redirect()->to('/kategori');
    }

    // Hapus kategori
    public function delete($id)
    {
        $this->kategoriModel->delete($id);

        return redirect()->to('/kategori');
    }
}
