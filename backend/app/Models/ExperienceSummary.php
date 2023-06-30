<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\Experience;

class ExperienceSummary extends CustomModel
{
    protected $fillable = [
        'summary'
    ];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
}