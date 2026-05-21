<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Payment extends BaseController
{
    // Silakan ganti dengan Key dari akun Midtrans Sandbox milikmu jika ada
    private $serverKey = 'SB-Mid-server-YOUR_SERVER_KEY';
    private $clientKey = 'SB-Mid-client-YOUR_CLIENT_KEY';

    public function beliVoucher($kuliner_id)
    {
        $db = \Config\Database::connect();
        $kuliner = $db->table('kuliner')->where('id', $kuliner_id)->get()->getRowArray();

        if (!$kuliner) {
            return redirect()->back()->with('error', 'Data kuliner tidak ditemukan.');
        }

        // AMAN: Langsung ambil dari helper session global bawaan CI4.
        // Jika session kosong (belum login), otomatis pakai angka 1 tanpa bikin variabel crash.
        $orderId = 'VCH-' . time() . '-' . (session('id') ?? 1);
        $nominal = 50000;

        // Simpan data transaksi awal dengan status 'pending' ke database
        $db->table('transaksi')->insert([
            'order_id'     => $orderId,
            'user_id'      => (int)(session('id') ?? 1),
            'kuliner_id'   => (int)$kuliner_id,
            'nominal'      => $nominal,
            'status_bayar' => 'pending',
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        // Siapkan parameter payload JSON untuk dikirim ke Midtrans API
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $nominal,
            ],
            'item_details' => [
                [
                    'id'       => $kuliner_id,
                    'price'    => $nominal,
                    'quantity' => 1,
                    'name'     => 'Voucher ' . ($kuliner['nama'] ?? 'Outlet')
                ]
            ],
            'customer_details' => [
                'first_name' => session('nama_lengkap') ?? 'Moorlaila Student',
                'email'      => 'customer@udinus.ac.id',
            ]
        ];

        // Request Snap Token ke Midtrans menggunakan cURL bawaan CodeIgniter 4
        $auth = base64_encode($this->serverKey . ':');
        $client = \Config\Services::curlrequest();

        try {
            $response = $client->request('POST', 'https://app.sandbox.midtrans.com/snap/v1/transactions', [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Basic ' . $auth
                ],
                'json' => $params
            ]);

            $result = json_decode($response->getBody(), true);

            return view('payment/checkout', [
                'snapToken' => $result['token'] ?? '',
                'clientKey' => $this->clientKey,
                'kuliner'   => $kuliner,
                'nominal'   => $nominal
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal terhubung ke gateway pembayaran Midtrans.');
        }
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
