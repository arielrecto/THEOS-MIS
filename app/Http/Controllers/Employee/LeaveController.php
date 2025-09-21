<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = auth()->user()->employee->leaves()
            ->latest()
            ->paginate(10);

        $pendingCount = $leaves->where('status', 'pending')->count();
        $approvedCount = $leaves->where('status', 'approved')->count();
        $availableCredits = auth()->user()->employee->leave_credit; // You should calculate this based on your leave policy

        $calendarEvents = $leaves->map(function($leave) {
            $statusColors = [
                'pending' => '#facc15',
                'approved' => '#22c55e',
                'rejected' => '#ef4444'
            ];

            return [
                'id' => $leave->id,
                'title' => ucfirst($leave->type) . ' Leave',
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

        return view('users.employee.leave.index', compact(
            'leaves',
            'pendingCount',
            'approvedCount',
            'availableCredits',
            'calendarEvents'
        ));
    }

    public function create()
    {
        return view('users.employee.leave.create');
    }

    public function store(Request $request)
    {


        $validated = $request->validate([
            'type' => 'required|in:vacation,sick,emergency',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required'
        ]);


        $totalDays = Carbon::parse($request->start_date)->diffInDays($request->end_date) + 1;


        if($totalDays > auth()->user()->employee->leave_credit) {
            return redirect()
                ->back()
                ->with('error', 'You do not have enough leave credits');
        }

        $leave = auth()->user()->employee->leaves()->create([
            'leave_type' => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'],
            'days' =>  $totalDays,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('employee.leaves.index')
            ->with('success', 'Leave request submitted successfully');
    }
}
