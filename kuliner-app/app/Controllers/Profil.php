<?php

namespace App\Controllers;

class Profil extends BaseController
{
    public function index()
    {
        $data = [
            'nama' => 'BUDI HANDOKO',
            'email' => 'BHANDOKO@email.com',
            'role' => 'pengunjung',
            'bio' => 'Reviewer kuliner nusantara'
        ];

        return view('profil/index', $data);
    }
}