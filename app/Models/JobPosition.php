<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department_id',
        'type',
        'min_salary',
        'max_salary',
        'status',
        'description',
        'is_hiring'
    ];

    protected $casts = [
        'is_hiring' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function applicants()
    {
        return $this->hasMany(JobApplicant::class);
    }

    public function employees()
    {
        return $this->hasMany(EmployeeProfile::class );
    }
}
