<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\GeneralAnnouncement;
use App\Models\StudentTask;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Get the authenticated student with their academic records and grades
        $student = User::with([
            'studentProfile.academicRecords' => function($query) {
                $query->with(['academicYear', 'grades', 'section.strand'])
                      ->orderBy('created_at', 'desc');
            }
        ])->find(auth()->id());

        // Get upcoming tasks for the authenticated student
        $tasks = StudentTask::with(['task.classroom.subject', 'grade'])
            ->where('user_id', auth()->id())
            ->whereHas('task', function($query) {
                $query->where('due_date', '>=', now())
                      ->orderBy('due_date', 'asc');
            })
            ->take(5)
            ->get();

        // Get latest announcements
        $announcements = GeneralAnnouncement::with(['postedBy', 'attachments'])
            ->withCount('attachments')
            ->where(function($query) {
                $query->where('expires_at', '>', now())
                      ->orWhereNull('expires_at');
            })
            ->latest()
            ->take(5)
            ->get();

        return view('users.student.dashboard', compact('student', 'announcements', 'tasks'));
    }
}
