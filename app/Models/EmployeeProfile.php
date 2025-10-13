<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'date_of_birth',
        'salary',
        'job_position_id', // Keep this
        'photo',
        'leave_credit',
        'status'
    ];

    // Remove 'position' and 'department' from fillable as they are relationship names

    protected $casts = [
        'date_of_birth' => 'date',
        'salary' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, foreignKey: 'user_id');
    }

    public function position()
    {
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }
    public function department()
    {
        return $this->hasOneThrough(Department::class, JobPosition::class, 'id', 'id', 'job_position_id', 'department_id');
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}
