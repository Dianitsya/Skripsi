<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningStyleResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'visual_score',
        'auditory_score',
        'kinesthetic_score',
        'dominant_style'
    ];
}
