<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\ExperienceContent;

class ExperiencePhase extends CustomModel
{
    protected $fillable = [
        'experience_content_id',
        'phase_id'
    ];

    public function experience_content()
    {
        return $this->belongsTo(ExperienceContent::class);
    }
}