<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function log(Request $request){
        $attendance = Attendance::where('attendance_code', $request->attendanceCode)->first();

        if(!$attendance){
            return response([
                'error' => [
                    'attendance_code' => "Attendance Code Doesn\'t Exist"
                ]
            ], 422);
        }


        AttendanceStudent::create([
            'attendance_id' => $attendance->id,
            'classroom_id' => $request->classroomId,
            'user_id' => Auth::user()->id
        ]);



        return response([
            'message' => 'Attendance Success'
        ], 200);

    }

    // public function index(string $id){

    //     $user = Auth::user();

    //      $attendances = Attendance::where(function($q) use($id, $user) {
    //         $q->whereHas('classroom', function($q) use($id, $user) {
    //             $q->whereId($id)
    //             ->whereHas('classroomStudents', function($q) use($user){
    //                 $q->where('student_id', $user->id);
    //             });
    //         });
    //      })->get();



    //      return response([
    //         'attendances' => $attendances,
    //         'total_attendances' => count($attendances)
    //      ]);
    // }
}
