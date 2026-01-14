<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderContent extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'subtitle',
        'show_button',
        'button_text',
        'button_url',
        'is_active',
    ];


    protected $casts = [
        'show_button' => 'boolean',
        'is_active' => 'boolean',
    ];
}
