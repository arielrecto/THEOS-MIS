@php
    use Carbon\Carbon;
@endphp

<x-dashboard.employee.base>
    <x-notification-message />
    <div class="container max-w-7xl p-4 sm:p-6 mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div class="min-w-0">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 truncate">Leave Management</h1>
                <p class="text-sm sm:text-base text-gray-600">File and track your leave requests</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="gap-2 btn btn-accent" onclick="document.getElementById('file-leave-modal').showModal()">
                    <i class="fi fi-rr-plus"></i>
                    <span class="hidden sm:inline">File Leave</span>
                    <span class="sm:hidden">File</span>
                </button>
            </div>
        </div>

        <!-- Leave Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <div class="flex gap-4 items-center">
                    <div class="p-2 sm:p-3 rounded-lg bg-accent/10">
                        <i class="text-lg sm:text-xl fi fi-rr-calendar-check text-accent"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm text-gray-600">Available Leave Credits</p>
                        <p class="text-xl sm:text-2xl font-bold">{{ $availableCredits }} days</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <div class="flex gap-4 items-center">
                    <div class="p-2 sm:p-3 rounded-lg bg-primary/10">
                        <i class="text-lg sm:text-xl fi fi-rr-calendar-clock text-primary"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm text-gray-600">Pending Requests</p>
                        <p class="text-xl sm:text-2xl font-bold">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <div class="flex gap-4 items-center">
                    <div class="p-2 sm:p-3 rounded-lg bg-success/10">
                        <i class="text-lg sm:text-xl fi fi-rr-checkbox text-success"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm text-gray-600">Approved Leaves</p>
                        <p class="text-xl sm:text-2xl font-bold">{{ $approvedCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="p-4 sm:p-6 mb-6 bg-white rounded-lg shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-4">
                <h2 class="text-lg sm:text-xl font-semibold">Leave Calendar</h2>
                <div class="flex flex-col md:flex-row gap-4 md:items-center text-sm">
                    <div class="flex gap-2 items-center">
                        <span class="w-3 h-3 rounded-full bg-warning"></span>
                        <span>Pending</span>
                    </div>
                    <div class="flex gap-2 items-center">
                        <span class="w-3 h-3 rounded-full bg-success"></span>
                        <span>Approved</span>
                    </div>
                    <div class="flex gap-2 items-center">
                        <span class="w-3 h-3 rounded-full bg-error"></span>
                        <span>Rejected</span>
                    </div>
                </div>
            </div>

            <div x-data="leaveCalendar" x-ref="calendar" data-events='@json($calendarEvents)'
                class="min-h-[300px] sm:min-h-[420px] md:min-h-[500px] hidden md:flex">
            </div>
        </div>

        <!-- Leave History -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Leave History</h2>
            </div>

            <!-- Desktop Table -->
            <div class="overflow-x-auto hidden md:block">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Filed On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                            <tr class="align-top">
                                <td class="capitalize">{{ ucfirst($leave->leave_type) }}</td>
                                <td>
                                    {{ date('M d, Y', strtotime($leave->start_date)) }} -
                                    {{ date('M d, Y', strtotime($leave->end_date)) }}
                                    <div class="text-sm text-gray-500">
                                        {{ Carbon::parse($leave->start_date)->diffInDays($leave->end_date) + 1 }} days
                                    </div>
                                </td>
                                <td>
                                    <p class="max-w-xs truncate">{{ $leave->reason }}</p>
                                </td>
                                <td>
                                    @if ($leave->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($leave->status === 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-error">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $leave->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center">No leave history found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-3 p-4">
                @forelse($leaves as $leave)
                    <div class="flex flex-col sm:flex-row sm:items-center bg-base-100 p-3 rounded-lg shadow-sm">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="font-medium truncate capitalize">{{ ucfirst($leave->leave_type) }}</div>
                                    <div class="text-xs text-gray-500 truncate">
                                        {{ date('M d, Y', strtotime($leave->start_date)) }} -
                                        {{ date('M d, Y', strtotime($leave->end_date)) }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-semibold">
                                        {{ Carbon::parse($leave->start_date)->diffInDays($leave->end_date) + 1 }}d
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2 text-sm text-gray-700">
                                <p class="truncate">{{ $leave->reason }}</p>
                            </div>
                        </div>

                        <div class="mt-3 sm:mt-0 sm:ml-4 flex flex-col items-end gap-2">
                            @if ($leave->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($leave->status === 'approved')
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-error">Rejected</span>
                            @endif

                            <div class="text-xs text-gray-500 mt-1">{{ $leave->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">No leave history found</div>
                @endforelse
            </div>

            <div class="p-4 border-t">
                {{ $leaves->links() }}
            </div>
        </div>
    </div>

    <!-- File Leave Modal -->
    <dialog id="file-leave-modal" class="modal">
        <div class="modal-box max-w-full sm:max-w-lg">
            <h3 class="mb-4 text-lg font-bold">File Leave Request</h3>
            <form action="{{ route('employee.leaves.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Leave Type</span>
                        </label>
                        <select name="type" class="select select-bordered" required>
                            <option value="">Select Type</option>
                            <option value="vacation">Vacation Leave</option>
                            <option value="sick">Sick Leave</option>
                            <option value="emergency">Emergency Leave</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Start Date</span>
                            </label>
                            <input type="date" name="start_date" class="input input-bordered" required
                                min="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">End Date</span>
                            </label>
                            <input type="date" name="end_date" class="input input-bordered" required
                                min="{{ now()->format('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Reason</span>
                        </label>
                        <textarea name="reason" class="h-24 textarea textarea-bordered" required
                            placeholder="Please provide your reason for leave"></textarea>
                    </div>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn btn-ghost"
                        onclick="document.getElementById('file-leave-modal').close()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-accent">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</x-dashboard.employee.base>
