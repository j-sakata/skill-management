<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\CertificationAcquisition;

class Certification extends CustomModel
{
    protected $fillable = [
        'certification_name',
        'user_id',
        'certification_number',
        'certification_expiration',
        'certification_memo',
        'certification_category',
        'certification_sub_category'
    ];

    public function acquisition()
    {
        return $this->hasMany(CertificationAcquisition::class);
    }
}