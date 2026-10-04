<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'is_active', 'head'];

    public function jobPositions()
    {
        return $this->hasMany(JobPosition::class);
    }

    /**
     * The department head. `head` stores the user's id.
     */
    public function headUser()
    {
        return $this->belongsTo(User::class, 'head');
    }

    /**
     * Employees whose job position belongs to this department.
     */
    public function employees()
    {
        return $this->hasManyThrough(EmployeeProfile::class, JobPosition::class);
    }
}
