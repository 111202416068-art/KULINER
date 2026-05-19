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

        $user = $db->table('users')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Catatan: Sebaiknya gunakan password_hash & password_verify untuk keamanan
        if ($user['password'] != $password) {
            return redirect()->back()->with('error', 'Password salah');
        }

        session()->set([
            'id'        => $user['id'], // ID ini yang dipakai buat relasi tabel review
            'username'  => $user['username'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        return redirect()->to('/kuliner');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        // PERBAIKAN: Hapus baris 'id' => $user['id'] karena ID akan otomatis (Auto Increment)
        $model = new UserModel();
        $model->save([
            'username'     => 'admin',
            'nama_lengkap' => 'Administrator',
            'password'     => '123',
            'role'         => 'admin'
        ]);

        echo "User admin berhasil dibuat. Silakan login.";
    }

    public function pengunjung()
    {
        // PERBAIKAN: Jangan pakai ID 0 karena akan error Foreign Key di database.
        // Sebaiknya arahkan pengunjung ke halaman tanpa perlu set session ID dummy.
        session()->set([
            'role'      => 'pengunjung',
            'logged_in' => true
        ]);

        return redirect()->to('/kuliner');
    }
}