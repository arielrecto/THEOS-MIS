<x-dashboard.employee.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">My Attendance</h1>
                    <p class="text-gray-600">Track your daily attendance records</p>
                </div>
                <div>
                    <button class="btn btn-ghost btn-sm gap-2" onclick="window.print()">
                        <i class="fi fi-rr-print"></i>
                        Print Records
                    </button>
                </div>
            </div>
        </div>

        <!-- Today's Attendance -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Today's Attendance</h2>
                    <p class="text-sm text-gray-600">{{ now()->format('l, F d, Y') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    @php
                        $todayLog = $attendances->first(function($attendance) {
                            return $attendance->time_in->isToday();
                        });
                    @endphp

                    @if(!$todayLog)
                        <form action="{{ route('employee.attendance.check-in') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-accent gap-2">
                                <i class="fi fi-rr-sign-in-alt"></i>
                                Check In
                            </button>
                        </form>
                    @elseif(!$todayLog->time_out)
                        <div x-data="attendanceTimer"
                             x-init="initCheckInTime(`{{ $todayLog->time_in}}`)"
                             class="flex items-center gap-6">
                            <div class="text-2xl font-mono">
                                <span x-text="hours">00</span>:<span x-text="minutes">00</span>:<span x-text="seconds">00</span>
                            </div>
                            <form action="{{ route('employee.attendance.check-out') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="btn btn-primary gap-2"
                                        x-on:click="stopTimer">
                                    <i class="fi fi-rr-sign-out-alt"></i>
                                    Check Out
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-sm text-gray-600">
                            Checked out at {{ $todayLog->time_out->format('h:i A') }}
                            <span class="font-medium ml-2">
                                ({{ $todayLog->time_out->diffForHumans($todayLog->time_in, ['parts' => 2]) }})
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            @if($todayLog)
                <div class="mt-4 flex items-center gap-6">
                    <div>
                        <span class="text-sm text-gray-600">Checked in at:</span>
                        <span class="font-medium">{{ $todayLog->time_in->format('h:i A') }}</span>
                        @if($todayLog->status === 'late')
                            <span class="badge badge-error badge-sm ml-2">Late</span>
                        @endif
                    </div>
                    @if($todayLog->time_out)
                        <div>
                            <span class="text-sm text-gray-600">Total hours:</span>
                            <span class="font-medium">
                                {{ $todayLog->time_out->diffInHours($todayLog->time_in) }} hrs
                            </span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Days Present -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-success/10 rounded-lg">
                        <i class="fi fi-rr-calendar-check text-success text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Days Present</p>
                        <p class="text-2xl font-bold">{{ $attendances->count() }}</p>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No attendance records found for the selected period
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</x-dashboard.employee.base>
