<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\Experience;

class ExperienceContent extends CustomModel
{
    protected $fillable = [
        'started_at',
        'ended_at',
        'industry',
        'project_name',
        'project_summary',
        'phase',
        'description',
        'achievement',
        'member_count',
        'position',
        'company_name',
        'contract_type'
    ];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
}