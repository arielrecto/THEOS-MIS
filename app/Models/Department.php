<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'is_active', 'head'];

    public function jobPositions()
    {
        return $this->hasMany(JobPosition::class);
    }
}
