<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\ExperienceSummary;
use App\Models\KnowledgeSummary;
use App\Models\ExperienceContent;
use App\Models\TechnicalSkill;

class Experience extends CustomModel
{
    protected $fillable = [
        'user_id'
    ];

    public function experience_summary()
    {
        return $this->hasOne(ExperienceSummary::class);
    }

    public function knowledge_summary()
    {
        return $this->hasOne(KnowledgeSummary::class);
    }

    public function experience_content()
    {
        return $this->hasOne(ExperienceContent::class);
    }

    public function technical_skill()
    {
        return $this->hasMany(TechnicalSkill::class);
    }
}