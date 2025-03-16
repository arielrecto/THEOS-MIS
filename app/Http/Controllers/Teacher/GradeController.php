<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $classroom_id = $request->classroom_id;

        $classroom = Classroom::with(['tasks', 'classroomStudents.student'])->whereId($classroom_id)->first();

        $tasks = $classroom->tasks;

        $students = $classroom->classroomStudents;

        return view('users.teacher.classroom.grade.index', compact('tasks', 'students', 'classroom_id'));
    }

}
