<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiService extends Model
{
    protected $fillable = ['name', 'attribute'];
    protected $casts = [
        'attribute' => 'array', // Automatically casts attribute to array
    ];
}
