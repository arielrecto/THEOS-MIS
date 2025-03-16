<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'description',
        'score',
        'max_score',
        'classroom_id'
    ];

    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }
    public function attachments(){
        return $this->hasMany(AttachmentTask::class);
    }
    public function assignStudents(){
        return $this->hasMany(StudentTask::class);
    }
}
