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
        'grade_id',
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

    public function getScorePercentageAttribute()
    {
        if (!$this->score || !$this->task || !$this->task->max_score) {
            return 0;
        }

        return ($this->score / $this->task->max_score) * 100;
    }
    public function grade(){
        return $this->belongsTo(Grade::class);
    }
}
