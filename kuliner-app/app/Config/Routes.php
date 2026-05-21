<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute Autentikasi (Bebas Akses)
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/prosesLogin', 'Auth::prosesLogin');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('pengunjung', 'Auth::pengunjung');

// Rute Dashboard & Fitur Utama CRUD
$routes->get('kuliner', 'Kuliner::index');
$routes->get('kuliner/create', 'Kuliner::create');
$routes->post('kuliner/save', 'Kuliner::save');
$routes->get('kuliner/edit/(:num)', 'Kuliner::edit/$1');
$routes->post('kuliner/update/(:num)', 'Kuliner::update/$1');
$routes->get('kuliner/delete/(:num)', 'Kuliner::delete/$1');
$routes->get('kuliner/detail/(:num)', 'Kuliner::detail/$1');

// Rute Manajemen Lainnya
$routes->get('kategori', 'Kategori::index');
$routes->get('kategori/create', 'Kategori::create');
$routes->post('kategori/save', 'Kategori::save');
$routes->get('profil', 'Profil::index');
$routes->get('laporan', 'Statistik::index');
$routes->get('statistik', 'Statistik::index');
$routes->post('review/save', 'Review::save');

// Rute Fitur Jelajah & API
$routes->get('jelajah', 'Jelajah::index');
$routes->get('jelajah/detail/(:num)', 'Jelajah::detail/$1');
$routes->get('api/kuliner', 'Api\KulinerApi::index');

// Rute Gateway Pembayaran Midtrans & Webhook Notifikasi WA (Dilepas dari Group agar Lancar)
$routes->get('payment/beli/(:num)', 'Payment::beliVoucher/$1');
$routes->post('payment/notification', 'Payment::notification');

// Rute Khusus Filter Terproteksi (Jika diperlukan nanti)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Ruang modifikasi akun terproteksi
});
