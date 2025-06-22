<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $table = 'categories';

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    public function questionnaires()
{
    return $this->hasMany(Questionnaire::class);
}
}
