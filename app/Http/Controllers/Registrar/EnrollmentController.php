<?php

namespace App\Http\Controllers\Registrar;

use App\Models\User;
use App\Models\Enrollment;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\AcademicRecord;
use App\Models\EnrollmentForm;
use App\Models\StudentProfile;
use App\Mail\ApproveEnrollment;
use App\Enums\AcademicYearStatus;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::paginate(10);
        return view('users.registrar.enrollment.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $academic_years = AcademicYear::where('status', AcademicYearStatus::Active)->get();

        return view('users.registrar.enrollment.create', compact('academic_years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'academic_year_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'nullable',
        ]);

        Enrollment::create($request->all());

        return redirect()->route('registrar.enrollments.index')->with('success', 'Enrollment created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollees = $enrollment->enrollees()->paginate(10);


        return view('users.registrar.enrollment.show', compact('enrollment', 'enrollees'));
    }

    /**


     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        return view('users.registrar.enrollment.edit', compact('enrollment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'academic_year_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'nullable',
        ]);

        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update($request->all());

        return redirect()->route('registrar.enrollments.index')->with('success', 'Enrollment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('registrar.enrollments.index')->with('success', 'Enrollment deleted successfully');
    }

    public function showEnrollee(string $id)
    {
        $enrollee = EnrollmentForm::findOrFail($id);
        return view('users.registrar.enrollment.enrollee-form', compact('enrollee'));
    }

    public function enrolled(Request $request, string $id)
    {

        $enrollee = EnrollmentForm::findOrFail($id);


        $user = User::create([
            'name' => $enrollee->first_name . ' ' . $enrollee->last_name,
            'email' => $enrollee->email,
            'password' => bcrypt('password'),
        ]);


        $studentProfile = StudentProfile::create([
            'lrn' => $enrollee->lrn,
            'last_name' => $enrollee->last_name,
            'first_name' => $enrollee->first_name,
            'middle_name' => $enrollee->middle_name,
            'extension_name' => $enrollee->extension_name,
            'birthdate' => $enrollee->birthdate,
            'birthplace' => $enrollee->birthplace,
            'house_no' => $enrollee->house_no,
            'street' => $enrollee->street,
            'barangay' => $enrollee->barangay,
            'city' => $enrollee->city,
            'province' => $enrollee->province,
            'zip_code' => $enrollee->zip_code,
            'perm_house_no' => $enrollee->perm_house_no,
            'perm_street' => $enrollee->perm_street,
            'perm_barangay' => $enrollee->perm_barangay,
            'perm_city' => $enrollee->perm_city,
            'perm_province' => $enrollee->perm_province,
            'perm_zip_code' => $enrollee->perm_zip_code,
            'parent_name' => $enrollee->parent_name,
            'relationship' => $enrollee->relationship,
            'contact_number' => $enrollee->contact_number,
            'occupation' => $enrollee->occupation,
            'preferred_track' => $enrollee->preferred_track,
            'preferred_strand' => $enrollee->preferred_strand,
            'modality' => $enrollee->modality,
            'email' => $enrollee->email,
            'user_id' => $user->id,
        ]);


        $academicRecord = AcademicRecord::create([
            'student_profile_id' => $studentProfile->id,
            'enrollment_id' => $enrollee->enrollment_id,
            'academic_year_id' => $enrollee->academic_year_id,
            'school_year' => $enrollee->school_year,
            'grade_level' => $enrollee->grade_level,
        ]);

        $studentRole = Role::where('name', 'student')->first();
        $user->assignRole($studentRole);
        $enrollee->update([
            'status' => 'Enrolled'
        ]);

        Mail::to($enrollee->email)->send(new ApproveEnrollment($enrollee, $user));

        return back()->with('success', 'Enrollee enrolled successfully');
    }
}
