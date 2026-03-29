<?php

namespace App\Http\Controllers\Teacher;

use App\Models\User;
use App\Models\Classroom;
use App\Models\ClassroomTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $teacher = Auth::user();

        // Get teacher's classrooms with related data
        $classrooms = Classroom::where('teacher_id', $teacher->id)
        ->with([
            'subject',
            'classroomStudents',
            'academicYear'
        ])
        ->withCount('classroomStudents')
        ->latest()
        ->get();

        // Get total counts for stats
        $totalClassrooms = $classrooms->count();
        $totalStudents = $classrooms->sum('students_count');

        // Get unique subjects count
        $totalSubjects = $classrooms->pluck('subject_id')->unique()->count();

        // Get recent/upcoming tasks from teacher's classrooms
        $recentTasks = Task::whereIn('classroom_id', $classrooms->pluck('id'))
            ->with(['classroom.subject'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get upcoming deadlines (tasks due in the next 30 days)
        $upcomingDeadlines = Task::whereIn('classroom_id', $classrooms->pluck('id'))
            ->where('deadline', '>=', now())
            ->where('deadline', '<=', now()->addDays(30))
            ->with(['classroom.subject'])
            ->orderBy('deadline', 'asc')
            ->limit(5)
            ->get();

        return view('users.teacher.dashboard', compact(
            'classrooms',
            'totalClassrooms',
            'totalStudents',
            'totalSubjects',
            'recentTasks',
            'upcomingDeadlines'
        ));
    }
}
