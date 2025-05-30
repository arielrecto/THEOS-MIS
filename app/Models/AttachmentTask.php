<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'type',
        'extension',
        'task_id'
    ];


    public function task(){
        return $this->belongsTo(Task::class);
    }
}
