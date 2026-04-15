<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Strand;
use App\Models\Attachment;
use App\Models\Enrollment;
use Illuminate\Support\Str;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\EnrollmentForm;
use App\Enums\AcademicYearStatus;
use Spatie\Permission\Models\Role;
use App\Notifications\UserCreation;
use App\Actions\NotificationActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EnrollmentController extends Controller
{
    protected $notificationActions;

    public function __construct(NotificationActions $notificationActions)
    {
        $this->notificationActions = $notificationActions;
    }

    public function show(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        return view('enrollees.enrollment', compact('enrollment'));
    }

    public function enrollmentType(Request $request)
    {
        $enrollment = Enrollment::findOrFail($request->enrollment);

        $user = Auth::user();
        if ($user) {
            return to_route('enrollment.form', [
                'enrollment' => $enrollment->id,
                'type' => 'old',
            ]);
        }

        return view('enrollees.select-enrollment-type', compact('enrollment'));
    }

    public function form(Request $request)
    {
        $enrollmentID = $request->enrollment;

        $type = $request->query('type', 'new');

        // Validate type parameter
        if (!in_array($type, ['new', 'old'])) {
            return redirect()->route('enrollment.type');
        }

        if ($type == 'old' && !Auth::check()) {
            return to_route('login');
        }

        $gradeLevels = Strand::get();

        $academicYear = AcademicYear::where('status', AcademicYearStatus::Active->value)->first();

        return view('enrollees.form', compact(['academicYear', 'enrollmentID', 'gradeLevels']));
    }

    public function store(Request $request)
    {
        // Add validation rules for attachments
        $validated = $request->validate([
            'school_year' => 'required|string',
            'grade_level' => 'required|string',
            'balik_aral' => 'required|in:yes,no',
            'type' => 'required|in:new,old',
            'lrn' => 'nullable',

            // Student Information
            'last_name' => ['required', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'first_name' => ['required', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'middle_name' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'extension_name' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'birthdate' => 'required|date',
            'birthplace' => ['required', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],

            // Address Information
            'house_no' => ['required', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'street' => ['required', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'barangay' => ['required', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'city' => ['required', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'province' => ['required', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'zip_code' => ['required', 'string', 'max:10', 'not_regex:/^n\/?a$/i'],

            // Parent Information
            'parent_name' => ['required', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'parent_last_name' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'parent_middle_name' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'relationship' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'contact_number' => ['required', 'string', 'size:11', 'not_regex:/^n\/?a$/i'],
            'occupation' => ['required', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],

            // Mother's Information (if needed)
            'mother_name' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'mother_last_name' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'mother_middle_name' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'mother_relationship' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'mother_contact_number' => ['nullable', 'string', 'size:11', 'not_regex:/^n\/?a$/i'],
            'mother_occupation' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],

            'guardian_name' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'guardian_last_name' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'guardian_middle_name' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'guardian_relationship' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'guardian_contact_number' => ['nullable', 'string', 'size:11', 'not_regex:/^n\/?a$/i'],
            'guardian_occupation' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],

            // Academic Information
            'preferred_track' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'preferred_strand' => ['nullable', 'string', 'max:255', 'not_regex:/^n\/?a$/i'],
            'modality' => 'nullable|array',

            // Required IDs
            'academic_year_id' => 'required|exists:academic_years,id',
            'enrollment_id' => 'required|exists:enrollments,id',

            // Contact
            'email' => 'required|email|max:255',
            'user_id' => 'nullable',

            // Attachments
            'attachments' => 'required|array',
            'attachments.birth_certificate' => 'required|file|mimes:pdf|max:5120',
            'attachments.form_138' => 'required|file|mimes:pdf|max:5120',
            'attachments.good_moral' => 'required|file|mimes:pdf|max:5120',
            'attachments.additional.*' => 'nullable|file|mimes:pdf|max:5120',
        ], [
            // Custom error messages for N/A validation
            '*.not_regex' => 'The :attribute field cannot contain "N/A". Please provide valid information.',
        ]);

        if (User::where('email', $validated['email'])->exists()) {
            return back()->withInput()->withErrors(['email' => 'The email has already been taken.
            Please use a different email or log in if you already have an account and enroll as old student.']);
        }

        $generatedPassword = Str::random(12);

        $user = Auth::user();

        if (!$user) {
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($generatedPassword),
            ]);
        }

        $role = Role::where('name', 'student')->first();

        $user->assignRole($role);

        $enrollment = EnrollmentForm::create([...$validated, 'status' => 'pending', 'type' => $request->type, 'user_id' => $user->id]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $type => $files) {
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $this->createAttachment($file, $enrollment, $type);
                    }
                } else {
                    $this->createAttachment($files, $enrollment, $type);
                }
            }
        }

        $notificationData = [
            'header' => 'New Enrollment Application',
            'message' => "New {$request->type} student enrollment application from {$enrollment->first_name} {$enrollment->last_name} for Grade {$enrollment->grade_level}",
            'type' => 'enrollment',
            'url' => route('registrar.enrollments.showEnrollee', $enrollment->id),
        ];

        $notificationNewUser = [
            'message' => "Good Day, Welcome {$user->name}. your account has been created for the {$enrollment->grade_level}. Your login email is {$user->email} and your password is {$generatedPassword}. Please change your password after logging in. thank you for using our application.",
        ];

        $user->notify(new UserCreation($notificationNewUser));

        $registrars = User::role('registrar')->get();
        $this->notificationActions->notifyUsers($registrars, $notificationData, $enrollment);

        return to_route('enrollment.applicationMessage', $enrollment->id)->with('success', 'Your enrollment application has been submitted successfully.');
    }

    protected function createAttachment($file, $enrollment, $type)
    {
        $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('enrollments/' . $enrollment->id . '/' . $type, $fileName, 'public');

        Attachment::create([
            'file_dir' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'attachable_id' => $enrollment->id,
            'attachable_type' => EnrollmentForm::class,
        ]);
    }

    public function applicationMessage($enrollmentForm)
    {
        $student = EnrollmentForm::find($enrollmentForm);
        return view('enrollees.enrollment-message', compact('student'));
    }

    public function print($enrollmentForm)
    {
        $student = EnrollmentForm::find($enrollmentForm);
        return view('enrollees.print', compact('student'));
    }
}
