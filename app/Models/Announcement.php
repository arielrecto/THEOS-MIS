<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'classroom_id',
        'file_dir'
    ];


    public function classroom (){
        return $this->belongsTo(Classroom::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
