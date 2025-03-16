<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'score',
        'status',
    ];



    public function user(){
        return $this->belongsTo(User::class);
    }

    public function task() {
        return $this->belongsTo(Task::class);
    }
    public function attachments(){
        return $this->hasMany(AttachmentStudent::class);
    }
}
