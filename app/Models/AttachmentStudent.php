<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentStudent extends Model
{
    use HasFactory;


    protected $fillable = [
        'file_dir',
        'type',
        'name',
        'extension',
        'student_task_id'
    ];

    public function studentTask(){
        return $this->belongsTo(StudentTask::class);
    }
}




