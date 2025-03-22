<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'posted_by',
        'is_posted'
    ];


    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
