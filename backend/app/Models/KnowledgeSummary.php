<?php

namespace App\Models;

use App\Models\CustomModel;
use App\Models\Experience;

class KnowledgeSummary extends CustomModel
{
    protected $fillable = [
        'knowledge'
    ];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
}