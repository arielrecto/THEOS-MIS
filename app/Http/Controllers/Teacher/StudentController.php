<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\UserRoles;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceStudent;
use App\Models\Classroom;
use App\Models\LearnerObservedValue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $classroom_id = $request->classroom_id;
        $query = User::role(UserRoles::STUDENT->value)->with(['profile', 'asStudentClassrooms', 'asStudentClassrooms']);

        if ($classroom_id) {
            $query->whereHas('asStudentClassrooms', function ($query) use ($classroom_id) {
                $query->where('classroom_id', $classroom_id);
            });
        }

        $students = $query->latest()->paginate(10);

        return view('users.teacher.student.index', compact('students', 'classroom_id'));
    }

    public function show(string $id, Request $request)
    {
        $classroom_id = $request->classroom_id;
        $student = User::with(['profile', 'tasks'])->findOrFail($id);
        if($student->studentProfile?->academicRecords()->count() == 0) {
            return back()->with('error', 'No academic record found for this student. Please ensure the student has an academic record before viewing details.');
        }
        $classrooms = $student->asStudentClassrooms()->with('classroom')->get()->pluck('classroom');
        $academicYear = $student->studentProfile->academicRecords()->latest()->first()->academicYear ?? null;
        // Get attendance data
        $student_attendances = AttendanceStudent::where('user_id', $student->id)
            ->with(['attendance.classroom.subject'])
            ->latest()
            ->paginate(10);

        // Calculate attendance metrics
        $totalAttendances = $student_attendances->total();
        $presentCount = AttendanceStudent::where('status', 'present')
        ->where('user_id', $student->id)->count();
        $absentCount = 0;
        $attendanceRate = $totalAttendances > 0 ? ($presentCount / $totalAttendances) * 100 : 0;

        // Get task metrics
        $studentTasks = $student->tasks()->latest('created_at')->take(5)->get();

        $totalTasks = $student->tasks()->count();
        $completedTasks = $student->tasks()->where('status', 'submitted')->count();
        $taskCompletionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        // Calculate average grade
        if ($classroom_id) {
            $averageGrade = $student->overAllAverageTaskByClassroom($classroom_id);
        } else {
            $averageGrade = $student->overallGrade();
        }

        return view('users.teacher.student.show', compact('student', 'classrooms', 'student_attendances', 'attendanceRate', 'presentCount', 'absentCount', 'studentTasks', 'totalTasks', 'completedTasks', 'taskCompletionRate', 'averageGrade', 'academicYear'));
    }

    public function uploadAttendance(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'attendance_csv' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $classroom = Classroom::where('id', $request->classroom_id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        $file = $request->file('attendance_csv');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);

        $months = ['Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar','Apr','May'];

        while (($row = fgetcsv($handle)) !== false) {
            $studentName = trim($row[0]);
            $user = User::where('name', $studentName)->first();
            if (!$user) continue;

            // Find or create attendance record for this classroom and student
            foreach ($months as $i => $month) {
                $daysPresent = is_numeric($row[$i+1]) ? (int)$row[$i+1] : 0;

                // You may want to store each month as a separate Attendance record, or as a JSON column, or as AttendanceStudent rows.
                // Example: store as AttendanceStudent per month
                AttendanceStudent::updateOrCreate([
                    'user_id' => $user->id,
                    'classroom_id' => $classroom->id,
                    'month' => $month,
                ], [
                    'days_present' => $daysPresent,
                ]);
            }
        }
        fclose($handle);

        return back()->with('success', 'Attendance uploaded successfully!');
    }

    public function saveCoreValues(Request $request, $studentId, $academicYearId)
    {
        $data = $request->input('values', []);
        foreach ($data as $core => $statements) {
            foreach ($statements as $statement => $quarters) {
                LearnerObservedValue::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'academic_year_id' => $academicYearId,
                        'core_value' => $core,
                        'behavior_statement' => $statement,
                    ],
                    [
                        'quarter_1' => $quarters['quarter_1'] ?? null,
                        'quarter_2' => $quarters['quarter_2'] ?? null,
                        'quarter_3' => $quarters['quarter_3'] ?? null,
                        'quarter_4' => $quarters['quarter_4'] ?? null,
                    ]
                );
            }
        }
        return back()->with('success', 'Core values updated!');
    }
}
