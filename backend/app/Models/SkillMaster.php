<?php

namespace App\Models;

use App\Models\CustomModel;

class SkillMaster extends CustomModel
{
    protected $fillable = [
        'skill_name',
        'skill_status',
        'skill_category'
    ];
}