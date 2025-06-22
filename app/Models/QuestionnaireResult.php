<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireResult extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'skor', 'minat'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
