<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Models\GeneralAnnouncement;
use App\Http\Controllers\Controller;

class GeneralAnnouncementController extends Controller
{
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
            $imagePath = $image->storeAs('public/announcements',  $image->getClientOriginalName());
        }


        $announcement = GeneralAnnouncement::create([
            'title' => $request->title,
            'description' => $request->description,
            'posted_by' => auth()->user()->id,
            'is_posted' => $request->is_posted ?? false,
            'image' => asset('storage/' .  str_replace('public/', '', $imagePath)) ?? null,
        ]);



        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            foreach ($files as $file) {
                $path = $file->storeAs('public/announcements',  $file->getClientOriginalName());
                Attachment::create([
                    'attachable_id' => $announcement->id,
                    'attachable_type' => get_class($announcement),
                    'file_dir' => asset('storage/' .  str_replace('public/', '', $path)),
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('admin.general-announcements.index')->with('success', 'Announcement created successfully');
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
            'posted_by' => 'required',
            'is_posted' => 'nullable',
        ]);

        $announcement = GeneralAnnouncement::findOrFail($id);
        $announcement->update($request->all());
        return redirect()->route('admin.general-announcements.index')->with('success', 'Announcement updated successfully');
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
        $announcement->is_posted = !$announcement->is_posted;
        $announcement->save();
        return back()->with('success', 'Announcement toggled successfully');
    }
}
