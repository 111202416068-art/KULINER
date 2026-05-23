<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================================
// 🔐 Rute Autentikasi Utama & Gerbang Masuk
// ==========================================
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->get('auth', 'Auth::login');
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/prosesLogin', 'Auth::prosesLogin');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/saveRegister', 'Auth::saveRegister');

// ==========================================
// 🏠 Rute Dashboard & Manajemen CRUD Tempat Kuliner (Admin)
// ==========================================
$routes->get('kuliner', 'Kuliner::index');
$routes->get('kuliner/create', 'Kuliner::create');
$routes->post('kuliner/save', 'Kuliner::save');
$routes->get('kuliner/edit/(:num)', 'Kuliner::edit/$1');
$routes->post('kuliner/update/(:num)', 'Kuliner::update/$1');
$routes->get('kuliner/delete/(:num)', 'Kuliner::delete/$1');
$routes->get('kuliner/detail/(:num)', 'Kuliner::detail/$1');

// ==========================================
// 🏷️ Rute Manajemen Kategori (Admin)
// ==========================================
$routes->get('kategori', 'Kategori::index');
$routes->post('kategori/save', 'Kategori::save');
$routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');

// ==========================================
// 👤 Rute Profil, Statistik, & Fitur Ulasan
// ==========================================
$routes->get('profil', 'Profil::index');
$routes->get('laporan', 'Statistik::index');
$routes->get('statistik', 'Statistik::index');
$routes->post('review/save', 'Review::save');

// ==========================================
// 🧭 Rute Direktori Jelajah Kuliner & API (User/Pengunjung)
// ==========================================
$routes->get('jelajah', 'Jelajah::index');
$routes->get('jelajah/detail/(:num)', 'Jelajah::detail/$1');
$routes->get('api/kuliner', 'Api\KulinerApi::index');

// ==========================================
// 🎫 Rute Sistem Voucher & Gateway Transaksi Midtrans
// ==========================================
$routes->get('payment/beli/(:num)', 'Payment::beli/$1');
$routes->post('payment/notification', 'Payment::notification');
$routes->post('payment/proses/(:num)', 'Payment::proses/$1');
$routes->get('payment/riwayat', 'Payment::riwayat');

// ==========================================
// 🛡️ Filter Proteksi Keamanan Session Login
// ==========================================
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Ruang rute terproteksi filter jika diperlukan
});