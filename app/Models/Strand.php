<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strand extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'acronym',
        'descriptions'
    ];



    public function classrooms(){
        return $this->hasMany(Classroom::class);
    }


}
