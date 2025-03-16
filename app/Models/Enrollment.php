<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'academic_year_id',
        'start_date',
        'end_date',
        'status',
        'description',
    ];


    public function academicYear(){
        return $this->belongsTo(AcademicYear::class);
    }

    public function enrollees(){
        return $this->hasMany(EnrollmentForm::class);
    }

    public function academicRecords(){
        return $this->hasMany(AcademicRecord::class);
    }
}
