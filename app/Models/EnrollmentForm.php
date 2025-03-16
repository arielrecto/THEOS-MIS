<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentForm extends Model
{
    use HasFactory;


    protected $fillable = [
        'school_year',
        'grade_level',
        'balik_aral',
        'last_name',
        'first_name',
        'middle_name',
        'extension_name',
        'birthdate',
        'birthplace',
        'house_no',
        'street',
        'barangay',
        'city',
        'province',
        'zip_code',
        'perm_house_no',
        'perm_street',
        'perm_barangay',
        'perm_city',
        'perm_province',
        'perm_zip_code',
        'parent_name',
        'relationship',
        'contact_number',
        'occupation',
        'preferred_track',
        'preferred_strand',
        'modality',
        'academic_year_id',
        'enrollment_id',
        'status',
        'email',
        'user_id',
    ];

    protected $casts = [
        'modality' => 'array',
    ];


    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
