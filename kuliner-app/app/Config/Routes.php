<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('auth/prosesLogin', 'Auth::prosesLogin');
$routes->get('auth/logout', 'Auth::logout');

$routes->get('kuliner', 'Kuliner::index');
$routes->get('kuliner/create', 'Kuliner::create');
$routes->post('kuliner/save', 'Kuliner::save');
$routes->get('kuliner/edit/(:num)', 'Kuliner::edit/$1');
$routes->post('kuliner/update/(:num)', 'Kuliner::update/$1');
$routes->get('kuliner/delete/(:num)', 'Kuliner::delete/$1');

$routes->get('auth/login', 'Auth::login');
$routes->post('auth/prosesLogin', 'Auth::prosesLogin');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('pengunjung', 'Auth::pengunjung');

$routes->get('kategori', 'Kategori::index');
$routes->get('kategori/create', 'Kategori::create');
$routes->post('kategori/save', 'Kategori::save');

$routes->get('profil', 'Profil::index');


$routes->get('laporan', 'Statistik::index');
$routes->get('statistik', 'Statistik::index');


$routes->get('kuliner/detail/(:num)', 'Kuliner::detail/$1');
$routes->post('review/save', 'Review::save');


$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('kuliner/create', 'Kuliner::create');
    $routes->post('kuliner/save', 'Kuliner::save');
    $routes->get('kuliner/edit/(:num)', 'Kuliner::edit/$1');
    $routes->post('kuliner/update/(:num)', 'Kuliner::update/$1');
    $routes->delete('kuliner/(:num)', 'Kuliner::delete/$1');

    $routes->get('profil', 'Profil::index');

    $routes->get('jelajah', 'Jelajah::index');
    $routes->get('jelajah/detail/(:num)', 'Jelajah::detail/$1');
});
