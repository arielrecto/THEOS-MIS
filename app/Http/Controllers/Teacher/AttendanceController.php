<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Classroom;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\AttendanceStudent;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Classroom $classroom)
    {
        $attendance_code = 'ATT' . uniqid();

        return view('users.teacher.classroom.attendance.create', compact(['classroom', 'attendance_code']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required'
        ]);


        Attendance::create([
            'attendance_code' => $request->attendance_code,
            'classroom_id' => $request->classroom_id,
            'date' => now(),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time
        ]);


        return to_route('teacher.classrooms.show', ['classroom' => $request->classroom_id])->with(['message' => 'Attendance QR Generated']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function scanner(string $id, Request $request)
    {
        $attendance = Attendance::find($id);

        $classroomId = $request->classroom_id;

        $students = $attendance->attendanceStudents()->get()->toJson();


        return view('users.teacher.classroom.attendance.scanner', compact(['attendance', 'classroomId', 'students']));
    }

    public function studentAttendance(Request $request){

        $attendance = Attendance::where('attendance_code', $request->attendanceCode)->first();


        if(!$attendance){
            return response([
                'error' => [
                    'attendance_code' => "Attendance Code Doesn\'t Exist"
                ]
            ], 422);
        }


       $student = AttendanceStudent::create([
            'attendance_id' => $attendance->id,
            'classroom_id' => $request->classroom,
            'user_id' => $request->student
        ]);



        return response([
            'student' => $student
        ]);
    }
}
