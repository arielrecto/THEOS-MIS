<?php

namespace App\Http\Controllers\Teacher;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceStudent;

class StudentController extends Controller
{
    public function show(string $id, Request $request)
    {

        $classroom_id = $request->classroom_id;
        $student = User::find($id);

        $student_attendances = AttendanceStudent::where('classroom_id', $classroom_id)
            ->where('user_id', $student->id)->latest()->paginate(10);


        return view('users.teacher.student.show', compact('student', 'student_attendances'));
    }
}
