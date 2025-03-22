<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'quarter',
        'grade',
        'remarks',
        'status',
        'created_by',
        'classroom_id',
        'subject',
        'academic_record_id',
    ];


    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }

    public function academicRecord(){
        return $this->belongsTo(AcademicRecord::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function gradedTasks(){
        return $this->hasMany(StudentTask::class);
    }
}
