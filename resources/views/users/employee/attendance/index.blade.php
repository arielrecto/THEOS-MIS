<x-dashboard.employee.base>
    <div class="container p-6 mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">My Attendance</h1>
                    <p class="text-gray-600">Track your daily attendance records</p>
                </div>
                <div>
                    <button class="gap-2 btn btn-ghost btn-sm"
                        onclick="document.getElementById('my_modal_1').showModal()">
                        <i class="fi fi-rr-print"></i>
                        Print Records
                    </button>


                    <dialog id="my_modal_1" class="modal">
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Select Date Range </h3>
                            <form action="{{ route('employee.attendance.print') }}" method="GET">
                                @csrf
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Start Date</span>
                                    </label>
                                    <input type="date" name="start_date" class="input input-bordered"
                                        value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">End Date</span>
                                    </label>
                                    <input type="date" name="end_date" class="input input-bordered"
                                        value="{{ request('end_date', now()->format('Y-m-d')) }}">
                                </div>
                                <div class="modal-action">
                                    <button type="submit" class="btn btn-primary">Print</button>
                                    <button type="button" class="btn btn-ghost"
                                        onclick="document.getElementById('my_modal_1').close()">Close</button>
                                </div>
                            </form>
                        </div>

                    </dialog>
                </div>
            </div>
        </div>

        <!-- Today's Attendance -->
        <div class="p-6 mb-6 bg-white rounded-lg shadow-sm">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold">Today's Attendance</h2>
                    <p class="text-sm text-gray-600">{{ now()->format('l, F d, Y') }}</p>
                </div>
                <div class="flex gap-3 items-center">
                    @php
                        $todayLog = $attendances->first(function ($attendance) {
                            return $attendance->time_in->isToday();
                        });
                    @endphp

                    @if (!$todayLog)
                        <form action="{{ route('employee.attendance.check-in') }}" method="POST">
                            @csrf
                            <button type="submit" class="gap-2 btn btn-accent">
                                <i class="fi fi-rr-sign-in-alt"></i>
                                Check In
                            </button>
                        </form>
                    @elseif(!$todayLog->time_out)
                        <div x-data="attendanceTimer" x-init="initCheckInTime(`{{ $todayLog->time_in }}`)" class="flex gap-6 items-center">
                            <div class="font-mono text-2xl">
                                <span x-text="hours">00</span>:<span x-text="minutes">00</span>:<span
                                    x-text="seconds">00</span>
                            </div>
                            <form action="{{ route('employee.attendance.check-out') }}" method="POST">
                                @csrf
                                <button type="submit" class="gap-2 btn btn-primary" x-on:click="stopTimer">
                                    <i class="fi fi-rr-sign-out-alt"></i>
                                    Check Out
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-sm text-gray-600">
                            Checked out at {{ $todayLog->time_out->format('h:i A') }}
                            <span class="ml-2 font-medium">
                                ({{ $todayLog->time_out->diffForHumans($todayLog->time_in, ['parts' => 2]) }})
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            @if ($todayLog)
                <div class="flex gap-6 items-center mt-4">
                    <div>
                        <span class="text-sm text-gray-600">Checked in at:</span>
                        <span class="font-medium">{{ $todayLog->time_in->format('h:i A') }}</span>
                        @if ($todayLog->status === 'late')
                            <span class="ml-2 badge badge-error badge-sm">Late</span>
                        @endif
                    </div>
                    @if ($todayLog->time_out)
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
        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
            <!-- Days Present -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex gap-4 items-center">
                    <div class="p-3 rounded-lg bg-success/10">
                        <i class="text-xl fi fi-rr-calendar-check text-success"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Days Present</p>
                        <p class="text-2xl font-bold">{{ $attendances->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Hours -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex gap-4 items-center">
                    <div class="p-3 rounded-lg bg-primary/10">
                        <i class="text-xl fi fi-rr-clock text-primary"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Hours</p>
                        <p class="text-2xl font-bold">{{ $totalHours }}</p>
                    </div>
                </div>
            </div>

            <!-- Average Hours -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex gap-4 items-center">
                    <div class="p-3 rounded-lg bg-accent/10">
                        <i class="text-xl fi fi-rr-chart-line-up text-accent"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Average Hours/Day</p>
                        <p class="text-2xl font-bold">{{ number_format($averageHours, 1) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b">
                <form class="flex flex-wrap gap-4 items-end">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Date Range</span>
                        </label>
                        <div class="flex gap-2 items-center">
                            <input type="date" name="start_date" class="input input-bordered input-sm"
                                value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                            <span>to</span>
                            <input type="date" name="end_date" class="input input-bordered input-sm"
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
                                    @if ($attendance->time_in->gt($attendance->schedule_start))
                                        <span class="ml-2 badge badge-error badge-sm">Late</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($attendance->time_out)
                                        {{ $attendance->time_out->format('h:i A') }}
                                    @else
                                        <span class="text-gray-400">Not logged out</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($attendance->time_out)
                                        {{ $attendance->time_out->diffInHours($attendance->time_in) }} hrs
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>
                                    @if ($attendance->status === 'present')
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
                                <td colspan="5" class="py-4 text-center">
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
