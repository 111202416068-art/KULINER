<?php

namespace App\Controllers;

class Jelajah extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();

        // 1. Ambil data kuliner murni
        $kuliner = $db->table('kuliner')->get()->getResultArray();

        // 2. Ambil data kategori pendukung secara real-time dari database
        $kategoriList = $db->table('kategori')->get()->getResultArray();

        // 3. Proses mapping deteksi nama kategori
        foreach ($kuliner as &$k) {
            $kolomTeksKategori = $k['kategori'] ?? null;

            if ($kolomTeksKategori && !is_numeric($kolomTeksKategori)) {
                $k['nama_kategori'] = $kolomTeksKategori;
            } else {
                $k['nama_kategori'] = 'Umum'; 

                $idKategoriDiKuliner = $k['kategori_id'] ?? $k['id_kategori'] ?? $k['id_kat'] ?? $k['kategori'] ?? null;

                foreach ($kategoriList as $kat) {
                    if ($idKategoriDiKuliner != null && $idKategoriDiKuliner == $kat['id_kategori']) {
                        $k['nama_kategori'] = $kat['nama_kategori'];
                        break;
                    }
                }
            }
        }

        // 🔥 FIX SINKRONISASI: Mengirim data kategoriList ke dalam view dengan nama variabel 'kategori'
        return view('jelajah/index', [
            'title'    => 'Jelajah Kuliner',
            'kuliner'  => $kuliner,
            'kategori' => $kategoriList // Sekarang view bisa membaca kategori buatanmu!
        ]);
    }

    public function detail($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $kuliner = $db->table('kuliner')->where('id', $id)->get()->getRowArray();

        if (!$kuliner) {
            return redirect()->to('/jelajah')->with('error', 'Data kuliner tidak ditemukan.');
        }

        // Ambil ulasan dari tabel review untuk kuliner ini
        $review = $db->table('review')
            ->where('kuliner_id', $id)
            ->orderBy('id', 'DESC') // Disesuaikan menggunakan primary key 'id' agar seragam
            ->get()
            ->getResultArray();

        return view('jelajah/detail', [
            'title'   => 'Detail ' . $kuliner['nama'],
            'kuliner' => $kuliner,
            'review'  => $review
        ]);
    }
}
