<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Strand;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;
use App\Models\ClassroomStudent;
use App\Enums\AcademicYearStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentProfile;
use App\Models\AcademicRecord;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();

        $query = Classroom::where('teacher_id', Auth::user()->id)
            ->where('is_archived', false)
            ->with(['subject', 'strand', 'teacher.profile', 'academicYear', 'classroomStudents']);


        if ($request->has('academic_year')) {
            $query->where('academic_year_id', $request->academic_year);
        }

        $classrooms = $query->latest()->paginate(10);

        return view('users.teacher.classroom.index', compact('classrooms', 'academicYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::get();
        $strands = Strand::get();
        $academicYear = AcademicYear::where('status', AcademicYearStatus::Active->value)->latest()->first();

        if (!$academicYear) {
            return back()->with(['error' => 'Action rejected, no active academic year please contact the admin']);
        }

        return view('users.teacher.classroom.create', compact(['subjects', 'strands', 'academicYear']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'subject' => 'required',
            'strand' => 'required',
            'academic_year' => 'required'
        ]);

        $classroom_code = 'CLSSRM' . uniqid();

        $classroom = Classroom::create([
            'name' => $request->name,
            'class_code' => $classroom_code,
            'description' => $request->description,
            'subject_id' => $request->subject,
            'strand_id' => $request->strand,
            'academic_year_id' => $request->academic_year,
            'teacher_id' => Auth::user()->id
        ]);

        if ($request->has('image')) {
            $imageName = 'IMG-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/classroom', $imageName, 'public');

            $classroom->update([
                'image' => asset('/storage/' . $dir),
            ]);
        }

        return  back()->with(['success' => 'Classroom Added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classroom = Classroom::find($id);
        $attendance = $classroom->attendances()->latest()->first();

        return view('users.teacher.classroom.show', compact(['classroom', 'attendance']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classroom = Classroom::where('teacher_id', Auth::id())
            ->findOrFail($id);

        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();
        $subjects = Subject::orderBy('name')->get();
        $strands = Strand::orderBy('name')->get();

        return view('users.teacher.classroom.edit', compact(
            'classroom',
            'academicYears',
            'subjects',
            'strands'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $classroom = Classroom::where('teacher_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'subject_id' => 'required|exists:subjects,id',
            'strand_id' => 'required|exists:strands,id',
        ]);

        $classroom->update($validated);

        return redirect()
            ->route('teacher.classrooms.index')
            ->with('success', 'Classroom updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classroom = Classroom::find($id);
        $classroom->delete();

        return to_route('teacher.classrooms.index')->with(['message' => 'classroom deleted']);
    }

    public function students(string $id)
    {
        $classroom = Classroom::with(['strand', 'academicYear'])->findOrFail($id);

        $classroomStudents = $classroom->classroomStudents()
            ->with(['student.studentProfile'])
            ->paginate(10);

        // Get enrolled students in the same strand and academic year who are NOT in this classroom
        $existingStudentIds = $classroom->classroomStudents()->pluck('student_id')->toArray();

        $availableStudents = StudentProfile::whereHas('academicRecords', function ($query) use ($classroom) {
            $query->where('academic_year_id', $classroom->academic_year_id)
                ->where('grade_level', $classroom->strand->name); // Assuming grade_level corresponds to strand name
        })
            ->whereHas('user')
            ->whereNotIn('user_id', $existingStudentIds)
            ->with('user')
            ->get();



        return view('users.teacher.classroom.student.index', compact(
            'classroomStudents',
            'id',
            'classroom',
            'availableStudents'
        ));
    }

    /**
     * Add multiple students to classroom
     */
    public function addMultipleStudents(Request $request, string $id)
    {

        $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'required|exists:users,id'
        ], [
            'student_ids.required' => 'Please select at least one student',
            'student_ids.min' => 'Please select at least one student'
        ]);

        try {
            DB::beginTransaction();

            $classroom = Classroom::findOrFail($id);

            // Verify classroom belongs to authenticated teacher
            if ($classroom->teacher_id !== Auth::id()) {
                return back()->with(['error' => 'Unauthorized action']);
            }

            $addedCount = 0;
            $skippedCount = 0;
            $errors = [];

            foreach ($request->student_ids as $studentId) {
                // Check if student is already in classroom
                $exists = ClassroomStudent::where('classroom_id', $id)
                    ->where('student_id', $studentId)
                    ->exists();

                if ($exists) {
                    $skippedCount++;
                    continue;
                }

                // Verify student is enrolled in same strand and academic year
                $studentProfile = StudentProfile::where('user_id', $studentId)->first();

                if (!$studentProfile) {
                    $errors[] = "Student ID {$studentId} has no profile";
                    continue;
                }

                $isEnrolled = AcademicRecord::where('student_profile_id', $studentProfile->id)
                    ->where('academic_year_id', $classroom->academic_year_id)
                    ->where('grade_level', $classroom->strand->name) // Assuming grade_level corresponds to strand name
                    ->exists();

                if (!$isEnrolled) {
                    $errors[] = "Student {$studentProfile->first_name} {$studentProfile->last_name} is not enrolled in this strand/year";
                    continue;
                }

                // Add student to classroom
                ClassroomStudent::create([
                    'classroom_id' => $id,
                    'student_id' => $studentId
                ]);

                $addedCount++;
            }

            DB::commit();

            // Prepare success message
            $message = "{$addedCount} student(s) added successfully";

            if ($skippedCount > 0) {
                $message .= ". {$skippedCount} student(s) skipped (already in classroom)";
            }

            if (!empty($errors)) {
                $message .= ". Some students could not be added: " . implode(', ', $errors);
            }



            return back()->with(['message' => $message]);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->with(['error' => 'Failed to add students: ' . $e->getMessage()]);
        }
    }

    public function removeStudent(string $id)
    {
        $classroomStudent = ClassroomStudent::find($id);
        $classroomStudent->delete();

        return back()->with(['message' => 'Student Successfully Remove in Classroom']);
    }

    public function archive(Classroom $classroom)
    {
        // Check if the classroom belongs to the authenticated teacher
        if ($classroom->teacher_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action');
        }

        $classroom->update([
            'is_archived' => true,
            'archived_at' => now()
        ]);

        return back()->with('success', 'Classroom archived successfully');
    }

    public function archived()
    {
        $archivedClassrooms = Classroom::where('teacher_id', auth()->id())
            ->where('is_archived', true)
            ->with(['subject', 'strand'])
            ->latest('archived_at')
            ->paginate(10);

        return view('users.teacher.archived.index', compact('archivedClassrooms'));
    }

    public function unarchive(Classroom $classroom)
    {
        // Check if the classroom belongs to the authenticated teacher
        if ($classroom->teacher_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action');
        }

        $classroom->update([
            'is_archived' => false,
            'archived_at' => null
        ]);

        return back()->with('success', 'Classroom unarchived successfully');
    }

    public function forceDelete(Classroom $classroom)
    {
        // Check if the classroom belongs to the authenticated teacher
        if ($classroom->teacher_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action');
        }

        // Check if classroom has related data
        if ($classroom->students()->count() > 0) {
            return back()->with('error', 'Cannot delete classroom with enrolled students');
        }

        if ($classroom->grades()->count() > 0) {
            return back()->with('error', 'Cannot delete classroom with existing grades');
        }

        $classroom->forceDelete();

        return back()->with('success', 'Classroom deleted permanently');
    }
}
