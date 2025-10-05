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
        $student = User::find(auth()->user()->id);

        // Get upcoming tasks for the student
        $tasks = StudentTask::with(['task', 'grade'])
            ->where('user_id', auth()->id())
            ->whereHas('task', function($query) {
                $query->where('due_date', '>=', now())
                      ->orderBy('due_date', 'asc');
            })
            ->take(5)
            ->get();

        $announcements = GeneralAnnouncement::with(['postedBy', 'attachments'])
            ->withCount('attachments')
            ->where('is_published', true)
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
