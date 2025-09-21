<?php


namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now());

        $attendances = AttendanceLog::where('employee_profile_id', auth()->user()->employee->id)
            ->whereBetween('time_in', [$startDate, $endDate])
            ->latest('time_in')
            ->paginate(10);

        $totalHours = auth()->user()->employee->attendanceLogs()
            ->whereNotNull('time_out')
            ->whereBetween('time_in', [$startDate, $endDate])
            ->get()
            ->sum(function($log) {
                return $log->time_out->diffInHours($log->time_in);
            });

        $averageHours = $attendances->count() > 0
            ? $totalHours / $attendances->count()
            : 0;

        return view('users.employee.attendance.index', compact(
            'attendances',
            'totalHours',
            'averageHours'
        ));
    }

    public function checkIn()
    {
        // Check if already checked in today
        $existingLog = AttendanceLog::where('employee_profile_id', auth()->user()->employee->id)
            ->whereDate('time_in', today())
            ->first();

        if ($existingLog) {
            return redirect()
                ->route('employee.attendance.index')
                ->with('error', 'You have already checked in today');
        }

        // Create new attendance log
        $attendance = AttendanceLog::create([
            'employee_profile_id' => auth()->user()->employee->id,
            'time_in' => now(),
        ]);

        return redirect()
            ->route('employee.attendance.index')
            ->with('success', 'Successfully checked in at ' . $attendance->time_in->format('h:i A'));
    }

    public function checkOut()
    {
        // Find today's attendance log
        $attendance = AttendanceLog::where('employee_profile_id', auth()->user()->employee->id)
            ->whereDate('time_in', today())
            ->whereNull('time_out')
            ->first();

        if (!$attendance) {
            return redirect()
                ->route('employee.attendance.index')
                ->with('error', 'No active check-in found for today');
        }

        // Update with check-out time
        $attendance->update([
            'time_out' => now(),
        ]);

        return redirect()
            ->route('employee.attendance.index')
            ->with('success', 'Successfully checked out at ' . $attendance->time_out->format('h:i A'));
    }

    private function calculateAttendanceStatus($attendance)
    {
        $totalHours = $attendance->time_out->diffInHours($attendance->time_in);

        if ($totalHours < 4) {
            return 'absent';
        } elseif ($totalHours < 8) {
            return 'half_day';
        }

        return $attendance->status; // Keep original status (present/late)
    }

    public function printAttendance(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now());



        $user = User::where('id', Auth::user()->id)->first();

        




        $attendanceLogs = AttendanceLog::where('employee_profile_id', $user->employee->id)
           ->whereBetween('time_in', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
            ->latest('time_in')
            ->get();




        $totalHours = $user->employee->attendanceLogs()
            ->whereNotNull('time_out')
            ->whereBetween('time_in', [$startDate, $endDate])
            ->get()
            ->sum(function($log) {
                return $log->time_out->diffInHours($log->time_in);
            });

        $averageHours = $attendanceLogs->count() > 0
            ? $totalHours / $attendanceLogs->count()
            : 0;



        return view('users.employee.attendance.print', compact(
            'attendanceLogs',
            'totalHours',
            'averageHours'
        ));
    }
}
