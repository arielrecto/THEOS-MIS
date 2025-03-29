<?php

namespace App\Http\Controllers\HR;

use PDF;
use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Department;
use App\Models\JobPosition;
use App\Models\JobApplicant;
use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Models\EmployeeProfile;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        return view('users.hr.report.index');
    }

    public function attendance(Request $request)
    {
        $query = AttendanceLog::with(['employee.position'])
        ->when($request->filled(['start_date', 'end_date']), function($q) use ($request) {
                $q->whereBetween('time_in', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            });

        $records = $query->latest('time_in')->paginate(10);


        $employees = EmployeeProfile::orderBy('first_name')->get();

        // Calculate statistics
        $totalRecords = $query->count();
        $lateCount = $query->where('status', 'late')->count();

        $stats = [
            'total_present' => $totalRecords,
            'late_count' => $lateCount,
            'avg_hours' => $records->avg(function($record) {
                return $record->time_out ? $record->time_out->diffInHours($record->time_in) : 0;
            }),
            'ontime_percentage' => $totalRecords > 0
                ? (($totalRecords - $lateCount) / $totalRecords) * 100
                : 0
        ];

        return view('users.hr.report.attendance', compact('records', 'employees', 'stats'));
    }

    public function leave(Request $request)
    {
        $query = Leave::with(['employee.position'])
            ->when($request->filled('employee_id'), function($q) use ($request) {
                $q->where('employee_profile_id', $request->employee_id);
            })
            ->when($request->filled('status'), function($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled(['start_date', 'end_date']), function($q) use ($request) {
                $q->whereBetween('start_date', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            });

        $records = $query->latest()->paginate(10);
        $employees = EmployeeProfile::orderBy('first_name')->get();

        // Calculate statistics
        $stats = [
            'total_requests' => $query->count(),
            'pending_requests' => $query->where('status', 'pending')->count(),
            'approved_requests' => $query->where('status', 'approved')->count(),
            'rejected_requests' => $query->where('status', 'rejected')->count(),
        ];

        return view('users.hr.report.leave', compact('records', 'employees', 'stats'));
    }

    public function recruitment(Request $request)
    {
        $query = JobPosition::with(['department', 'applicants'])
            ->when($request->filled('department_id'), function($q) use ($request) {
                $q->where('department_id', $request->department_id);
            })
            ->when($request->filled('status'), function($q) use ($request) {
                $q->where('is_hiring', $request->status === 'open');
            })
            ->when($request->filled(['start_date', 'end_date']), function($q) use ($request) {
                $q->whereHas('applicants', function($query) use ($request) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($request->start_date)->startOfDay(),
                        Carbon::parse($request->end_date)->endOfDay()
                    ]);
                });
            });

        $records = $query->get()->map(function($position) {
            return [
                'id' => $position->id,
                'position' => $position->name,
                'department' => $position->department->name,
                'total_applications' => $position->applicants->count(),
                'shortlisted_count' => $position->applicants->where('status', 'shortlisted')->count(),
                'interviewed_count' => $position->applicants->where('status', 'interviewed')->count(),
                'hired_count' => $position->applicants->where('status', 'hired')->count(),
                'rejected_count' => $position->applicants->where('status', 'rejected')->count(),
                'status' => $position->is_hiring ? 'open' : 'closed',
            ];
        });

        $departments = Department::orderBy('name')->get();

        // Overall statistics
        $allApplicants = JobApplicant::when($request->filled(['start_date', 'end_date']), function($q) use ($request) {
            $q->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        });

        $stats = [
            'total_positions' => $records->count(),
            'open_positions' => $records->where('status', 'open')->count(),
            'total_applications' => $allApplicants->count(),
            'pending_applications' => $allApplicants->where('status', 'pending')->count(),
            'shortlisted' => $allApplicants->where('status', 'shortlisted')->count(),
            'interviewed' => $allApplicants->where('status', 'interviewed')->count(),
            'hired' => $allApplicants->where('status', 'hired')->count(),
            'rejected' => $allApplicants->where('status', 'rejected')->count(),
        ];

        return view('users.hr.report.recruitment', compact('records', 'departments', 'stats'));
    }

}
