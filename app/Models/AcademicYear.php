<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
    ];


    public function enrollments(){
        return $this->hasMany(Enrollment::class);
    }

    public function enrollees(){
        return $this->hasMany(EnrollmentForm::class);
    }

    public function academicRecords(){
        return $this->hasMany(AcademicRecord::class);
    }

    public function generateNotificationMessage($academicYear, string $action = 'created'): string
    {
        return match ($action) {
            'created' => "Academic Year {$academicYear->name} has been created.",
            'updated' => "Academic Year {$academicYear->name} has been updated.",
            'activated' => "Academic Year {$academicYear->name} is now active.",
            'deactivated' => "Academic Year {$academicYear->name} has been deactivated.",
            'deleted' => "Academic Year {$academicYear->name} has been deleted.",
            'enrollment_started' => "Enrollment for Academic Year {$academicYear->name} has started.",
            'enrollment_ended' => "Enrollment for Academic Year {$academicYear->name} has ended.",
            default => "Academic Year {$academicYear->name} notification."
        };
    }
}
