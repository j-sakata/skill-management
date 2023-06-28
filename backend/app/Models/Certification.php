<?php

namespace App\Models;

use App\Models\CustomModel;

class Certification extends CustomModel
{
    protected $fillable = [
        'name',
        'user_id',
        'certification_number',
        'expiration',
        'memo',
        'category',
        'sub_category'
    ];
}