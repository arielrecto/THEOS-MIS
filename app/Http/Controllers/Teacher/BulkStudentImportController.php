<?php

namespace App\Http\Controllers\Teacher;

use App\Models\User;
use App\Models\Strand;
use App\Models\Classroom;
use App\Models\Enrollment;
use Illuminate\Support\Str;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\AcademicRecord;
use App\Models\EnrollmentForm;
use App\Models\StudentProfile;
use App\Models\ClassroomStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BulkStudentImportController extends Controller
{
    /**
     * Show the import form
     */
    public function showImportForm($classroomId)
    {
        $classroom = Classroom::with(['strand', 'academicYear'])
            ->where('teacher_id', auth()->id())
            ->findOrFail($classroomId);

        return view('users.teacher.classroom.student.import', compact('classroom'));
    }

    /**
     * Download CSV template
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="student_bulk_import_template.csv"',
        ];

        $columns = [
            // User fields
            'email',
            'password',

            // Student Profile fields
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

            // Enrollment Form fields
            'school_year',
            'grade_level',
            'type',
            'balik_aral',
            'mother_name',
            'mother_last_name',
            'mother_middle_name',
            'mother_relationship',
            'mother_contact_number',
            'mother_occupation',
            'guardian_name',
            'guardian_last_name',
            'guardian_middle_name',
            'guardian_relationship',
            'guardian_contact_number',
            'guardian_occupation',
        ];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');

            // Write column headers
            fputcsv($file, $columns);

            // Write sample data with proper formatting
            fputcsv($file, [
                'student@example.com', // email
                'password123', // password
                '123456789012', // lrn
                'Dela Cruz', // last_name
                'Juan', // first_name
                'Pedro', // middle_name
                'Jr.', // extension_name
                '2005-01-15', // birthdate (YYYY-MM-DD)
                'Manila', // birthplace
                '123', // house_no
                'Rizal Street', // street
                'Poblacion', // barangay
                'Manila', // city
                'Metro Manila', // province
                '1000', // zip_code
                '123', // perm_house_no
                'Rizal Street', // perm_street
                'Poblacion', // perm_barangay
                'Manila', // perm_city
                'Metro Manila', // perm_province
                '1000', // perm_zip_code
                'Jose Dela Cruz', // parent_name
                'Father', // relationship
                '09123456789', // contact_number
                'Engineer', // occupation
                'ACADEMIC', // preferred_track
                'STEM', // preferred_strand
                'Face-to-Face', // modality (Face-to-Face, Online, Blended)
                '2024-2025', // school_year (YYYY-YYYY format)
                'Grade 11', // grade_level
                'new', // type (new, transferee, returning)
                'No', // balik_aral (Yes, No)
                'Maria', // mother_name
                'Santos', // mother_last_name
                'Garcia', // mother_middle_name
                'Mother', // mother_relationship
                '09123456780', // mother_contact_number
                'Teacher', // mother_occupation
                'Roberto', // guardian_name
                'Reyes', // guardian_last_name
                'Cruz', // guardian_middle_name
                'Uncle', // guardian_relationship
                '09123456781', // guardian_contact_number
                'Business Owner', // guardian_occupation
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Process the CSV import
     */
    public function import(Request $request, $classroomId)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120', // 5MB max
        ]);

        $classroom = Classroom::with(['strand', 'academicYear'])
            ->where('teacher_id', auth()->id())
            ->findOrFail($classroomId);


        // Validate academic year exists
        if (!$classroom->academicYear) {
            return back()->with('error', 'This classroom does not have a valid academic year assigned.');
        }

        // Verify the academic year ID actually exists in the database
        $academicYear = AcademicYear::find($classroom->academic_year_id);
        if (!$academicYear) {
            return back()->with('error', "Academic year ID {$classroom->academic_year_id} does not exist in the database.");
        }

        // Get school year from academic year - use 'name' field as fallback
        $schoolYear = $academicYear->name ?? date('Y') . '-' . (date('Y') + 1);

        Log::info('Import started', [
            'classroom_id' => $classroomId,
            'academic_year_id' => $classroom->academic_year_id,
            'school_year' => $schoolYear,
            'academic_year_exists' => true
        ]);

        try {
            $file = $request->file('csv_file');
            $path = $file->getRealPath();
            $data = array_map('str_getcsv', file($path));

            // Get headers
            $headers = array_map('trim', $data[0]);
            unset($data[0]); // Remove header row

            // Validate headers
            $requiredHeaders = [
                'email',
                'password',
                'lrn',
                'last_name',
                'first_name',
                'birthdate',
                'birthplace',
                'house_no',
                'street',
                'barangay',
                'city',
                'province',
                'zip_code',
                'parent_name',
                'relationship',
                'contact_number',
                'occupation',
                'preferred_track',
                'preferred_strand',
                'modality',
                'school_year',
                'grade_level',
                'type'
            ];

            $missingHeaders = array_diff($requiredHeaders, $headers);
            if (!empty($missingHeaders)) {
                return back()->with('error', 'Missing required columns: ' . implode(', ', $missingHeaders));
            }

            // First pass: Validate all rows before creating any records
            $validatedRows = [];
            $errors = [];
            $errorCount = 0;

            foreach ($data as $rowIndex => $row) {
                $rowNumber = $rowIndex + 2;



                try {
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    // Combine headers with row data
                    $rowData = array_combine($headers, $row);

                    // Validate row data
                    $validator = $this->validateRowData($rowData, $rowNumber);

                    if ($validator->fails()) {
                        $errors[] = "Row {$rowNumber}: " . implode(', ', $validator->errors()->all());
                        $errorCount++;
                        continue;
                    }

                    // Check if user already exists
                    $existingUser = User::where('email', trim($rowData['email']))->first();
                    if ($existingUser) {
                        $errors[] = "Row {$rowNumber}: Email already exists - " . trim($rowData['email']);
                        $errorCount++;
                        continue;
                    }

                    // Check if LRN already exists
                    $existingLrn = StudentProfile::where('lrn', trim($rowData['lrn']))->first();
                    if ($existingLrn) {
                        $errors[] = "Row {$rowNumber}: LRN already exists - " . trim($rowData['lrn']);
                        $errorCount++;
                        continue;
                    }


                    $checkAcademicYear = AcademicYear::where('name', trim($rowData['school_year']))->first();

                    if (!$checkAcademicYear) {
                        $errors[] = "Row {$rowNumber}: Academic year does not exist - " . trim($rowData['school_year']);

                        if ($checkAcademicYear?->status !== 'active') {
                            $errors[] = "Row {$rowNumber}: Academic year is not active - " . trim($rowData['school_year']);
                        }
                        $errorCount++;
                        continue;
                    }

                    $checkLatestEnrollment = Enrollment::latest()->first();




                    if (!$checkLatestEnrollment) {
                        $errors[] = "Row {$rowNumber}: No enrollments found in the system.";
                        $errorCount++;
                        continue;
                    }





                    // Check for duplicate emails in the current batch
                    $email = trim($rowData['email']);
                    $lrn = trim($rowData['lrn']);

                    foreach ($validatedRows as $validatedRow) {
                        if ($validatedRow['email'] === $email) {
                            $errors[] = "Row {$rowNumber}: Duplicate email in CSV - {$email}";
                            $errorCount++;
                            continue 2;
                        }
                        if ($validatedRow['lrn'] === $lrn) {
                            $errors[] = "Row {$rowNumber}: Duplicate LRN in CSV - {$lrn}";
                            $errorCount++;
                            continue 2;
                        }
                    }

                    // Store validated row data
                    $validatedRows[] = [
                        'row_number' => $rowNumber,
                        'email' => $email,
                        'lrn' => $lrn,
                        'data' => $rowData,
                    ];
                } catch (\Exception $e) {
                    $errors[] = "Row {$rowNumber}: Validation error - " . $e->getMessage();
                    $errorCount++;
                    continue;
                }
            }

            // If there are validation errors, return without creating any records
            if ($errorCount > 0) {
                return back()
                    ->with('error', "Validation failed. No students were imported. Please fix the errors and try again.")
                    ->with('import_errors', $errors);
            }

            // Check if we have any rows to import
            if (empty($validatedRows)) {
                return back()->with('error', 'No valid rows found in the CSV file.');
            }

            // Second pass: Create all records in a transaction
            DB::beginTransaction();

            $successCount = 0;
            $creationErrors = [];

            foreach ($validatedRows as $validatedRow) {
                $rowNumber = $validatedRow['row_number'];
                $rowData = $validatedRow['data'];

                try {
                    // Use school_year from CSV, fallback to classroom's academic year
                    $importSchoolYear = !empty(trim($rowData['school_year']))
                        ? trim($rowData['school_year'])
                        : $schoolYear;

                    Log::info("Creating student for row {$rowNumber}", [
                        'email' => trim($rowData['email']),
                        'academic_year_id' => $classroom->academic_year_id,
                        'school_year' => $importSchoolYear
                    ]);

                    // Create User
                    $user = User::create([
                        'name' => trim($rowData['first_name']) . ' ' . trim($rowData['last_name']),
                        'email' => trim($rowData['email']),
                        'password' => Hash::make(trim($rowData['password'])),
                    ]);

                    if (!$user) {
                        throw new \Exception("Failed to create user");
                    }

                    // Assign student role
                    $user->assignRole('student');

                    // Create Student Profile
                    $studentProfile = StudentProfile::create([
                        'user_id' => $user->id,
                        'lrn' => trim($rowData['lrn']),
                        'last_name' => trim($rowData['last_name']),
                        'first_name' => trim($rowData['first_name']),
                        'middle_name' => trim($rowData['middle_name'] ?? ''),
                        'extension_name' => trim($rowData['extension_name'] ?? ''),
                        'birthdate' => trim($rowData['birthdate']),
                        'birthplace' => trim($rowData['birthplace']),
                        'house_no' => trim($rowData['house_no']),
                        'street' => trim($rowData['street']),
                        'barangay' => trim($rowData['barangay']),
                        'city' => trim($rowData['city']),
                        'province' => trim($rowData['province']),
                        'zip_code' => trim($rowData['zip_code']),
                        'perm_house_no' => trim($rowData['perm_house_no'] ?? $rowData['house_no']),
                        'perm_street' => trim($rowData['perm_street'] ?? $rowData['street']),
                        'perm_barangay' => trim($rowData['perm_barangay'] ?? $rowData['barangay']),
                        'perm_city' => trim($rowData['perm_city'] ?? $rowData['city']),
                        'perm_province' => trim($rowData['perm_province'] ?? $rowData['province']),
                        'perm_zip_code' => trim($rowData['perm_zip_code'] ?? $rowData['zip_code']),
                        'parent_name' => trim($rowData['parent_name']),
                        'relationship' => trim($rowData['relationship']),
                        'contact_number' => trim($rowData['contact_number']),
                        'occupation' => trim($rowData['occupation']),
                        'preferred_track' => trim($rowData['preferred_track']),
                        'preferred_strand' => trim($rowData['preferred_strand']),
                        'modality' => [trim($rowData['modality'])],
                        'email' => trim($rowData['email']),
                    ]);

                    if (!$studentProfile) {
                        throw new \Exception("Failed to create student profile");
                    }

                    // Verify academic year exists before creating enrollment
                    $academicYear = AcademicYear::find($classroom->academic_year_id);
                    if (!$academicYear) {
                        throw new \Exception("Academic year ID {$classroom->academic_year_id} does not exist");
                    }

                    // Create Enrollment Form
                    $enrollmentForm = EnrollmentForm::create([
                        'user_id' => $user->id,
                        'academic_year_id' => $checkAcademicYear->id,
                        'school_year' => $importSchoolYear,
                        'grade_level' => trim($rowData['grade_level']),
                        'type' => trim($rowData['type']),
                        'balik_aral' => trim($rowData['balik_aral'] ?? 'No'),
                        'lrn' => trim($rowData['lrn']),
                        'last_name' => trim($rowData['last_name']),
                        'first_name' => trim($rowData['first_name']),
                        'middle_name' => trim($rowData['middle_name'] ?? ''),
                        'extension_name' => trim($rowData['extension_name'] ?? ''),
                        'birthdate' => trim($rowData['birthdate']),
                        'birthplace' => trim($rowData['birthplace']),
                        'house_no' => trim($rowData['house_no']),
                        'street' => trim($rowData['street']),
                        'barangay' => trim($rowData['barangay']),
                        'city' => trim($rowData['city']),
                        'province' => trim($rowData['province']),
                        'zip_code' => trim($rowData['zip_code']),
                        'perm_house_no' => trim($rowData['perm_house_no'] ?? $rowData['house_no']),
                        'perm_street' => trim($rowData['perm_street'] ?? $rowData['street']),
                        'perm_barangay' => trim($rowData['perm_barangay'] ?? $rowData['barangay']),
                        'perm_city' => trim($rowData['perm_city'] ?? $rowData['city']),
                        'perm_province' => trim($rowData['perm_province'] ?? $rowData['province']),
                        'perm_zip_code' => trim($rowData['perm_zip_code'] ?? $rowData['zip_code']),
                        'parent_name' => trim($rowData['parent_name']),
                        'relationship' => trim($rowData['relationship']),
                        'contact_number' => trim($rowData['contact_number']),
                        'occupation' => trim($rowData['occupation']),
                        'mother_name' => trim($rowData['mother_name'] ?? ''),
                        'mother_last_name' => trim($rowData['mother_last_name'] ?? ''),
                        'mother_middle_name' => trim($rowData['mother_middle_name'] ?? ''),
                        'mother_relationship' => trim($rowData['mother_relationship'] ?? ''),
                        'mother_contact_number' => trim($rowData['mother_contact_number'] ?? ''),
                        'mother_occupation' => trim($rowData['mother_occupation'] ?? ''),
                        'guardian_name' => trim($rowData['guardian_name'] ?? ''),
                        'guardian_last_name' => trim($rowData['guardian_last_name'] ?? ''),
                        'guardian_middle_name' => trim($rowData['guardian_middle_name'] ?? ''),
                        'guardian_relationship' => trim($rowData['guardian_relationship'] ?? ''),
                        'guardian_contact_number' => trim($rowData['guardian_contact_number'] ?? ''),
                        'guardian_occupation' => trim($rowData['guardian_occupation'] ?? ''),
                        'preferred_track' => trim($rowData['preferred_track']),
                        'preferred_strand' => trim($rowData['preferred_strand']),
                        'modality' => [trim($rowData['modality'])],
                        'email' => trim($rowData['email']),
                        'status' => 'enrolled',
                        'enrollment_id' => $checkLatestEnrollment->id,
                    ]);

                    if (!$enrollmentForm) {
                        throw new \Exception("Failed to create enrollment form");
                    }

                    // Create Academic Record
                    $academicRecord = AcademicRecord::create([
                        'student_profile_id' => $studentProfile->id,
                        'academic_year_id' => $checkAcademicYear->id,
                        'school_year' => $importSchoolYear,
                        'grade_level' => trim($rowData['grade_level']),
                        'enrollment_id' => $enrollmentForm->enrollment_id,
                    ]);

                    if (!$academicRecord) {
                        throw new \Exception("Failed to create academic record");
                    }

                    // Add student to classroom
                    $classroomStudent = ClassroomStudent::create([
                        'classroom_id' => $classroomId,
                        'student_id' => $user->id,
                    ]);

                    if (!$classroomStudent) {
                        throw new \Exception("Failed to add student to classroom");
                    }

                    Log::info("Successfully created student for row {$rowNumber}");
                    $successCount++;
                } catch (\Exception $e) {
                    // If any creation fails, rollback everything
                    DB::rollBack();

                    Log::error("Import failed at row {$rowNumber}", [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    $creationErrors[] = "Row {$rowNumber}: Creation failed - " . $e->getMessage();

                    return back()
                        ->with('error', 'Import failed during record creation. No students were imported. Please check the errors and try again.')
                        ->with('import_errors', $creationErrors);
                }
            }

            // Commit all changes if everything succeeded
            DB::commit();

            Log::info('Import completed successfully', ['count' => $successCount]);

            $message = "{$successCount} student(s) imported successfully!";

            return redirect()
                ->route('teacher.classrooms.students', $classroomId)
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Validate row data
     */
    private function validateRowData($data, $rowNumber)
    {
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'lrn' => 'required|digits:12',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'extension_name' => 'nullable|string|max:10',
            'birthdate' => 'required|date|before:today',
            'birthplace' => 'required|string|max:255',
            'house_no' => 'required|string|max:50',
            'street' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'parent_name' => 'required|string|max:255',
            'relationship' => 'required|string|max:50',
            'contact_number' => 'required|string|max:20',
            'occupation' => 'required|string|max:255',
            'preferred_track' => 'required|string|max:255',
            'preferred_strand' => 'required|string|max:255',
            'modality' => 'required|string|in:Face-to-Face,Online,Blended',
            'school_year' => 'required|string|regex:/^\d{4}-\d{4}$/',
            'grade_level' => 'required|string|max:50',
            'type' => 'required|string|in:new,transferee,returning',
            'balik_aral' => 'nullable|string|in:Yes,No',
        ], [
            'school_year.regex' => 'The school year must be in YYYY-YYYY format (e.g., 2024-2025)',
        ]);
    }
}
