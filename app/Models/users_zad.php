<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users_zad extends Model
{
     public $timestamps = true;
     protected $fillable = [
        'name',
        'email',
        'phone',
        'opisanie',
        'status',
        'arhiv'
    ];
     protected $casts = [
        'arhiv' => 'boolean', // ← это ключевое!
    ];
}
