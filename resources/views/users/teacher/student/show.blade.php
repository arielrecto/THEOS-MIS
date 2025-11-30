<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="_('Student Profile')" :back_url="url()->previous()" />
    <x-notification-message />

    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Student Profile Card -->
            <aside class="col-span-12 md:col-span-4">
                <div class="p-5 sm:p-6 bg-white rounded-lg shadow-md flex flex-col items-center text-center">
                    <div class="avatar">
                        <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden">
                            <img class="object-cover w-full h-full"
                                 src="{{ $student->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}"
                                 alt="{{ $student->name }}">
                        </div>
                    </div>

                    <h2 class="mt-4 text-lg sm:text-xl font-semibold truncate">{{ $student->name }}</h2>
                    <p class="mt-1 text-sm sm:text-base text-gray-500 truncate">{{ $student->email }}</p>

                    <div class="mt-4 w-full">
                        <div class="grid grid-cols-1 gap-3">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-xs text-gray-500">Tasks Completed</div>
                                <div class="mt-1 text-lg font-semibold text-accent">{{ $completedTasks }}/{{ $totalTasks }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ number_format($taskCompletionRate, 1) }}% completion</div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-xs text-gray-500">Average Grade</div>
                                <div class="mt-1 text-lg font-semibold text-accent">{{ number_format($averageGrade, 1) }}</div>
                                <div class="text-xs text-gray-400 mt-1">Across all tasks</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 w-full">
                        <a href="{{ route('teacher.student.index') }}"
                           class="btn btn-ghost btn-sm w-full sm:w-auto inline-flex items-center justify-center">
                            <i class="fi fi-rr-arrow-left mr-2"></i>
                            Back to Students
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Performance / Tasks -->
            <main class="col-span-12 md:col-span-8 space-y-6">
                <!-- Mobile: Task Cards -->
                <div class="md:hidden space-y-3">
                    <h3 class="text-base font-semibold">Recent Tasks</h3>
                    @forelse($studentTasks as $task)
                        <article class="bg-white border rounded-lg p-3 shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="font-medium text-sm truncate">{{ $task->name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Due: {{ is_numeric($task->end_date) ? date('F d, Y', $task->end_date) : \Carbon\Carbon::parse($task->end_date)->format('F d, Y') }}</div>
                                </div>

                                <div class="text-right space-y-2">
                                    <div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            {{ $task->status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </div>

                                    <div class="text-sm text-gray-700">
                                        @if($task->score)
                                            <span class="font-semibold">{{ $task->score }}</span>/<span class="text-xs text-gray-500">{{ $task->task->max_score }}</span>
                                        @else
                                            <span class="text-xs text-gray-400">--</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 flex gap-2">
                                <a href="#"
                                   class="btn btn-xs btn-accent w-full inline-flex items-center justify-center">
                                    View
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="text-center py-6 text-gray-500">No tasks found</div>
                    @endforelse
                </div>

                <!-- Desktop / Tablet: Table -->
                <div class="hidden md:block bg-white rounded-lg shadow-sm p-4">
                    <h3 class="mb-4 text-lg font-semibold">Recent Tasks</h3>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th class="text-sm">Task</th>
                                    <th class="text-sm">Due Date</th>
                                    <th class="text-sm">Status</th>
                                    <th class="text-sm">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($studentTasks as $task)
                                    <tr class="align-top">
                                        <td class="text-sm">{{ $task->name }}</td>
                                        <td class="text-sm whitespace-nowrap">{{ is_numeric($task->end_date) ? date('F d, Y', $task->end_date) : \Carbon\Carbon::parse($task->end_date)->format('F d, Y') }}</td>
                                        <td class="text-sm">
                                            <span class="badge badge-{{ $task->status === 'submitted' ? 'success' : 'warning' }}">
                                                {{ ucfirst($task->status) }}
                                            </span>
                                        </td>
                                        <td class="text-sm">
                                            @if($task->score)
                                                {{ $task->score }}/{{ $task->task->max_score }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-sm">No tasks found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Optional: Additional card for quick info on mobile -->
                <div class="md:hidden bg-white rounded-lg shadow-sm p-4">
                    <h4 class="text-sm font-semibold mb-2">Quick Info</h4>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <div class="text-xs text-gray-500">Joined</div>
                            <div class="font-medium text-gray-800">{{ $student->created_at->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">Student ID</div>
                            <div class="font-medium text-gray-800">{{ $student->id }}</div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</x-dashboard.teacher.base>
