<?php

namespace App\Http\Controllers\HR;

use App\Models\Leave;
use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use Illuminate\Support\Carbon;
use App\Models\EmployeeProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Total Employees
        $totalEmployees = EmployeeProfile::count();

        // New Hires (last 30 days)
        $newHires = EmployeeProfile::where('created_at', '>=', now()->subDays(30))->count();

        // Pending Leave Requests
        $pendingLeaves = Leave::where('status', 'pending')->count();

        // Department Distribution
        $departmentDistribution = EmployeeProfile::select('departments.name', DB::raw('count(*) as count'))
            ->join('job_positions', 'employee_profiles.job_position_id', '=', 'job_positions.id')
            ->join('departments', 'job_positions.department_id', '=', 'departments.id')
            ->groupBy('departments.id', 'departments.name')
            ->get()
            ->map(function ($item) use ($totalEmployees) {
                return [
                    'name' => $item->name,
                    'count' => $item->count,
                    'percentage' => round(($item->count / $totalEmployees) * 100)
                ];
            });

        // Attendance Analytics
        $today = Carbon::today();
        $attendanceAnalytics = [
            'present' => AttendanceLog::whereDate('time_in', $today)->count(),
            'late' => AttendanceLog::whereDate('time_in', $today)
                ->whereTime('time_in', '>', '08:00:00')
                ->count(),
            'total_hours' => AttendanceLog::whereDate('time_in', $today)
                ->whereNotNull('time_out')
                ->get()
                ->sum(function ($log) {
                    return $log->time_out->diffInHours($log->time_in);
                })
        ];

        // Recent Activities
        $recentActivities = collect([])
            ->merge(EmployeeProfile::with('position')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($employee) {
                    return [
                        'type' => 'new_hire',
                        'message' => "{$employee->first_name} {$employee->last_name} joined as {$employee->position->name}",
                        'date' => $employee->created_at
                    ];
                }))
            ->merge(Leave::with('employee')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($leave) {
                    return [
                        'type' => 'leave_request',
                        'message' => "{$leave->employee->first_name} {$leave->employee->last_name}'s leave request {$leave->status}",
                        'date' => $leave->updated_at
                    ];
                }))
            ->sortByDesc('date')
            ->take(5);

        return view('users.hr.dashboard', compact(
            'totalEmployees',
            'newHires',
            'pendingLeaves',
            'departmentDistribution',
            'attendanceAnalytics',
            'recentActivities'
        ));
    }
}
