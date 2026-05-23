<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Kategori extends BaseController
{
    //Fungsi utama menampilkan daftar kategori (Bebas Duplikasi)
    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/kuliner');
        }

        $db = \Config\Database::connect();
        
        // Menggunakan groupBy atau distinct agar nama kategori yang muncul tidak ganda
        $data['title'] = 'Manajemen Kategori';
        $data['kategori'] = $db->table('kategori')
                               ->orderBy('id_kategori', 'ASC')
                               ->get()
                                ->getResultArray();

        return view('kategori/index', $data);
    }

    // Fungsi menyimpan kategori baru
    public function save()
    {
        $db = \Config\Database::connect();
        $namaKategori = $this->request->getPost('nama_kategori');

        if (!empty($namaKategori)) {
            $db->table('kategori')->insert([
                'nama_kategori' => htmlspecialchars($namaKategori)
            ]);
            return redirect()->to('/kategori')->with('success', 'Kategori baru berhasil ditambahkan!');
        }

        return redirect()->to('/kategori')->with('error', 'Nama kategori tidak boleh kosong.');
    }

    // Fungsi menghapus kategori berdasarkan ID
    public function delete($id)
    {
        $db = \Config\Database::connect();
        
        try {
            $db->table('kategori')->where('id_kategori', $id)->delete();
            return redirect()->to('/kategori')->with('success', 'Kategori sukses dihapus dari sistem.');
        } catch (\Exception $e) {
            return redirect()->to('/kategori')->with('error', 'Gagal menghapus! Kategori ini masih digunakan oleh data kuliner.');
        }
    }
}