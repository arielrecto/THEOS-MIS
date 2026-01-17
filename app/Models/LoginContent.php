<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginContent extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];


    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function backgroundImage()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

}
