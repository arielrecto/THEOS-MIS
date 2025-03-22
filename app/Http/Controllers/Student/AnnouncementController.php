<?php

namespace App\Http\Controllers\Student;

use App\Models\Comment;
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
            $announcement = GeneralAnnouncement::with(['postedBy', 'attachments', 'comments.user'])
                ->findOrFail($id);
        } else {
            $announcement = Announcement::with(['classroom.subject', 'classroom.teacher', 'comments.user'])
                ->findOrFail($id);
        }

        return view('users.student.announcement.show', compact('announcement'));
    }

    public function storeComment(Request $request, string $id)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:1000']
        ]);

        $type = $request->query('type', 'general');
        $model = $type === 'general' ? GeneralAnnouncement::class : Announcement::class;

        $announcement = $model::findOrFail($id);

        $announcement->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id()
        ]);

        return back()->with('success', 'Comment posted successfully');
    }

    public function destroyComment(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully');
    }
}
