<?php

namespace App\Http\Controllers\Student;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\GeneralAnnouncement;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{


    public function index(Request $request){
        $announcements = GeneralAnnouncement::latest()->paginate(10);

        if($request->type === 'classroom'){
            $announcements = Announcement::latest()->paginate(10);
        }

        return view('users.student.announcement.index', compact('announcements'));
    }

    public function show(string $id){
        return Announcement::find($id);
    }
}
