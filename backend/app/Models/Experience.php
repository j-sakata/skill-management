<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\Company;

class Experience extends CustomModel
{
    protected $fillable = [
        'user_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}