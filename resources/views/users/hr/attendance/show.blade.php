<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header with Employee Info -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent">Dashboard</a>
                <i class="fi fi-rr-angle-right"></i>
                <a href="{{ route('hr.attendance.index') }}" class="hover:text-accent">Attendance Records</a>
                <i class="fi fi-rr-angle-right"></i>
                <span>{{ $employee->first_name }} {{ $employee->last_name }}</span>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="avatar">
                            <div class="w-16 h-16 rounded-full">
                                @if($employee->photo)
                                    <img src="{{ Storage::url($employee->photo) }}" alt="Avatar">
                                @else
                                    <div class="bg-accent/10 w-full h-full flex items-center justify-center">
                                        <i class="fi fi-rr-user text-accent text-xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </h1>
                            <p class="text-gray-600">{{ $employee->position?->name ?? 'Position Not Assigned' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="btn btn-ghost btn-sm gap-2" onclick="window.print()">
                            <i class="fi fi-rr-print"></i>
                            Print Report
                        </button>
                        <button class="btn btn-accent btn-sm gap-2">
                            <i class="fi fi-rr-download"></i>
                            Export Data
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <!-- Days Present -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-success/10 rounded-lg">
                        <i class="fi fi-rr-calendar-check text-success text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Days Present</p>
                        <p class="text-2xl font-bold">{{ $totalDays }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Hours -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary/10 rounded-lg">
                        <i class="fi fi-rr-clock text-primary text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Hours</p>
                        <p class="text-2xl font-bold">{{ $totalHours }}</p>
                    </div>
                </div>
            </div>

            <!-- Average Hours -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-accent/10 rounded-lg">
                        <i class="fi fi-rr-chart-line-up text-accent text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Average Hours/Day</p>
                        <p class="text-2xl font-bold">{{ number_format($averageHours, 1) }}</p>
                    </div>
                </div>
            </div>

            <!-- Late Count -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-error/10 rounded-lg">
                        <i class="fi fi-rr-time-past text-error text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Times Late</p>
                        <p class="text-2xl font-bold">{{ $lateCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4 border-b">
                <form class="flex flex-wrap items-end gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Date Range</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="date"
                                   name="start_date"
                                   class="input input-bordered input-sm"
                                   value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                            <span>to</span>
                            <input type="date"
                                   name="end_date"
                                   class="input input-bordered input-sm"
                                   value="{{ request('end_date', now()->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="form-control">
                        <button type="submit" class="btn btn-sm">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Total Hours</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->time_in->format('M d, Y') }}</td>
                                <td>
                                    <span class="font-medium">
                                        {{ $attendance->time_in->format('h:i A') }}
                                    </span>
                                    @if($attendance->time_in->gt($attendance->schedule_start))
                                        <span class="badge badge-error badge-sm ml-2">Late</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->time_out)
                                        {{ $attendance->time_out->format('h:i A') }}
                                    @else
                                        <span class="text-gray-400">Not logged out</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->time_out)
                                        {{ $attendance->time_out->diffInHours($attendance->time_in) }} hrs
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->status === 'present')
                                        <span class="badge badge-success">Present</span>
                                    @elseif($attendance->status === 'half_day')
                                        <span class="badge badge-warning">Half Day</span>
                                    @else
                                        <span class="badge badge-error">{{ ucfirst($attendance->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-ghost btn-sm"
                                            onclick="editAttendance({{ $attendance->id }})">
                                        <i class="fi fi-rr-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No attendance records found for the selected period
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
