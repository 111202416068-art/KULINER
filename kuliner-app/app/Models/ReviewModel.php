<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'review';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kuliner_id', 'user_id', 'rating', 'isi'];
}