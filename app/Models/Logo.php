<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'type',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
