<?php

namespace App\Http\Controllers\Student;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClassroomStudent;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function index()
    {


        $user = Auth::user();
        $myClassrooms = Classroom::where(function ($q) use ($user) {
            $q->whereHas('classroomStudents', function ($q) use ($user) {
                $q->where('student_id', $user->id);
            });
        })->paginate(10);

        $classrooms = Classroom::whereDoesntHave('classroomStudents', function ($q) use ($user) {
            $q->where('student_id', $user->id);
        })->paginate(10);


        return view('users.student.classroom.index', compact('myClassrooms', 'classrooms'));
    }

    public function join(Request $request)
    {

        $classroom = Classroom::where('class_code', $request->class_code)->with([
            'strand',
            'subject',
            'teacher'
        ])->first();


        $user = Auth::user();



        if (!$classroom) {
            return back()->with('error', 'Classroom doesn\'t exist');
        }


        ClassroomStudent::create([
            'student_id' => $user->id,
            'classroom_id' => $classroom->id
        ]);


        return back()->with('success', 'Classroom joined successfully');
    }

    public function show(string $id)
    {



        $user = Auth::user();

        $classroom = Classroom::where('id', $id)->with([
            'strand',
            'subject',
            'teacher',
            'announcements'
        ])->withCount(['announcements', 'tasks' => function ($q) use ($user) {
            $q->whereHas('assignStudents', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }])
        ->whereHas('classroomStudents', function ($q) use ($user) {
            $q->where('student_id', $user->id);
        })->first();

        if (!$classroom) {
            return back()->with('error', 'can\'t view this classroom you are not enrolled in this classroom');
        }



        return response([
            'classroom' => $classroom
        ], 200);
    }

    public function attendances(string $id)
    {


        $user = Auth::user();

        $classroom = Classroom::whereId($id)->first();

        $attendances = $classroom->first()->attendanceStudents()->where(function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->latest()->get();

        $attendance = $classroom->attendances()->latest()->first();

        return response([
            'attendances' => $attendances,
            'attendance' => $attendance
        ]);
    }
}
