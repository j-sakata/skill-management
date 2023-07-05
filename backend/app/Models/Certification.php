<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\CertificationAcquisition;

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

    public function acquisition()
    {
        return $this->hasMany(CertificationAcquisition::class);
    }
}