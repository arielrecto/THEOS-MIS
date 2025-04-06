<?php

namespace App\Http\Controllers\Teacher;

use App\Models\User;
use App\Models\Grade;
use App\Models\Classroom;
use App\Models\StudentTask;
use App\Enums\GeneralStatus;
use Illuminate\Http\Request;
use App\Models\AcademicRecord;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::where('teacher_id', Auth::id())
            ->with([
                'tasks',
                'classroomStudents.student',
                'subject',
                'strand',
                'academicYear'
            ])
            ->when($request->classroom_id, function($query) use ($request) {
                $query->where('id', $request->classroom_id);
            })
            ->get();

        return view('users.teacher.classroom.grade.index', compact('classrooms'));
    }

    public function storeIndividual(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'quarter' => 'required|in:Q1,Q2,Q3,Q4',
            'grade' => 'required|numeric|min:0|max:100'
        ]);

        $student = User::with('studentProfile.academicRecords')->findOrFail($request->student_id);
        $classroom = Classroom::with(['subject', 'academicYear'])->findOrFail($request->classroom_id);

        $academicRecord = $student->studentProfile->academicRecords()
            ->where('academic_year_id', $classroom->academic_year_id)->latest()->first();

        // Create or update grade


        $tasks = StudentTask::whereHas('task', function ($query) use ($classroom) {
            $query->where('classroom_id', $classroom->id);
        })->where('user_id', $student->id)->get();

        Grade::updateOrCreate(
            [
                'academic_record_id' => $academicRecord->id,
                'classroom_id' => $request->classroom_id,
                'quarter' => $request->quarter
            ],
            [
                'grade' => $request->grade,
                'remarks' => $this->getRemarks($request->grade),
                'status' => 'graded',
                'created_by' => Auth::id(),
                'subject' => $classroom->subject->name
            ]
        );


        collect($tasks)->each(function ($task) use ($student, $classroom, $request) {
            $task->update([
                'status' => 'submitted',
            ]);
        });

        return back()->with('success', 'Grade has been submitted successfully for ' . $request->quarter);
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id'
        ]);

        $classroom = Classroom::with(['classroomStudents.student'])
            ->findOrFail($request->classroom_id);

        foreach ($classroom->classroomStudents as $c_student) {
            $finalGrade = $c_student->student->overAllAverageTaskByClassroom($classroom->id);

            // Get or create academic record
            $academicRecord = AcademicRecord::firstOrCreate([
                'student_id' => $c_student->student_id,
                'classroom_id' => $classroom->id
            ]);

            // Create or update grade
            Grade::updateOrCreate(
                [
                    'academic_record_id' => $academicRecord->id,
                    'classroom_id' => $classroom->id,
                ],
                [
                    'quarter' => 'Q1', // You might want to make this dynamic
                    'grade' => $finalGrade,
                    'remarks' => $finalGrade >= 75 ? 'Passed' : 'Failed',
                    'status' => GeneralStatus::GRADED->value,
                    'created_by' => Auth::id(),
                    'subject' => $classroom->subject->name
                ]
            );
        }

        return back()->with('success', 'Final grades have been submitted successfully');
    }

    private function getRemarks(float $grade): string
    {
        if ($grade >= 90) {
            return 'Outstanding';
        } elseif ($grade >= 85) {
            return 'Very Good';
        } elseif ($grade >= 80) {
            return 'Good';
        } elseif ($grade >= 75) {
            return 'Satisfactory';
        } else {
            return 'Failed';
        }
    }
}
