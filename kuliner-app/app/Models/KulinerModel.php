<?php

namespace App\Models;

use CodeIgniter\Model;

class KulinerModel extends Model
{
    protected $table            = 'kuliner';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // FIX DATA MUTASI: Mendaftarkan harga_voucher agar diizinkan masuk ke database oleh system
    protected $allowedFields    = ['nama', 'alamat', 'kategori_id', 'lat', 'lng', 'foto', 'harga_voucher'];

    // Method vital untuk menggabungkan data kuliner, kategori, dan ulasan review terbaru
    public function getKulinerWithRating($search = null, $kategori = null)
    {
        $builder = $this->db->table('kuliner');
        $builder->select('kuliner.*, kategori.nama_kategori');
        $builder->join('kategori', 'kategori.id_kategori = kuliner.kategori_id', 'left');

        if ($search) {
            $builder->groupStart()
                    ->like('kuliner.nama', $search)
                    ->orLike('kuliner.alamat', $search)
                    ->groupEnd();
        }

        if ($kategori) {
            $builder->where('kuliner.kategori_id', $kategori);
        }

        $kulinerData = $builder->get()->getResultArray();

        // Ambil data review & rating per lokasi secara dinamis tanpa merusak baris tabel utama
        foreach ($kulinerData as $index => $k) {
            $review = $this->db->table('review')
                               ->where('kuliner_id', $k['id'])
                               ->orderBy('id', 'DESC')
                               ->get()
                               ->getRowArray();
            
            $kulinerData[$index]['rating'] = $review['rating'] ?? 0;
            $kulinerData[$index]['review_text'] = $review['isi'] ?? '-';
        }

        return $kulinerData;
    }
}