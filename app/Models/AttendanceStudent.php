<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'user_id',
        'classroom_id'
    ];

    public function attendance (){
        return $this->belongsTo(Attendance::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function classroom() {
        return $this->belongsTo(Classroom::class);
    }
}
