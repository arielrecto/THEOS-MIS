<?php

namespace App\Http\Controllers\Student;

use App\Enums\GeneralStatus;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function log(Request $request)
    {


        $attendance = Attendance::where('attendance_code', $request->attendanceCode)->first();

        if (!$attendance) {
            return response()->json(
                [
                    'message' => 'Invalid or expired attendance code',
                ],
                422,
            );
        }

        // Check if student already logged attendance
        $existing = AttendanceStudent::where('attendance_id', $attendance->id)->where('user_id', Auth::user()->id   )->exists();

        if ($existing) {
            return response()->json(
                [
                    'message' => 'Attendance already recorded',
                ],
                422,
            );
        }

        AttendanceStudent::create([
            'attendance_id' => $attendance->id,
            'classroom_id' => $attendance->classroom->id,
            'user_id' => Auth::user()->id,
            'status' =>  'present'
        ]);

        return response()->json([
            'message' => 'Attendance recorded successfully',
        ]);
    }

    public function index()
    {
        $user = Auth::user();

        // Get all attendance records
        $attendances = AttendanceStudent::with(['attendance.classroom.subject', 'attendance.classroom.teacher'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        // Calculate statistics
        $totalAttendances = $attendances->total();
        $presentCount = AttendanceStudent::where('status', 'present')->count();
        $absentCount = $totalAttendances - $presentCount;
        $presentRate = $totalAttendances > 0 ? ($presentCount / $totalAttendances) * 100 : 0;

        return view('users.student.attendance.index', compact('attendances', 'presentCount', 'absentCount', 'presentRate'));
    }

    public function scanner()
    {
        return view('users.student.attendance.scan');
    }
}
