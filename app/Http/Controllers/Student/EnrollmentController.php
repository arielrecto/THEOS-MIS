<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentForm;
use App\Models\PaymentAccount;
use App\Models\Strand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = EnrollmentForm::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('users.student.enrollment.index', compact('enrollments'));
    }

    public function create(Request $request)
    {



         $previousEnrollment = EnrollmentForm::where('user_id', auth()->id())
                ->latest()
                ->first();
        // If previous enrollment ID is provided, load it

            if(!$previousEnrollment){
                return back()->with('error', 'No previous enrollment found. Please start a new enrollment.');
            }

            // Calculate next school year
            $currentYear = (int) substr($previousEnrollment->school_year, 0, 4);
            $nextSchoolYear = ($currentYear + 1) . '-' . ($currentYear + 2);

            // Calculate next grade level
            $nextGradeLevel = $this->getNextGradeLevel($previousEnrollment->grade_level);





        return view('users.student.enrollment.create', compact(
            'previousEnrollment',
            'nextSchoolYear',
            'nextGradeLevel'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_year' => 'required|string',
            'grade_level' => 'required|string',
            'lrn' => 'required|string',
            'balik_aral' => 'nullable|boolean',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'extension_name' => 'nullable|string|max:50',
            'birthdate' => 'required|date',
            'birthplace' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'house_no' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'parent_name' => 'nullable|string|max:255',
            'parent_last_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'occupation' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_last_name' => 'nullable|string|max:255',
            'mother_contact_number' => 'nullable|string|max:20',
            'mother_occupation' => 'nullable|string|max:255',
            'documents.form_138' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'documents.birth_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'documents.good_moral' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'documents.id_picture' => 'required|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Create enrollment
        $enrollment = EnrollmentForm::create([
            ...$validated,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'type' => 'new',
        ]);

        // Handle document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $key => $file) {
                if ($file && $file->isValid()) {
                    $storedPath = $file->store('enrollment-documents/' . $enrollment->id, 'public');

                    $enrollment->attachments()->create([
                        'file_dir' => 'storage/' . $storedPath,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                        'type' => $key, // form_138, birth_certificate, etc.
                    ]);
                }
            }
        }

        return redirect()
            ->route('student.enrollment.show', $enrollment->id)
            ->with('success', 'Enrollment form submitted successfully!');
    }

    public function show(string $id)
    {
        $enrollment = EnrollmentForm::with(['attachments', 'academicYear'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        // Find strand based on grade_level
        $strand = Strand::with(['tuitionFees.bracket'])
            ->where('name', $enrollment->grade_level)
            ->orWhere('acronym', $enrollment->grade_level)
            ->first();

        $paymentAccounts = PaymentAccount::get();

        return view('users.student.enrollment.show', compact(
            'enrollment',
            'strand',
            'paymentAccounts'
        ));
    }

    /**
     * Get the next grade level
     */
    private function getNextGradeLevel(string $currentGrade): string
    {
        $gradeLevels = [
            'Grade 7' => 'Grade 8',
            'Grade 8' => 'Grade 9',
            'Grade 9' => 'Grade 10',
            'Grade 10' => 'Grade 11',
            'Grade 11' => 'Grade 12',
            'Grade 12' => 'Graduate',
        ];

        return $gradeLevels[$currentGrade] ?? 'Grade 7';
    }
}
