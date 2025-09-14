<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'image',
        'sex',
        'address',
        'contact_no',
        'user_id'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function profilePicture(){
        return $this->morphOne(Attachment::class, 'attachable')->latest();
    }
}
