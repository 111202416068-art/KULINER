<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        // Memanggil model kategori
        $this->kategoriModel = new KategoriModel();
    }

    
    // TAMPIL DATA KATEGORI
    public function index()
    {
        $data = [
            'title'    => 'Data Kategori',
            'kategori' => $this->kategoriModel->findAll()
        ];

        return view('kategori/index', $data);
    }

    // FORM TAMBAH KATEGORI
    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori'
        ];

        return view('kategori/create', $data);
    }
 
    // SIMPAN DATA KATEGORI
    public function save()
    {
        $this->kategoriModel->save([

            'nama_kategori' =>
                $this->request->getPost('nama_kategori')

        ]);

        return redirect()->to('/kategori');
    }

    // FORM EDIT KATEGORI
    public function edit($id)
    {
        $data = [

            'title' => 'Edit Kategori',

            'kategori' =>
                $this->kategoriModel->find($id)

        ];

        return view('kategori/edit', $data);
    }

    // UPDATE DATA KATEGORI
    public function update($id)
    {
        $this->kategoriModel->update($id, [

            'nama_kategori' =>
                $this->request->getPost('nama_kategori')

        ]);

        return redirect()->to('/kategori');
    }

    // HAPUS DATA KATEGORI
    public function delete($id)
    {
        $this->kategoriModel->delete($id);

        return redirect()->to('/kategori');
    }
}
