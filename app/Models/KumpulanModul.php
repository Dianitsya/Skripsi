<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KumpulanModul extends Model
{
    protected $table = 'modules'; // Menggunakan tabel 'modules' yang sudah ada

    protected $fillable = ['title', 'description', 'file_path', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
