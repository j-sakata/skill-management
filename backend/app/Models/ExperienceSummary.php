<?php

namespace App\Models;

use App\Models\CustomModel;

class ExperienceSummary extends CustomModel
{
    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'status'
    ];
}