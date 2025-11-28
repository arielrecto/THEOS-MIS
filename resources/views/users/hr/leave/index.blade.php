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
            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Leave Calendar</h2>
                <div class="flex flex-col lg:flex-row lg:items-center gap-4">
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

            <div x-data="leaveCalendar" x-ref="calendar" data-events='@json($calendarEvents)'
                class="hidden lg:flex min-h-[600px]">
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4 border-b">
                <form class="flex flex-col lg:flex-row lg:flex-wrap lg:items-end gap-4">
                    <div class="form-control flex-1">
                        <label class="label">
                            <span class="label-text">Search</span>
                        </label>
                        <input type="text" name="search" class="input input-bordered input-sm w-full"
                            placeholder="Search by employee name..." value="{{ request('search') }}">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Status</span>
                        </label>
                        <select name="status" class="select text-sm select-bordered select-sm w-48 max-w-full">
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
                        <div class="flex flex-col lg:flex-row lg:items-center gap-2">
                            <input type="date" name="start_date"
                                class="input input-bordered input-sm w-full lg:w-auto" +
                                value="{{ request('start_date') }}">
                            <span class="hidden lg:inline">to</span>
                            <input type="date" name="end_date" class="input input-bordered input-sm w-full lg:w-auto"
                                + value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="form-control">
                        <button type="submit" class="btn btn-sm">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Leave Requests (mobile cards + desktop table) -->
        <!-- Mobile Cards (visible on small screens) -->
        <div class="md:hidden space-y-4">
            @forelse($leaves as $request)
                <article class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                @if ($request->employee->photo)
                                    <img src="{{ Storage::url($request->employee->photo) }}" alt="Avatar"
                                        class="w-full h-full object-cover">
                                @else
                                    <i class="fi fi-rr-user text-accent text-2xl"></i>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 break-words">
                                        {{ $request->employee->first_name }} {{ $request->employee->last_name }}
                                    </p>
                                    <p class="text-xs text-gray-500 break-words">
                                        {{ $request->employee->position?->name ?? 'No Position' }}</p>
                                    <p class="text-xs text-gray-500 mt-2 break-words">
                                        {{ date('M d, Y', strtotime($request->start_date)) }} -
                                        {{ date('M d, Y', strtotime($request->end_date)) }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ Carbon::parse($request->start_date)->diffInDays($request->end_date) + 1 }}
                                        days
                                    </p>
                                </div>
                                <div class="flex-shrink-0 text-right mt-1 sm:mt-0">
                                    @if ($request->status === 'pending')
                                        <span class="badge badge-warning text-xs">Pending</span>
                                    @elseif($request->status === 'approved')
                                        <span class="badge badge-success text-xs">Approved</span>
                                    @else
                                        <span class="badge badge-error text-xs">Rejected</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3 flex items-center gap-2">
                                @if ($request->status === 'pending')
                                    <div class="flex flex-col sm:flex-row gap-2 w-full">
                                        <form action="{{ route('hr.leaves.approve', $request) }}" method="POST"
                                            class="flex-1">
                                            @method('PUT') @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-full"
                                                onclick="return confirm('Approve this leave request?')">Approve</button>
                                        </form>
                                        <form action="{{ route('hr.leaves.reject', $request) }}" method="POST"
                                            class="flex-1">
                                            @csrf @method('PUT')
                                            <button type="submit" class="btn btn-error btn-sm w-full"
                                                onclick="return confirm('Reject this leave request?')">Reject</button>
                                        </form>
                                    </div>
                                @else
                                    <button onclick="leave_details_modal_{{ $request->id }}.showModal()"
                                        class="btn btn-ghost btn-sm w-full">
                                        <i class="fi fi-rr-eye mr-2"></i> View Details
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <dialog id="leave_details_modal_{{ $request->id }}" class="modal">
                        <div class="modal-box">
                            <h3 class="font-bold text-lg mb-4">Leave Request Details</h3>
                            <div class="space-y-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Employee:</span>
                                    <div class="font-medium">
                                        {{ $request->employee->first_name . ' ' . $request->employee->last_name }}
                                    </div>
                                </div>

                                <div>
                                    <span class="text-gray-600">Duration:</span>
                                    <div>{{ date('M d, Y', strtotime($request->start_date)) }} -
                                        {{ date('M d, Y', strtotime($request->end_date)) }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ Carbon::parse($request->start_date)->diffInDays($request->end_date) + 1 }}
                                        days</div>
                                </div>

                                <div>
                                    <span class="text-gray-600">Reason:</span>
                                    <p class="mt-1 text-gray-700 whitespace-pre-wrap">{{ $request->reason }}</p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-gray-600">Status:</span>
                                    @if ($request->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($request->status === 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-error">Rejected</span>
                                    @endif
                                </div>
                            </div>

                            <div class="modal-action">
                                <form method="dialog"><button class="btn">Close</button></form>
                            </div>
                        </div>
                        <form method="dialog" class="modal-backdrop"><button>close</button></form>
                    </dialog>
                </article>
            @empty
                <div class="bg-gray-50 rounded-lg p-6 text-center">
                    <i class="fi fi-rr-users text-4xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600">No leave requests found</p>
                </div>
            @endforelse

            <!-- Mobile pagination -->
            <div class="mt-4">
                <div class="flex justify-center">
                    {{ $leaves->links() }}
                </div>
            </div>
        </div>

        <!-- Desktop / Tablet Table (visible md and up) -->
        <div class="hidden md:block bg-white rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $request)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="w-12 h-12 rounded-full overflow-hidden">
                                                @if ($request->employee->photo)
                                                    <img src="{{ Storage::url($request->employee->photo) }}"
                                                        alt="Avatar" class="object-cover w-full h-full">
                                                @else
                                                    <div
                                                        class="bg-accent/10 w-full h-full flex items-center justify-center">
                                                        <i class="fi fi-rr-user text-accent text-xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-medium text-sm">{{ $request->employee->first_name }}
                                                {{ $request->employee->last_name }}</div>
                                            <div class="text-xs opacity-50">
                                                {{ $request->employee->position?->name ?? 'No Position' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="capitalize text-sm">{{ ucfirst($request->type) }}</td>
                                <td>
                                    <div class="text-sm">{{ date('M d, Y', strtotime($request->start_date)) }} -
                                        {{ date('M d, Y', strtotime($request->end_date)) }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ Carbon::parse($request->start_date)->diffInDays($request->end_date) + 1 }}
                                        days</div>
                                </td>
                                <td class="align-top max-w-[18rem] md:max-w-none">
                                    <p class="text-sm break-words truncate md:truncate-none">{{ $request->reason }}
                                    </p>
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
                                <td class="text-right">
                                    @if ($request->status === 'pending')
                                        <div
                                            class="flex flex-col sm:flex-row items-end sm:items-center justify-end gap-2">
                                            <form action="{{ route('hr.leaves.approve', $request) }}" method="POST">
                                                @method('PUT') @csrf
                                                <button type="submit" class="btn btn-success btn-sm w-full sm:w-auto"
                                                    onclick="return confirm('Approve this leave request?')">Approve</button>
                                            </form>
                                            <form action="{{ route('hr.leaves.reject', $request) }}" method="POST">
                                                @csrf @method('PUT')
                                                <button type="submit" class="btn btn-error btn-sm w-full sm:w-auto"
                                                    onclick="return confirm('Reject this leave request?')">Reject</button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-end gap-2">
                                            <button onclick="leave_details_modal_{{ $request->id }}.showModal()"
                                                class="btn btn-ghost btn-sm gap-2">
                                                <i class="fi fi-rr-eye"></i>
                                                <span class="hidden lg:inline">View Details</span>
                                            </button>
                                        </div>

                                        <dialog id="leave_details_modal_{{ $request->id }}" class="modal">
                                            <div class="modal-box">
                                                <h3 class="font-bold text-lg mb-4">Leave Request Details</h3>
                                                <div class="space-y-4 text-sm">
                                                    <div>
                                                        <span class="text-gray-600">Employee:</span>
                                                        <div class="font-medium">
                                                            {{ $request->employee->first_name . ' ' . $request->employee->last_name }}
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <span class="text-gray-600">Duration:</span>
                                                        <div>{{ date('M d, Y', strtotime($request->start_date)) }} -
                                                            {{ date('M d, Y', strtotime($request->end_date)) }}</div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ Carbon::parse($request->start_date)->diffInDays($request->end_date) + 1 }}
                                                            days</div>
                                                    </div>

                                                    <div>
                                                        <span class="text-gray-600">Reason:</span>
                                                        <p class="mt-1 text-gray-700 whitespace-pre-wrap">
                                                            {{ $request->reason }}</p>
                                                    </div>

                                                    <div class="flex items-center gap-2">
                                                        <span class="text-gray-600">Status:</span>
                                                        @if ($request->status === 'pending')
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif($request->status === 'approved')
                                                            <span class="badge badge-success">Approved</span>
                                                        @else
                                                            <span class="badge badge-error">Rejected</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="modal-action">
                                                    <form method="dialog"><button class="btn">Close</button></form>
                                                </div>
                                            </div>
                                            <form method="dialog" class="modal-backdrop"><button>close</button></form>
                                        </dialog>
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



</x-dashboard.hr.base>
