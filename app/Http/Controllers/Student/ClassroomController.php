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
        $classrooms = Classroom::where(function ($q) use ($user) {
            $q->whereHas('classroomStudents', function ($q) use ($user) {
                $q->where('student_id', $user->id);
            });
        })->with([
            'strand', 'subject', 'teacher', 'announcements'
        ])->get();


        return response([
            'classrooms' => $classrooms
        ], 200);
    }

    public function join(Request $request)
    {

        $classroom = Classroom::where('class_code', $request->classCode)->with([
            'strand', 'subject', 'teacher'
        ])->first();


        $user = Auth::user();



        if (!$classroom) {
            return response([
                'error' => [
                    'class_code' => 'Class Code Doesn\'t Exist'
                ]
            ], 404);
        }


        ClassroomStudent::create([
            'student_id' => $user->id,
            'classroom_id' => $classroom->id
        ]);


        return response([
            'classroom' => $classroom
        ], 200);
    }

    public function show (string $id){

        $user = Auth::user();
        $classroom = Classroom::where('id', $id)->with([
            'strand', 'subject', 'teacher', 'announcements'
        ])->withCount(['announcements', 'tasks' => function($q) use($user){
            $q->whereHas('assignStudents', function($q) use($user){
                $q->where('user_id', $user->id);
            });
        }])->first();



        return response([
            'classroom' => $classroom
        ], 200);
    }

    public function attendances(string $id){


        $user = Auth::user();

        $classroom = Classroom::whereId($id)->first();

        $attendances = $classroom->first()->attendanceStudents()->where(function($q) use($user){
            $q->where('user_id', $user->id);
        })->latest()->get();

        $attendance = $classroom->attendances()->latest()->first();

        return response([
            'attendances' => $attendances,
            'attendance' => $attendance
        ]);
    }
}
