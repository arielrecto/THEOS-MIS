<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="_('Student Profile')" :back_url="url()->previous()" />
    <x-notification-message />

    <div class="grid grid-cols-12 gap-6">
        <!-- Student Profile Card -->
        <div class="col-span-12 md:col-span-4">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <div class="flex flex-col items-center">
                    <div class="avatar">
                        <div class="w-32 h-32 rounded-full">
                            <img src="{{ $student->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}"
                                 alt="Profile Photo">
                        </div>
                    </div>
                    <h2 class="mt-4 text-xl font-bold">{{ $student->name }}</h2>
                    <p class="text-gray-500">{{ $student->email }}</p>
                    <div class="mt-4 w-full">
                        <div class="w-full stats stats-vertical">
                            {{-- <div class="stat">
                                <div class="stat-title">Attendance Rate</div>
                                <div class="stat-value text-accent">{{ number_format($attendanceRate, 1) }}%</div>
                                <div class="stat-desc">Last 30 days</div>
                            </div> --}}
                            <div class="stat">
                                <div class="stat-title">Tasks Completed</div>
                                <div class="stat-value text-accent">{{ $completedTasks }}/{{ $totalTasks }}</div>
                                <div class="stat-desc">{{ number_format($taskCompletionRate, 1) }}% completion rate</div>
                            </div>
                            <div class="stat">
                                <div class="stat-title">Average Grade</div>
                                <div class="stat-value text-accent">{{ number_format($averageGrade, 1) }}</div>
                                <div class="stat-desc">Across all tasks</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="col-span-12 md:col-span-8">
            <div class="grid gap-6">
                <!-- Tasks Overview -->
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h3 class="mb-4 text-lg font-bold">Recent Tasks</h3>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($studentTasks as $task)
                                    <tr>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ date('F d Y', $task->end_date)}}</td>
                                        <td>
                                            <span class="badge badge-{{ $task->status === 'submitted' ? 'success' : 'warning' }}">
                                                {{ ucfirst($task->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($task->score)
                                                {{ $task->score }}/{{ $task->task->max_score }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center">No tasks found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Attendance Log -->
                {{-- <div class="p-6 bg-white rounded-lg shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Attendance History</h3>
                        <div class="flex gap-2">
                            <span class="badge badge-success">Present: {{ $presentCount }}</span>
                            <span class="badge badge-error">Absent: {{ $absentCount }}</span>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time In</th>
                                    <th>Status</th>
                                    <th>Subject</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student_attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->created_at->format('M d, Y') }}</td>
                                        <td>{{ $attendance->created_at->format('h:i A') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $attendance->status === 'present' ? 'success' : 'error' }}">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $attendance->attendance->classroom->subject->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center">No attendance records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</x-dashboard.teacher.base>
