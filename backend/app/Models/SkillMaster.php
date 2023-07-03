<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\TechnicalSkill;

class SkillMaster extends CustomModel
{
    protected $fillable = [
        'name',
        'status',
        'category'
    ];
}