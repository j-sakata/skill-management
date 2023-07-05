<?php

namespace App\Models;

use App\Models\CustomModel;

class Company extends CustomModel
{
    protected $fillable = [
        'user_id',
        'name',
        'entered_at',
        'ended_at'
    ];
}