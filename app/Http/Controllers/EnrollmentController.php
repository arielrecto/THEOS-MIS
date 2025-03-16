<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\EnrollmentForm;
use App\Enums\AcademicYearStatus;

class EnrollmentController extends Controller
{
   public function show(string $id) {
        $enrollment = Enrollment::findOrFail($id);
        return view('enrollees.enrollment', compact('enrollment'));
   }

   public function form(Request $request){

    $enrollmentID  = $request->enrollment;


    $academicYear = AcademicYear::where('status', AcademicYearStatus::Active->value)->first();

    return view('enrollees.form', compact(['academicYear', 'enrollmentID']));
   }

   public function store(Request $request) {
        $request->validate([
            'school_year' => 'required',
            'grade_level' => 'required',
            'balik_aral' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'extension_name' => 'required',
            'birthdate' => 'required',
            'birthplace' => 'required',
            'house_no' => 'required',
            'street' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zip_code' => 'required',
            'perm_house_no' => 'required',
            'perm_street' => 'required',
            'perm_barangay' => 'required',
            'perm_city' => 'required',
            'perm_province' => 'required',
            'perm_zip_code' => 'required',
            'parent_name' => 'required',
            'relationship' => 'required',
            'contact_number' => 'required',
            'occupation' => 'required',
            'preferred_track' => 'required',
            'preferred_strand' => 'required',
            'modality' => 'required',
            'email' => 'required',
        ]);

        $enrollment = EnrollmentForm::create([
            'school_year' => $request->school_year,
            'grade_level' => $request->grade_level,
            'balik_aral' => $request->balik_aral,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'extension_name' => $request->extension_name,
            'birthdate' => $request->birthdate,
            'birthplace' => $request->birthplace,
            'house_no' => $request->house_no,
            'street' => $request->street,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'province' => $request->province,
            'zip_code' => $request->zip_code,
            'perm_house_no' => $request->perm_house_no,
            'perm_street' => $request->perm_street,
            'perm_barangay' => $request->perm_barangay,
            'perm_city' => $request->perm_city,
            'perm_province' => $request->perm_province,
            'perm_zip_code' => $request->perm_zip_code,
            'parent_name' => $request->parent_name,
            'relationship' => $request->relationship,
            'contact_number' => $request->contact_number,
            'occupation' => $request->occupation,
            'preferred_track' => $request->preferred_track,
            'preferred_strand' => $request->preferred_strand,
            'modality' => $request->modality,
            'academic_year_id' => $request->academic_year_id,
            'enrollment_id' => $request->enrollment_id,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Enrollment successfully created.');
   }
}
