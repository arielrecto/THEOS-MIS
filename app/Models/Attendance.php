<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;


    protected $fillable = [
        'attendance_code',
        'classroom_id',
        'date',
        'start_time',
        'end_time'
    ];


    public function classroom (){
        return $this->belongsTo(Classroom::class);
    }

    public function attendanceStudents(){
        return $this->hasMany(AttendanceStudent::class);
    }
}
