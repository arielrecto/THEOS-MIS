<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_profile_id',
        'time_in',
        'time_out',
    ];
    protected $casts = [
        'time_in' => 'datetime',
        'time_out' => 'datetime',
    ];


    public function employee()
    {
        return $this->belongsTo(EmployeeProfile::class, 'employee_profile_id');
    }
}
