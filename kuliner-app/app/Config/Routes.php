<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::login');

$routes->get('login', 'Auth::login');
$routes->post('auth/prosesLogin', 'Auth::prosesLogin');
$routes->get('auth/logout', 'Auth::logout');

$routes->get('auth/login', 'Auth::login');
$routes->post('auth/prosesLogin', 'Auth::prosesLogin');
$routes->get('auth/logout', 'Auth::logout');

$routes->get('pengunjung', 'Auth::pengunjung');

// ROUTE KULINER

$routes->get('kuliner', 'Kuliner::index');
$routes->get('kuliner/create', 'Kuliner::create');
$routes->post('kuliner/save', 'Kuliner::save');

$routes->get('kuliner/edit/(:num)', 'Kuliner::edit/$1');
$routes->post('kuliner/update/(:num)', 'Kuliner::update/$1');

$routes->get('kuliner/delete/(:num)', 'Kuliner::delete/$1');

$routes->get('kuliner/detail/(:num)', 'Kuliner::detail/$1');


// ROUTE KATEGORI

$routes->get('kategori', 'Kategori::index');

$routes->get('kategori/create', 'Kategori::create');
$routes->post('kategori/save', 'Kategori::save');

$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');

$routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');


// ROUTE PROFIL

$routes->get('profil', 'Profil::index');


// ROUTE STATISTIK

$routes->get('laporan', 'Statistik::index');
$routes->get('statistik', 'Statistik::index');

// ROUTE REVIEW

$routes->post('review/save', 'Review::save');


// ROUTE FILTER AUTH

$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Kuliner
    $routes->get('kuliner/create', 'Kuliner::create');
    $routes->post('kuliner/save', 'Kuliner::save');

    $routes->get('kuliner/edit/(:num)', 'Kuliner::edit/$1');
    $routes->post('kuliner/update/(:num)', 'Kuliner::update/$1');

    $routes->get('kuliner/delete/(:num)', 'Kuliner::delete/$1');


    // Profil
    $routes->get('profil', 'Profil::index');


    // Jelajah
    $routes->get('jelajah', 'Jelajah::index');
    $routes->get('jelajah/detail/(:num)', 'Jelajah::detail/$1');


    // API
    $routes->get('api/kuliner', 'Api\KulinerApi::index');


    // Payment
    $routes->get('payment/beli/(:num)', 'Payment::beliVoucher/$1');
    $routes->post('payment/notification', 'Payment::notification');
});
