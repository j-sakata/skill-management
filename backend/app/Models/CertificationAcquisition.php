<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\Certification;

class CertificationAcquisition extends CustomModel
{
    protected $fillable = [
        'acquisition_date',
        'score',
    ];

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }
}