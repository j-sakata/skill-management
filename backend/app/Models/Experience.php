<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\ExperienceContent;
use App\Models\TechnicalSkill;
use App\Models\ExperiencePhase;

class Experience extends CustomModel
{
    protected $fillable = [
        'user_id',
        'company_name'
    ];

    public function experience_content()
    {
        return $this->hasOne(ExperienceContent::class);
    }

    public function technical_skill()
    {
        return $this->hasMany(TechnicalSkill::class);
    }

    public function experience_phase()
    {
        return $this->hasManyThrough(ExperiencePhase::class, ExperienceContent::class);
    }
}