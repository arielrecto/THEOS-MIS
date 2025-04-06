<?php

namespace App\Http\Controllers\HR;

use Carbon\Carbon;
use App\Models\Leave;
use Illuminate\Http\Request;
use App\Actions\NotificationActions;
use App\Http\Controllers\Controller;

class LeaveController extends Controller
{
    protected $notificationActions;

    public function __construct(NotificationActions $notificationActions)
    {
        $this->notificationActions = $notificationActions;
    }

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

    public function approve(Leave $leave)
    {
        $leave->update(['status' => 'approved']);

        // Send notification to employee
        $notificationData = [
            'header' => 'Leave Request Approved',
            'message' => "Your leave request from {$leave->start_date->format('M d, Y')} to {$leave->end_date->format('M d, Y')} has been approved.",
            'type' => 'success',
            'url' => route('employee.leaves.show', $leave->id)
        ];

        $this->notificationActions->create(
            $leave->employee->user,
            $notificationData,
            $leave
        );

        return back()->with('success', 'Leave request approved successfully');
    }

    public function reject(Leave $leave)
    {
        $leave->update(['status' => 'rejected']);

        // Send notification to employee
        $notificationData = [
            'header' => 'Leave Request Rejected',
            'message' => "Your leave request from {$leave->start_date->format('M d, Y')} to {$leave->end_date->format('M d, Y')} has been rejected.",
            'type' => 'error',
            'url' => route('employee.leaves.show', $leave->id)
        ];

        $this->notificationActions->create(
            $leave->employee->user,
            $notificationData,
            $leave
        );

        return back()->with('success', 'Leave request rejected successfully');
    }
}
