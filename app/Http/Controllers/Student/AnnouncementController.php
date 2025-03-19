<?php

namespace App\Http\Controllers\Student;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\GeneralAnnouncement;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $announcements = GeneralAnnouncement::with('postedBy')
            ->latest()
            ->paginate(10);

        if ($request->type === 'classroom') {
            $announcements = Announcement::with(['classroom.subject', 'classroom.teacher'])
                ->latest()
                ->paginate(10);
        }

        return view('users.student.announcement.index', compact('announcements'));
    }

    public function show(Request $request, string $id)
    {
        $type = $request->query('type', 'general');

        if ($type === 'general') {
            $announcement = GeneralAnnouncement::with(['postedBy', 'attachments'])
                ->findOrFail($id);
        } else {
            $announcement = Announcement::with(['classroom.subject', 'classroom.teacher'])
                ->findOrFail($id);
        }

        return view('users.student.announcement.show', compact('announcement'));
    }
}
