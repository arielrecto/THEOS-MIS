<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceStudent;

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

        // Get attendance data
        $student_attendances = AttendanceStudent::where('classroom_id', $classroom_id)
            ->where('user_id', $student->id)
            ->with(['attendance.classroom.subject'])
            ->latest()
            ->paginate(10);

        // Calculate attendance metrics
        $totalAttendances = $student_attendances->total();
        $presentCount = $student_attendances->where('status', 'present')->count();
        $absentCount = $totalAttendances - $presentCount;
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

        return view('users.teacher.student.show', compact('student', 'student_attendances', 'attendanceRate', 'presentCount', 'absentCount', 'studentTasks', 'totalTasks', 'completedTasks', 'taskCompletionRate', 'averageGrade'));
    }
}
