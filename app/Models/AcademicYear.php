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
}
