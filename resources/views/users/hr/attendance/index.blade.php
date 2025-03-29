<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Attendance Records</h1>
                    <p class="text-gray-600">Monitor employee attendance and time logs</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-ghost btn-sm gap-2" onclick="window.print()">
                        <i class="fi fi-rr-print"></i>
                        Print Report
                    </button>
                    <a href="#" class="btn btn-accent btn-sm gap-2">
                        <i class="fi fi-rr-download"></i>
                        Export
                    </a>
                </div>
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
                            placeholder="Search employees..." value="{{ request('search') }}">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Department</span>
                        </label>
                        <select name="department" class="select text-sm select-bordered select-sm">
                            <option value="">All Departments</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ request('department') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
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

        <!-- Attendance Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th class="text-center">Total Days Present</th>
                            <th class="text-center">Total Hours</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="w-12 h-12 rounded-full">
                                                @if ($employee->photo)
                                                    <img src="{{ Storage::url($employee->photo) }}" alt="Avatar">
                                                @else
                                                    <div
                                                        class="bg-accent/10 w-full h-full flex items-center justify-center">
                                                        <i class="fi fi-rr-user text-accent text-xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">{{ $employee->first_name }}
                                                {{ $employee->last_name }}</div>
                                            <div class="text-sm opacity-50">{{ $employee->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $employee->position?->department?->name ?? 'Not Assigned' }}</td>
                                <td>{{ $employee->position?->name ?? 'Not Assigned' }}</td>
                                <td class="text-center">
                                    <span class="font-semibold">{{ $employee->attendanceLogs->count() }}</span>
                                    <span class="text-sm text-gray-500">days</span>
                                </td>
                                <td class="text-center">
                                    <span class="font-semibold">
                                        {{ $employee->attendanceLogs->sum(function ($log) {
                                            return $log->time_out ? $log->time_out->diffInHours($log->time_in) : 0;
                                        }) }}
                                    </span>
                                    <span class="text-sm text-gray-500">hrs</span>
                                </td>
                                <td>
                                    <a href="{{ route('hr.attendance.show', ['employee' => $employee]) }}"
                                        class="btn btn-ghost btn-sm">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No attendance records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
