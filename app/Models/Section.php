<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'strand_id',
        'grade_level',
        'capacity',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function strand()
    {
        return $this->belongsTo(Strand::class);
    }

    public function academicRecords()
    {
        return $this->hasMany(AcademicRecord::class);
    }

    public function students()
    {
        return $this->hasManyThrough(
            StudentProfile::class,
            AcademicRecord::class,
            'section_id',
            'id',
            'id',
            'student_profile_id'
        );
    }

    public function getStudentCountAttribute()
    {
        return $this->academicRecords()->distinct('student_profile_id')->count();
    }

    public function getAvailableSlotsAttribute()
    {
        return $this->capacity - $this->student_count;
    }
}
