<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevelSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'strand_id',
        'subject_id'
    ];



    public function strand(){
        return $this->belongsTo(Strand::class);
    }


    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
