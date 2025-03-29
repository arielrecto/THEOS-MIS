<?php

namespace App\Http\Controllers\HR;

use Carbon\Carbon;
use App\Models\Leave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with(['employee.position', 'employee.user']);

        if ($request->filled('search')) {
            $query->whereHas('employee', function($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('start_date', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $leaves = $query->latest()->paginate(10);

        // Statistics
        $pendingCount = Leave::where('status', 'pending')->count();
        $approvedToday = Leave::where('status', 'approved')
            ->whereDate('updated_at', today())
            ->count();
        $onLeaveToday = Leave::where('status', 'approved')
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->count();
        $totalRequests = Leave::count();

        $calendarEvents = [];

        if ($leaves->isNotEmpty()) {
            $calendarEvents = $leaves->map(function($leave) {
                $statusColors = [
                    'pending' => '#facc15', // warning
                    'approved' => '#22c55e', // success
                    'rejected' => '#ef4444'  // error
                ];

                return [
                    'id' => $leave->id,
                    'title' => "{$leave->employee->first_name} {$leave->employee->last_name}",
                    'start' => Carbon::parse($leave->start_date)->format('Y-m-d'),
                    'end' => Carbon::parse($leave->end_date)->addDay()->format('Y-m-d'),
                    'color' => $statusColors[$leave->status],
                    'extendedProps' => [
                        'type' => ucfirst($leave->type),
                        'duration' => Carbon::parse($leave->start_date)->diffInDays($leave->end_date) + 1 . ' days',
                        'reason' => $leave->reason,
                        'status' => ucfirst($leave->status)
                    ]
                ];
            });
        }

        return view('users.hr.leave.index', compact(
            'leaves',
            'pendingCount',
            'approvedToday',
            'onLeaveToday',
            'totalRequests',
            'calendarEvents'
        ));
    }

    public function approve(Leave $Leave)
    {
        $Leave->update(['status' => 'approved']);
        return back()->with('success', 'Leave request approved successfully');
    }

    public function reject(Leave $Leave)
    {
        $Leave->update(['status' => 'rejected']);
        return back()->with('success', 'Leave request rejected successfully');
    }
}
