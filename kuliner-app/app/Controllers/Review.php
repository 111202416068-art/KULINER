<?php

namespace App\Controllers;

use App\Models\ReviewModel;

class Review extends BaseController
{
    public function save()
    {
        $reviewModel = new \App\Models\ReviewModel();

        $reviewModel->save([
            'kuliner_id' => $this->request->getPost('kuliner_id'),
            'user_id'    => session()->get('id'),
            'rating'     => $this->request->getPost('rating'),
            'isi'        => $this->request->getPost('isi')
        ]);
        return redirect()->back();
    }
}
