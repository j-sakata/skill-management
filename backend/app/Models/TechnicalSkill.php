<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\Experience;

class TechnicalSkill extends CustomModel
{
    protected $fillable = [
        'skill_id',
    ];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
}