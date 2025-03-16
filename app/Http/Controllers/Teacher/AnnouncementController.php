<?php

namespace App\Http\Controllers\Teacher;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\AnnouncementNotification;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $classroom_id = $request->classroom_id;

        $announcements = Announcement::where('classroom_id', $classroom_id)->latest()->paginate(10);

        return view('users.teacher.classroom.announcement.index', compact(['announcements', 'classroom_id']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $classroom_id = $request->classroom_id;



        return view('users.teacher.classroom.announcement.create', compact('classroom_id'));
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

        $students = User::where(function($q) use($classroomId){
            $q->whereHas('asStudentClassrooms', function($q) use ($classroomId){
                $q->whereId($classroomId);
            });
        })->get();


        if($request->hasFile('attachment')){

            $imageName = 'IMG-' . uniqid() . '.' . $request->attachment->extension();
            $dir = $request->attachment->storeAs('/event', $imageName, 'public');


            $announcement->update([
                'file_dir' =>  asset('/storage/' . $dir),
            ]);
        }



        if(count($students) !== 0){
            $message = [
                'header' => "Announcement - {$request->title}",
                'message' => $request->description
            ];

            collect($students)->map(function($student) use($message) {
                $student->notify(new AnnouncementNotification($message));
            });
        }
        return back()->with(['message' => 'announcement posted', 'classroom_id' => $classroomId]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $announcement = Announcement::find($id);

        $classroom_id = $request->classroom_id;


        return view('users.teacher.classroom.announcement.show', compact(['announcement', 'classroom_id']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
