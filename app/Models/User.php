<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'category_id', 'is_admin', 'minat', 'gaya_belajar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function todos(){
        return $this->hasMany(Todo:: class);
    }
    public function isAdmin()
{
    return $this->is_admin === true;  // jika menggunakan is_admin
    // ATAU
    // return $this->role === 'admin';  // jika menggunakan role
}
public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

public function questionnaireResult(): HasOne
    {
        return $this->hasOne(QuestionnaireResult::class, 'user_id');
    }

    public function learningStyleResult(): HasOne
    {
        return $this->hasOne(LearningStyleResult::class, 'user_id');
    }

}
