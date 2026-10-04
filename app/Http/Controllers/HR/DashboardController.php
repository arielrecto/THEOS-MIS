<?php

namespace App\Http\Controllers\HR;

use App\Models\Leave;
use App\Enums\LeaveStatus;
use Illuminate\Support\Carbon;
use App\Models\EmployeeProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();
        $openLeaveStatuses = [LeaveStatus::PENDING->value, LeaveStatus::APPROVED->value];

        $totalEmployees = EmployeeProfile::current()->count();

        $newHires = EmployeeProfile::current()->where('created_at', '>=', now()->subDays(30))->count();

        $pendingLeaves = Leave::where('status', LeaveStatus::PENDING->value)->count();

        $departmentDistribution = EmployeeProfile::current()
            ->select('departments.name', DB::raw('count(*) as count'))
            ->join('job_positions', 'employee_profiles.job_position_id', '=', 'job_positions.id')
            ->join('departments', 'job_positions.department_id', '=', 'departments.id')
            ->groupBy('departments.id', 'departments.name')
            ->orderByDesc('count')
            ->get()
            ->map(fn($item) => [
                'name' => $item->name,
                'count' => $item->count,
                'percentage' => $totalEmployees > 0 ? round(($item->count / $totalEmployees) * 100) : 0,
            ]);

        $recentActivities = collect()
            ->merge(EmployeeProfile::with('position')->latest()->take(5)->get()->map(fn($employee) => [
                'type' => 'new_hire',
                'message' => trim("{$employee->first_name} {$employee->last_name} joined")
                    . ($employee->position ? " as {$employee->position->name}" : ''),
                'date' => $employee->created_at,
            ]))
            ->merge(Leave::with('employee')->whereHas('employee')->latest('updated_at')->take(5)->get()->map(fn($leave) => [
                'type' => 'leave_request',
                'message' => "{$leave->employee->first_name} {$leave->employee->last_name}'s leave request {$leave->status}",
                'date' => $leave->updated_at,
            ]))
            ->sortByDesc('date')
            ->take(5)
            ->values();

        $upcomingLeaves = Leave::with('employee')
            ->whereHas('employee')
            ->whereIn('status', $openLeaveStatuses)
            ->whereDate('end_date', '>=', $today)
            ->orderBy('start_date')
            ->take(5)
            ->get();

        $birthdays = EmployeeProfile::current()
            ->whereNotNull('date_of_birth')
            ->whereMonth('date_of_birth', $today->month)
            ->get()
            ->sortBy(fn($employee) => $employee->date_of_birth->day)
            ->values();

        // Days of this month that have leave or a birthday, for the calendar markers.
        $calendarMarks = [];
        Leave::whereIn('status', $openLeaveStatuses)
            ->whereDate('start_date', '<=', $monthEnd)
            ->whereDate('end_date', '>=', $monthStart)
            ->get(['start_date', 'end_date'])
            ->each(function ($leave) use (&$calendarMarks, $monthStart, $monthEnd) {
                $from = Carbon::parse($leave->start_date)->max($monthStart);
                $to = Carbon::parse($leave->end_date)->min($monthEnd);
                for ($day = $from->copy(); $day->lte($to); $day->addDay()) {
                    $calendarMarks[$day->day]['leave'] = true;
                }
            });
        foreach ($birthdays as $employee) {
            $calendarMarks[$employee->date_of_birth->day]['birthday'] = true;
        }

        return view('users.hr.dashboard', compact(
            'totalEmployees',
            'newHires',
            'pendingLeaves',
            'departmentDistribution',
            'recentActivities',
            'upcomingLeaves',
            'birthdays',
            'calendarMarks',
            'today'
        ));
    }
}
