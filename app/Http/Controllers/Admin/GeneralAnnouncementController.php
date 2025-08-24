<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Actions\NotificationActions;
use App\Models\GeneralAnnouncement;
use App\Http\Controllers\Controller;

class GeneralAnnouncementController extends Controller
{
    protected $notificationActions;

    public function __construct(NotificationActions $notificationActions)
    {
        $this->notificationActions = $notificationActions;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = GeneralAnnouncement::latest()->paginate(10);


        return view('users.admin.announcement.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'is_posted' => 'nullable',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->storeAs('public/announcements', $image->getClientOriginalName());
        }

        $announcement = GeneralAnnouncement::create([
            'title' => $request->title,
            'description' => $request->description,
            'posted_by' => auth()->user()->id,
            'is_posted' => $request->is_posted ?? false,
            'image' => $imagePath ? asset('storage/' . str_replace('public/', '', $imagePath)) : null,
        ]);

        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            foreach ($files as $file) {
                $path = $file->storeAs('public/announcements', $file->getClientOriginalName());
                Attachment::create([
                    'attachable_id' => $announcement->id,
                    'attachable_type' => get_class($announcement),
                    'file_dir' => asset( str_replace('public/', '', $path)),
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        // Send notification if announcement is posted
        if ($announcement->is_posted) {
            $notificationData = [
                'header' => 'New Announcement',
                'message' => "New announcement: {$announcement->title}",
                'type' => 'announcement',
                'url' => route('student.announcements.show', ['id' => $announcement->id, 'type' => 'general'])
            ];

            // Notify all users except admins
            $users = \App\Models\User::whereDoesntHave('roles', function($query) {
                $query->where('name', 'admin');
            })->get();

            $this->notificationActions->notifyUsers($users, $notificationData, $announcement);
        }

        return redirect()
            ->route('admin.general-announcements.index')
            ->with('success', 'Announcement created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $announcement = GeneralAnnouncement::findOrFail($id);
        return view('users.admin.announcement.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $announcement = GeneralAnnouncement::findOrFail($id);
        return view('users.admin.announcement.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'is_posted' => 'nullable',
        ]);

        $announcement = GeneralAnnouncement::findOrFail($id);
        $wasPosted = $announcement->is_posted;

        $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_posted' => $request->is_posted ?? false,
        ]);

        // Send notification if announcement is newly posted
        if (!$wasPosted && $announcement->is_posted) {
            $notificationData = [
                'header' => 'New Announcement',
                'message' => "New announcement: {$announcement->title}",
                'type' => 'announcement',
                'url' => route('student.announcements.show', ['id' => $announcement->id, 'type' => 'general'])
            ];

            // Notify all users except admins
            $users = \App\Models\User::whereDoesntHave('roles', function($query) {
                $query->where('name', 'admin');
            })->get();

            $this->notificationActions->notifyUsers($users, $notificationData, $announcement);
        }

        return redirect()
            ->route('admin.general-announcements.index')
            ->with('success', 'Announcement updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = GeneralAnnouncement::findOrFail($id);
        $announcement->delete();
        return redirect()->route('admin.general-announcements.index')->with('success', 'Announcement deleted successfully');
    }

    public function toggle(string $id)
    {
        $announcement = GeneralAnnouncement::findOrFail($id);
        $wasPosted = $announcement->is_posted;

        $announcement->is_posted = !$announcement->is_posted;
        $announcement->save();

        // Send notification if announcement is newly posted
        if (!$wasPosted && $announcement->is_posted) {
            $notificationData = [
                'header' => 'New Announcement',
                'message' => "New announcement: {$announcement->title}",
                'type' => 'announcement',
                'url' => route('student.announcements.show', ['id' => $announcement->id, 'type' => 'general'])
            ];

            // Notify all users except admins
            $users = \App\Models\User::whereDoesntHave('roles', function($query) {
                $query->where('name', 'admin');
            })->get();

            $this->notificationActions->notifyUsers($users, $notificationData, $announcement);
        }

        return back()->with('success', 'Announcement toggled successfully');
    }
}
