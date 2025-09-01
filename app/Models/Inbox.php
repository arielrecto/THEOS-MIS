<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'message',
        'is_read',
    ];

    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }
}
