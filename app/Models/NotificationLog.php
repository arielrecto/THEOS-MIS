<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;


    protected $fillable = [
        'action',
        'type',
        'message',
        'is_read',
        'user_id',
        'notifiable_id',
        'notifiable_type',
        'url',
        'read_at',
    ];
    protected $casts = [
        'is_read' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
