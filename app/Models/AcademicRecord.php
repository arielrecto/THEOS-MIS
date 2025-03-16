<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_year',
        'grade_level',
        'enrollment_id',
        'academic_year_id',
        'student_profile_id',
    ];


    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function studentProfile()
    {
        return $this->belongsTo(StudentProfile::class);
    }
}
