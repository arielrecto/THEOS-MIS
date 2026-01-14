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
use App\Actions\NotificationActions;
use App\Http\Controllers\Controller;
use App\Mail\EnrollmentStatusUpdate;
use Illuminate\Support\Facades\Mail;

class EnrollmentController extends Controller
{
    protected $notificationActions;

    public function __construct(NotificationActions $notificationActions)
    {
        $this->notificationActions = $notificationActions;
    }

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

        $enrollment = Enrollment::create($request->all());

        // Prepare notification data
        $notificationData = [
            'header' => 'New Enrollment Period',
            'message' => "New enrollment period '{$enrollment->name}' is now open from " .
                date('M d, Y', strtotime($enrollment->start_date)) .
                " to " . date('M d, Y', strtotime($enrollment->end_date)),
            'type' => 'enrollment',
            // 'url' => route('enrollees.form')
        ];

        // Notify all students
        $this->notificationActions->notifyRole('student', $notificationData, $enrollment);

        return redirect()
            ->route('registrar.enrollments.index')
            ->with('success', 'Enrollment created successfully');
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
        $oldStatus = $enrollment->status;

        $enrollment->update($request->all());

        // Notify if enrollment status changes
        if ($oldStatus !== $enrollment->status) {
            $notificationData = [
                'header' => 'Enrollment Period Update',
                'message' => "Enrollment period '{$enrollment->name}' is now {$enrollment->status}",
                'type' => 'enrollment',
                'url' => route('enrollment.form')
            ];

            $this->notificationActions->notifyRole('student', $notificationData, $enrollment);
        }

        return redirect()
            ->route('registrar.enrollments.index')
            ->with('success', 'Enrollment updated successfully');
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


        if ($enrollee->type === 'old') {
            $enrollee->update([
                'status' => 'Enrolled'
            ]);

            return back()->with('success', 'Enrollee enrolled successfully');
        }


        $user = User::find($enrollee->user_id);




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


        $enrollee->update([
            'status' => 'Enrolled',
            'user_id' => $user->id
        ]);

        Mail::to($enrollee->email)->send(new ApproveEnrollment($enrollee, $user));

        return back()->with('success', 'Enrollee enrolled successfully');
    }

    /**
     * Close the enrollment period
     */
    public function close(Enrollment $enrollment)
    {
        // Update enrollment status
        $enrollment->update([
            'status' => 'closed',
            'end_date' => now()
        ]);

        // Prepare notification data
        $notificationData = [
            'header' => 'Enrollment Period Closed',
            'message' => "The enrollment period '{$enrollment->name}' has been closed.",
            'type' => 'enrollment',
            // 'url' => route('enrollees.form')
        ];

        // Notify students and teachers
        $this->notificationActions->notifyRoles(
            ['student', 'teacher'],
            $notificationData,
            $enrollment
        );

        // Update all pending enrollments to rejected
        $enrollment->enrollees()
            ->where('status', 'pending')
            ->update([
                'status' => 'rejected',
            ]);

        return redirect()
            ->route('registrar.enrollments.show', $enrollment)
            ->with('success', 'Enrollment period has been closed successfully');
    }

    /**
     * Display the specified enrollment's print view.
     */
    public function print($id)
    {
        $enrollment = Enrollment::where('id', $id)->with([
            'enrollees' => function ($query) {
                $query->orderBy('grade_level')
                    ->orderBy('last_name')
                    ->orderBy('first_name');
            },
            'academicYear'
        ])->first();


        return view('users.registrar.enrollment.print', compact('enrollment'));
    }

    public function updateStatus(Request $request, string $id)
    {


        $request->validate([
            'status' => 'required|in:pending,review,interviewed,enrolled',
            'remarks' => 'nullable|string|max:500'
        ]);

        $enrollee = EnrollmentForm::findOrFail($id);
        $oldStatus = $enrollee->status;

        // Update status
        $enrollee->update([
            'status' => $request->status,
            'remarks' => $request->remarks
        ]);

        // Send email notification
        Mail::to($enrollee->email)->send(new EnrollmentStatusUpdate(
            $enrollee,
            $request->status,
            $request->remarks
        ));

        // Create notification
        $notificationData = [
            'header' => 'Enrollment Status Update',
            'message' => "Your enrollment status has been updated to " . ucfirst($request->status),
            'type' => 'enrollment_status',
            // 'url' => route('enrollment.status', $enrollee->id)
        ];

        // Notify the student
        if ($enrollee->user_id) {
            $this->notificationActions->notifyUsers(
                User::where('id', $enrollee->user_id)->get(),
                $notificationData,
                $enrollee
            );
        }

        // If status is enrolled, create student profile and academic record
        if ($request->status === 'enrolled' && $enrollee->type === 'new') {
            $this->processEnrollment($enrollee);
        }

        return back()->with('success', 'Enrollment status updated successfully');
    }

    private function processEnrollment(EnrollmentForm $enrollee)
    {
        // Create or update student profile
        $studentProfile = StudentProfile::updateOrCreate(
            ['user_id' => $enrollee->user_id],
            [
                'lrn' => $enrollee->lrn,
                'last_name' => $enrollee->last_name,
                'first_name' => $enrollee->first_name,
                'middle_name' => $enrollee->middle_name,
                'extension_name' => $enrollee->extension_name,
                // ...other fields...
            ]
        );

        // Create academic record
        AcademicRecord::create([
            'student_profile_id' => $studentProfile->id,
            'enrollment_id' => $enrollee->enrollment_id,
            'academic_year_id' => $enrollee->academic_year_id,
            'school_year' => $enrollee->school_year,
            'grade_level' => $enrollee->grade_level,
        ]);
    }
}
