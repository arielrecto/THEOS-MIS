<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'sub_title',
        'path',
        'description',

        // NEW (recommended): split fields
        'vision',
        'mission',

        // Legacy (keep for backward compatibility)
        'mission_and_vision',

        'address',
    ];
}
