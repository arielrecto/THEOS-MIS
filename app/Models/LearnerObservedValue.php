<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearnerObservedValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'core_value',
        'behavior_statement',
        'quarter_1',
        'quarter_2',
        'quarter_3',
        'quarter_4',
    ];



    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}
