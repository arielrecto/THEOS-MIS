<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicProgram extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'path',
        'description',
        'is_active',
        'category'
    ];
}
