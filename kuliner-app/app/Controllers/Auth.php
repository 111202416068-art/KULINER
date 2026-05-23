<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/kuliner');
        }
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $db = \Config\Database::connect();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Membaca data user dari tabel 'users'
        $user = $db->table('users')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Verifikasi kesesuaian password
        if (password_verify($password, $user['password'])) {
            $passwordValid = true;
        } else {
            $passwordValid = ($user['password'] === $password);
        }

        if (!$passwordValid) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // 🔥 KUNCI OTOMATIS ROLE USER (ANTI-TABRAKAN)
        // Jika username-nya adalah 'admin', maka set role sebagai 'admin'.
        // Jika selain itu (akun baru hasil daftar), paksa role-nya menjadi 'user' secara mutlak!
        $roleFix = ($user['username'] === 'admin' || (isset($user['role']) && $user['role'] === 'admin')) ? 'admin' : 'user';


        session()->set([
            'id'           => $user['id'] ?? $user['id_user'] ?? 1,
            'username'     => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'] ?? $user['username'], // <-- TAMBAHKAN INI biar nama aslinya kesimpan
            'role'         => $roleFix,
            'logged_in'    => true
        ]);

        return redirect()->to('/kuliner');
    }

    public function logout()
    {
        session()->destroy();
        // DISINKRONKAN: Diarahkan ke rute login asli, bukan /auth
        return redirect()->to('/login');
    }

    // Fungsi pembuat akun admin lama (nama diubah agar anti-tabrakan/anti-redeclare)
    public function buatAdmin()
    {
        $model = new UserModel();
        $model->save([
            'username'     => 'admin',
            'nama_lengkap' => 'Administrator',
            'password'     => '123',
            'role'         => 'admin'
        ]);

        echo "User admin berhasil dibuat. Silakan login.";
    }

    // Tampilkan halaman form register resmi untuk User
    public function register()
    {
        return view('auth/register');
    }

    // Eksekusi simpan akun baru ke database (Versi Bypass Kolom Email)
    public function saveRegister()
    {
        $db = \Config\Database::connect();

        $nama     = $this->request->getPost('nama_lengkap');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // AMAN: Kita cek ketersediaan akun berdasarkan USERNAME saja, tidak memanggil kolom email
        $cek = $db->table('users')->where('username', $username)->get()->getRowArray();
        if ($cek) {
            return redirect()->back()->with('error', 'Username sudah terdaftar! Gunakan username yang lain.');
        }

        // Simpan data ke tabel users tanpa memasukkan kolom email
        $db->table('users')->insert([
            'nama_lengkap' => $nama,
            'username'     => $username,
            'password'     => password_hash($password, PASSWORD_DEFAULT),
            'role'         => 'user'
        ]);

        // DISINKRONKAN: Mengarahkan kembali ke halaman login asli (/login) dengan pesan sukses
        return redirect()->to('/login')->with('success', 'Akun berhasil dibuat! Silakan login menggunakan username baru Anda.');
    }
}
