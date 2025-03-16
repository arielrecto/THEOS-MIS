<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;


    protected $fillable = [
        'lrn',
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
        'email',
        'user_id',
    ];

    protected $casts = [
        'modality' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function academicRecords()
    {
        return $this->hasMany(AcademicRecord::class);
    }
}
