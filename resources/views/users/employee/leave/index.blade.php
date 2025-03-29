@php
    use Carbon\Carbon;
@endphp

<x-dashboard.employee.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Leave Management</h1>
                <p class="text-gray-600">File and track your leave requests</p>
            </div>
            <button class="btn btn-accent gap-2" onclick="document.getElementById('file-leave-modal').showModal()">
                <i class="fi fi-rr-plus"></i>
                File Leave
            </button>
        </div>

        <!-- Leave Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-accent/10 rounded-lg">
                        <i class="fi fi-rr-calendar-check text-accent text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Available Leave Credits</p>
                        <p class="text-2xl font-bold">{{ $availableCredits }} days</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary/10 rounded-lg">
                        <i class="fi fi-rr-calendar-clock text-primary text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Pending Requests</p>
                        <p class="text-2xl font-bold">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-success/10 rounded-lg">
                        <i class="fi fi-rr-checkbox text-success text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Approved Leaves</p>
                        <p class="text-2xl font-bold">{{ $approvedCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar -->
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
                 class="min-h-[500px]">
            </div>
        </div>

        <!-- Leave History -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Leave History</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
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
                            <tr>
                                <td>{{ ucfirst($leave->leave_type) }}</td>
                                <td>
                                    {{  date('M d, Y', strtotime( $leave->start_date))}} -
                                    {{ date('M d, Y', strtotime($leave->end_type))}}
                                    <div class="text-sm text-gray-500">
                                        {{  Carbon::parse($leave->start_date)->diffInDays($leave->end_date) + 1 }} days
                                    </div>
                                </td>
                                <td>
                                    <p class="truncate max-w-xs">{{ $leave->reason }}</p>
                                </td>
                                <td>
                                    @if($leave->status === 'pending')
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
                                <td colspan="5" class="text-center py-4">
                                    No leave history found
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

    <!-- File Leave Modal -->
    <dialog id="file-leave-modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">File Leave Request</h3>
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

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Start Date</span>
                            </label>
                            <input type="date"
                                   name="start_date"
                                   class="input input-bordered"
                                   required
                                   min="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">End Date</span>
                            </label>
                            <input type="date"
                                   name="end_date"
                                   class="input input-bordered"
                                   required
                                   min="{{ now()->format('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Reason</span>
                        </label>
                        <textarea name="reason"
                                  class="textarea textarea-bordered h-24"
                                  required
                                  placeholder="Please provide your reason for leave"></textarea>
                    </div>
                </div>

                <div class="modal-action">
                    <button type="button"
                            class="btn btn-ghost"
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
