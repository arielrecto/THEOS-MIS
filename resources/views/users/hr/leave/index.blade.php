@php
    use Carbon\Carbon;
@endphp

<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Leave Management</h1>
                    <p class="text-gray-600">Manage and monitor employee leave requests</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <!-- Pending Requests -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-warning/10 rounded-lg">
                        <i class="fi fi-rr-hourglass-end text-warning text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Pending Requests</p>
                        <p class="text-2xl font-bold">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Approved Today -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-success/10 rounded-lg">
                        <i class="fi fi-rr-checkbox text-success text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Approved Today</p>
                        <p class="text-2xl font-bold">{{ $approvedToday }}</p>
                    </div>
                </div>
            </div>

            <!-- On Leave Today -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary/10 rounded-lg">
                        <i class="fi fi-rr-users-alt text-primary text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">On Leave Today</p>
                        <p class="text-2xl font-bold">{{ $onLeaveToday }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Requests -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-accent/10 rounded-lg">
                        <i class="fi fi-rr-document text-accent text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Requests</p>
                        <p class="text-2xl font-bold">{{ $totalRequests }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Leave Calendar</h2>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-warning"></span>
                        <span class="text-sm">Pending</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-success"></span>
                        <span class="text-sm">Approved</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-error"></span>
                        <span class="text-sm">Rejected</span>
                    </div>
                </div>
            </div>

            <div x-data="leaveCalendar"
                 x-ref="calendar"
                 data-events='@json($calendarEvents)'
                 class="min-h-[600px]">
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4 border-b">
                <form class="flex flex-wrap items-end gap-4">
                    <div class="form-control flex-1">
                        <label class="label">
                            <span class="label-text">Search</span>
                        </label>
                        <input type="text" name="search" class="input input-bordered input-sm"
                            placeholder="Search by employee name..." value="{{ request('search') }}">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Status</span>
                        </label>
                        <select name="status" class="select text-sm select-bordered select-sm">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Date Range</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="date" name="start_date" class="input input-bordered input-sm"
                                value="{{ request('start_date') }}">
                            <span>to</span>
                            <input type="date" name="end_date" class="input input-bordered input-sm"
                                value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="form-control">
                        <button type="submit" class="btn btn-sm">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Leave Requests Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $request)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="w-12 h-12 rounded-full">
                                                @if ($request->employee->photo)
                                                    <img src="{{ Storage::url($request->employee->photo) }}"
                                                        alt="Avatar">
                                                @else
                                                    <div
                                                        class="bg-accent/10 w-full h-full flex items-center justify-center">
                                                        <i class="fi fi-rr-user text-accent text-xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">
                                                {{ $request->employee->first_name }}
                                                {{ $request->employee->last_name }}
                                            </div>
                                            <div class="text-sm opacity-50">
                                                {{ $request->employee->position?->name ?? 'No Position' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ ucfirst($request->type) }}</td>
                                <td>
                                    {{ date('M d, Y', strtotime(' $request->start_date'))  }} -
                                    {{ date('M d, Y', strtotime($request->end_date)) }}
                                    <div class="text-sm text-gray-500">
                                        {{ Carbon::parse($request->start_date)->diffInDays($request->end_date) + 1 }} days
                                    </div>
                                </td>
                                <td>
                                    <p class="truncate max-w-xs">{{ $request->reason }}</p>
                                </td>
                                <td>
                                    @if ($request->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($request->status === 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-error">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($request->status === 'pending')
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('hr.leaves.approve', $request) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Approve this leave request?')">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('hr.leaves.reject', $request) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-error btn-sm"
                                                    onclick="return confirm('Reject this leave request?')">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <a href="{{ route('hr.leave.show', $request) }}" class="btn btn-ghost btn-sm">
                                            View Details
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No leave requests found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t">
                {{ $leaves->links() }}
            </div>
        </div>
    </div>

    <!-- Leave Details Modal -->
    <dialog id="leave-details-modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Leave Request Details</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-600">Employee:</span>
                    <span class="font-medium employee-name"></span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Leave Type:</span>
                    <span class="font-medium leave-type"></span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Duration:</span>
                    <span class="font-medium leave-duration"></span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Reason:</span>
                    <p class="mt-1 leave-reason"></p>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Status:</span>
                    <span class="leave-status"></span>
                </div>
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>
</x-dashboard.hr.base>
