<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Payment extends BaseController
{
    private $serverKey = 'SB-Mid-server-YOUR_SERVER_KEY';
    private $clientKey = 'SB-Mid-client-YOUR_CLIENT_KEY';

    // 1. Tampilkan halaman konfirmasi pemesanan dengan nominal dinamis dari admin
    public function beli($kuliner_id)
    {
        $db = \Config\Database::connect();
        $kuliner = $db->table('kuliner')->where('id', $kuliner_id)->get()->getRowArray();

        if (!$kuliner) {
            return redirect()->to('/kuliner')->with('error', 'Data kuliner tidak ditemukan.');
        }

        return view('payment/konfirmasi', [
            'title'   => 'Konfirmasi Pesanan Voucher',
            'kuliner' => $kuliner
        ]);
    }

    // 2. Fungsi eksekusi setelah user klik "Lanjut Pembayaran" di halaman konfirmasi
    public function proses($kuliner_id)
    {
        $db = \Config\Database::connect();
        $kuliner = $db->table('kuliner')->where('id', $kuliner_id)->get()->getRowArray();

        if (!$kuliner) {
            return redirect()->to('/kuliner')->with('error', 'Data kuliner tidak ditemukan.');
        }

        // Nominal otomatis mengikuti harga_voucher terbitan Admin dari database!
        $nominalVoucher = (int)($kuliner['harga_voucher'] ?? 50000);
        $jumlahInput    = (int)$this->request->getPost('jumlah') ?? 1;
        $totalBayar     = $nominalVoucher * $jumlahInput;
        
        // SINKRONISASI LOGIKA: Menangkap inputan nomor WhatsApp asli dari form konfirmasi
        $noWhatsApp     = $this->request->getPost('whatsapp') ?? '081234567890';

        $orderId = 'VCH-' . time() . '-' . (session('id') ?? 1);

        try {
            $db->table('transaksi')->insert([
                'order_id'     => $orderId,
                'user_id'      => (int)(session('id') ?? 1),
                'kuliner_id'   => (int)$kuliner_id,
                'nominal'      => $totalBayar,
                'status_bayar' => 'settlement',
                'created_at'   => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Gagal catat db: ' . $e->getMessage());
        }

        // Mengirimkan notifikasi simulasi menggunakan nomor HP yang diinput user
        $this->kirimNotifikasiWA($orderId, $noWhatsApp);

        echo "<html><head>
                <title>Simulasi Payment Gateway</title>
                <link rel='preconnect' href='https://fonts.googleapis.com'>
                <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
                <link href='https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap' rel='stylesheet'>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css' rel='stylesheet'>
                <style>
                    body { background-color: #FDFBF7; font-family: 'Plus Jakarta Sans', sans-serif; color: #4A3E3D; }
                    .card-struk { width: 460px; border-radius: 24px !important; border: none !important; box-shadow: 0 10px 30px rgba(140, 98, 57, 0.06) !important; background: #FFFFFF; }
                    .text-moka { color: #8C6239 !important; }
                    .bg-moka { background-color: #8C6239 !important; color: white !important; }
                    .bg-moka:hover { background-color: #734F2D !important; }
                    .bg-light-warm { background-color: #FDF5EE !important; border: 1px solid #FADCC3 !important; color: #8C6239 !important; }
                </style>
              </head><body class='d-flex align-items-center justify-content-center vh-100'>
                <div class='card card-struk p-4 text-center'>
                    <div class='text-success mb-3'><i class='bi bi-check-circle-fill' style='font-size: 3.5rem; color: #198754;'></i></div>
                    <h4 class='fw-bold text-dark mb-1'>Transaksi Berhasil!</h4>
                    <p class='text-muted small mb-4'>Midtrans Sandbox Automated Simulation Mode</p>
                    
                    <div class='p-3 text-start mb-3 rounded-3' style='background-color: #FDFBF7; border: 1px solid #F5EBE6; font-size: 0.9rem;'>
                        <div class='d-flex justify-content-between mb-2'><span>Order ID:</span><strong class='text-dark font-monospace'>" . $orderId . "</strong></div>
                        <div class='d-flex justify-content-between mb-2'><span>Item:</span><strong class='text-dark'>Voucher " . $kuliner['nama'] . " (x" . $jumlahInput . ")</strong></div>
                        <div class='d-flex justify-content-between mb-2'><span>Total Bayar:</span><strong class='text-moka fw-bold'>Rp " . number_format($totalBayar, 0, ',', '.') . "</strong></div>
                        <div class='d-flex justify-content-between'><span>Status:</span><span class='badge bg-success-subtle text-success border px-2.5 py-1 rounded-pill text-uppercase' style='font-size: 11px;'>Settlement (Paid)</span></div>
                    </div>
                    
                    <div class='alert alert-info bg-light-warm py-2.5 small text-start mb-4' style='border-radius: 12px; border: 1px solid #E6D5CC;'>
                        <i class='bi bi-whatsapp me-1 text-success fw-bold'></i> Notifikasi simulasi kode voucher belanja sukses dikirimkan ke nomor WhatsApp: <strong class='text-dark'>" . htmlspecialchars($noWhatsApp) . "</strong>.
                    </div>
                    
                    <a href='/payment/riwayat' class='btn bg-moka w-100 fw-bold py-2.5 shadow-sm' style='border-radius: 12px;'>Lihat Riwayat Voucher</a>
                </div>
              </body></html>";
        exit;
    }

    public function riwayat()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $userId = session()->get('id') ?? 1;

        $data['title'] = 'Riwayat Voucher';
        $data['transaksi'] = $db->table('transaksi')
                                ->select('transaksi.*, kuliner.nama as nama_kuliner')
                                ->join('kuliner', 'kuliner.id = transaksi.kuliner_id')
                                ->where('transaksi.user_id', $userId)
                                ->orderBy('transaksi.created_at', 'DESC')
                                ->get()
                                ->getResultArray();

        return view('payment/riwayat', $data);
    }

    private function kirimNotifikasiWA($orderId, $noWhatsApp)
    {
        try {
            $pesan = "Halo! Pembayaran voucher dengan ID *$orderId* telah BERHASIL diterima. No WA Tujuan: $noWhatsApp. Silakan tunjukkan pesan ini ke kasir outlet kuliner. Terima kasih!";
            log_message('info', 'Simulasi WA Berhasil: ' . $pesan);
        } catch (\Exception $e) {
            log_message('error', 'Gagal kirim WA: ' . $e->getMessage());
        }
    }
}