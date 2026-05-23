<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Payment extends BaseController
{
    // Silakan ganti dengan Key dari akun Midtrans Sandbox milikmu jika ada
    private $serverKey = 'SB-Mid-server-YOUR_SERVER_KEY';
    private $clientKey = 'SB-Mid-client-YOUR_CLIENT_KEY';

    // DISELARASKAN: Nama fungsi diubah menjadi 'beli' agar cocok dengan rute /payment/beli/
    // 1. Tampilkan halaman konfirmasi pemesanan terlebih dahulu
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

        $nominalInput = (int)$this->request->getPost('nominal') ?? 50000;
        $jumlahInput  = (int)$this->request->getPost('jumlah') ?? 1;
        $totalBayar   = $nominalInput * $jumlahInput;

        $orderId = 'VCH-' . time() . '-' . (session('id') ?? 1);

        try {
            $db->table('transaksi')->insert([
                'order_id'     => $orderId,
                'user_id'      => (int)(session('id') ?? 1),
                'kuliner_id'   => (int)$kuliner_id,
                'nominal'      => $totalBayar,
                'status_bayar' => 'pending',
                'created_at'   => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Gagal catat db: ' . $e->getMessage());
        }

        // Tampilkan Struk Sukses Otomatis
        $this->kirimNotifikasiWA($orderId);

        echo "<html><head>
                <title>Simulasi Payment Gateway</title>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css' rel='stylesheet'>
              </head><body class='bg-light d-flex align-items-center justify-content-center vh-100'>
                <div class='card shadow border-0 p-4 text-center' style='width: 450px; border-radius: 12px;'>
                    <div class='text-success mb-3'><i class='bi bi-check-circle-fill' style='font-size: 3.5rem;'></i></div>
                    <h4 class='fw-bold text-dark mb-1'>Transaksi Berhasil!</h4>
                    <p class='text-muted small'>Midtrans Sandbox Automated Simulation Mode</p>
                    <div class='bg-light p-3 my-3 text-start' style='border-radius: 8px; font-size: 0.9rem;'>
                        <div class='d-flex justify-content-between mb-1'><span>Order ID:</span><strong class='text-dark'>" . $orderId . "</strong></div>
                        <div class='d-flex justify-content-between mb-1'><span>Item:</span><strong class='text-dark'>Voucher " . $kuliner['nama'] . " (x" . $jumlahInput . ")</strong></div>
                        <div class='d-flex justify-content-between mb-1'><span>Total:</span><strong class='text-primary'>Rp " . number_format($totalBayar, 0, ',', '.') . "</strong></div>
                        <div class='d-flex justify-content-between'><span>Status:</span><span class='badge bg-success'>Settlement (Paid)</span></div>
                    </div>
                    <div class='alert alert-info py-2 small text-start mb-3'><i class='bi bi-whatsapp me-1 text-success'></i> Notifikasi simulasi kode voucher WhatsApp telah dikirimkan ke log sistem.</div>
                    <a href='/kuliner' class='btn btn-primary w-100 fw-bold' style='border-radius: 6px;'>Kembali ke Dashboard</a>
                </div>
              </body></html>";
        exit;
    }

    private function kirimNotifikasiWA($orderId)
    {
        try {
            $pesan = "Halo! Pembayaran voucher dengan ID *$orderId* telah BERHASIL diterima. Silakan tunjukkan pesan ini ke kasir outlet kuliner. Terima kasih!";
            log_message('info', 'Simulasi WA Berhasil: ' . $pesan);
        } catch (\Exception $e) {
            log_message('error', 'Gagal kirim WA: ' . $e->getMessage());
        }
    }
}
