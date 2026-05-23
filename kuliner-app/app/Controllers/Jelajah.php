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

        // 2. Ambil data kategori pendukung
        $kategoriList = $db->table('kategori')->get()->getResultArray();

        // 3. Proses mapping deteksi nama kategori
        foreach ($kuliner as &$k) {
            // Kita cari tahu apakah ada kolom di tabel kuliner yang langsung berisi teks (bukan angka ID)
            // Misalnya kolom tersebut bernama 'kategori' dan isinya sudah tulisan "Cafe" atau "Restoran"
            $kolomTeksKategori = $k['kategori'] ?? null;

            if ($kolomTeksKategori && !is_numeric($kolomTeksKategori)) {
                // Jika kolom berisi teks langsung seperti "Cafe", langsung pakai saja!
                $k['nama_kategori'] = $kolomTeksKategori;
            } else {
                // Jika isinya angka ID, mari kita cocokkan dengan tabel kategori
                $k['nama_kategori'] = 'Umum'; // Default awal jika tidak ketemu

                // Cek semua kemungkinan nama kolom ID di tabel kuliner kamu
                $idKategoriDiKuliner = $k['id_kategori'] ?? $k['id_kat'] ?? $k['kategori'] ?? $k['kategori_id'] ?? null;

                foreach ($kategoriList as $kat) {
                    if ($idKategoriDiKuliner != null && $idKategoriDiKuliner == $kat['id_kategori']) {
                        $k['nama_kategori'] = $kat['nama_kategori'];
                        break;
                    }
                }
            }
        }

        return view('jelajah/index', [
            'title'   => 'Jelajah Kuliner',
            'kuliner' => $kuliner
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
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('jelajah/detail', [
            'title'   => 'Detail ' . $kuliner['nama'],
            'kuliner' => $kuliner,
            'review'  => $review
        ]);
    }
}
