<?php

namespace App\Http\Controllers\Teacher;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\GeneralAnnouncement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AnnouncementNotification;
use App\Models\Comment;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $announcements = GeneralAnnouncement::with(['postedBy', 'attachments'])
            ->latest()
            ->paginate(10);


        if ($request->type === 'classroom') {
            $announcements = Announcement::with(['classroom.subject', 'classroom.teacher'])
                ->whereHas('classroom', function($query) {
                    $query->where('teacher_id', Auth::id());
                })
                ->latest()
                ->paginate(10);
        }

        return view('users.teacher.announcement.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $classroom_id = $request->classroom;

        return view('users.teacher.classroom.announcement.create', compact(['classroom_id']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['title' => 'required', 'description' => 'required']);

        $classroomId = $request->classroom_id;


        $announcement = Announcement::create([
            'title' => $request->title,
            'description' => $request->description,
            'classroom_id' => $classroomId
        ]);

        $students = User::where(function ($q) use ($classroomId) {
            $q->whereHas('asStudentClassrooms', function ($q) use ($classroomId) {
                $q->whereId($classroomId);
            });
        })->get();


        if ($request->hasFile('attachment')) {

            $imageName = 'IMG-' . uniqid() . '.' . $request->attachment->extension();
            $dir = $request->attachment->storeAs('/event', $imageName, 'public');


            $announcement->update([
                'file_dir' =>  asset('/storage/' . $dir),
            ]);
        }



        if (count($students) !== 0) {
            $message = [
                'header' => "Announcement - {$request->title}",
                'message' => $request->description
            ];

            collect($students)->map(function ($student) use ($message) {
                $student->notify(new AnnouncementNotification($message));
            });
        }
        return back()->with(['success' => 'announcement posted', 'classroom_id' => $classroomId]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $type = $request->query('type', 'general');

        if ($type === 'general') {
            $announcement = GeneralAnnouncement::with(['postedBy.profile', 'attachments', 'comments.user'])
                ->where('posted_by', auth()->id())
                ->findOrFail($id);
        } else {
            $announcement = Announcement::with([
                'classroom.teacher.profile',
                'classroom.subject',
                'comments.user'
            ])
            ->whereHas('classroom', function($query) {
                $query->where('teacher_id', auth()->id());
            })
            ->findOrFail($id);
        }

        return view('users.teacher.announcement.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $announcement = Announcement::whereHas('classroom', function($query) {
                $query->where('teacher_id', Auth::id());
            })
            ->findOrFail($id);

        return view('users.teacher.announcement.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $announcement = Announcement::whereHas('classroom', function($query) {
                $query->where('teacher_id', Auth::id());
            })
            ->findOrFail($id);

        $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($announcement->file_dir && Storage::exists('public/' . $announcement->file_dir)) {
                Storage::delete('public/' . $announcement->file_dir);
            }

            $fileName = 'FILE-' . uniqid() . '.' . $request->attachment->extension();
            $path = $request->attachment->storeAs('announcements', $fileName, 'public');

            $announcement->update([
                'file_dir' => $path,
            ]);
        }

        return redirect()
            ->route('teacher.announcements.show', ['id' => $announcement->id, 'type' => 'classroom'])
            ->with('success', 'Announcement updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function removeFile(string $id)
    {
        $announcement = Announcement::whereHas('classroom', function($query) {
                $query->where('teacher_id', Auth::id());
            })
            ->findOrFail($id);

        if ($announcement->file_dir && Storage::exists('public/' . $announcement->file_dir)) {
            Storage::delete('public/' . $announcement->file_dir);
        }

        $announcement->update(['file_dir' => null]);

        return response()->json(['message' => 'File removed successfully']);
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
