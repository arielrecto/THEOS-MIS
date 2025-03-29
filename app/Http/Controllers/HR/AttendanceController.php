<?php

namespace App\Http\Controllers\HR;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Models\EmployeeProfile;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = EmployeeProfile::with(['user', 'position.department', 'attendanceLogs']);

        // Search filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%");
            });
        }

        // Department filter
        if ($request->filled('department')) {
            $query->whereHas('position.department', function($q) use ($request) {
                $q->where('id', $request->department);
            });
        }

        $employees = $query->latest()->paginate(10);
        $departments = Department::all();

        return view('users.hr.attendance.index', compact('employees', 'departments'));
    }

    public function show(string $id)
    {
        $employee = EmployeeProfile::with(['user', 'position.department'])->findOrFail($id);

        $startDate = request('start_date', now()->startOfMonth());
        $endDate = request('end_date', now());

        $attendances = $employee->attendanceLogs()
            ->whereBetween('time_in', [$startDate, $endDate])
            ->latest('time_in')
            ->paginate(10);

        $totalDays = $attendances->total();

        $totalHours = $employee->attendanceLogs()
            ->whereNotNull('time_out')
            ->whereBetween('time_in', [$startDate, $endDate])
            ->get()
            ->sum(function($log) {
                return $log->time_out->diffInHours($log->time_in);
            });

        $averageHours = $totalDays > 0 ? $totalHours / $totalDays : 0;

        $lateCount = $employee->attendanceLogs()
            ->where('status', 'late')
            ->whereBetween('time_in', [$startDate, $endDate])
            ->count();

        return view('users.hr.attendance.show', compact(
            'employee',
            'attendances',
            'totalDays',
            'totalHours',
            'averageHours',
            'lateCount'
        ));
    }
}
