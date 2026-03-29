<x-dashboard.teacher.base>
    <!-- Top stats: stack on mobile, 3 columns on small+ -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <x-card-v1 icon="fi fi-rr-chalkboard" label="Classrooms" :count="$totalClassrooms" icon_color="primary" />
        <x-card-v1 icon="fi fi-rr-chalkboard-user" label="Students" :count="$totalStudents" icon_color="secondary" />
        <x-card-v1 icon="fi fi-rr-books" label="Subjects" :count="$totalSubjects" icon_color="accent" />
    </div>

    <!-- Two column section: stack on mobile -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- My Classrooms Card -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl md:text-2xl font-bold text-primary flex items-center gap-2">
                    <i class="fi fi-rr-chalkboard"></i>
                    My Classrooms
                </h2>
                @if($classrooms->isNotEmpty())
                    <a href="{{ route('teacher.classrooms.index') }}" class="btn btn-xs btn-ghost">
                        View All
                    </a>
                @endif
            </div>

            @if($classrooms->isEmpty())
                <div class="text-center py-12">
                    <i class="fi fi-rr-inbox text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 mb-4">No classrooms assigned yet</p>
                    <a href="{{ route('teacher.classrooms.index') }}" class="btn btn-sm btn-primary">
                        <i class="fi fi-rr-plus"></i>
                        View Classrooms
                    </a>
                </div>
            @else
                <div class="space-y-3 max-h-72 overflow-auto">
                    @foreach($classrooms->take(5) as $classroom)
                        <a href="{{ route('teacher.classrooms.show', $classroom->id) }}"
                           class="block border border-base-300 rounded-lg p-4 hover:shadow-md hover:border-primary transition-all bg-base-50">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-base text-primary truncate">
                                        {{ $classroom->subject->name ?? 'N/A' }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $classroom->section->name ?? 'N/A' }}
                                        @if($classroom->section && $classroom->section->strand)
                                            <span class="badge badge-xs badge-ghost ml-1">
                                                {{ $classroom->section->strand->acronym }}
                                            </span>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="badge badge-accent">
                                        {{ $classroom->students_count }}
                                        {{ Str::plural('student', $classroom->students_count) }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 text-xs text-gray-500 mt-2">
                                <i class="fi fi-rr-calendar"></i>
                                <span>{{ $classroom->academicYear->name ?? 'N/A' }}</span>
                            </div>

                            <div class="flex gap-2 mt-3">
                                <span class="btn btn-xs btn-primary" onclick="event.preventDefault();">
                                    <i class="fi fi-rr-eye"></i>
                                    View Details
                                </span>
                                <a href="{{ route('teacher.classrooms.students', $classroom->id) }}"
                                   class="btn btn-xs btn-ghost"
                                   onclick="event.stopPropagation();">
                                    <i class="fi fi-rr-users"></i>
                                    Students
                                </a>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($classrooms->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('teacher.classrooms.index') }}"
                           class="btn btn-sm btn-ghost btn-block">
                            <i class="fi fi-rr-arrow-right"></i>
                            View All {{ $classrooms->count() }} Classrooms
                        </a>
                    </div>
                @endif
            @endif
        </div>

        <!-- Classroom Tasks Card -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl md:text-2xl font-bold text-primary flex items-center gap-2">
                    <i class="fi fi-rr-list-check"></i>
                    Recent Tasks
                </h2>
                @if($recentTasks->isNotEmpty())
                    <a href="{{ route('teacher.tasks.index') }}" class="btn btn-xs btn-ghost">
                        View All
                    </a>
                @endif
            </div>

            @if($recentTasks->isEmpty())
                <div class="text-center py-12">
                    <i class="fi fi-rr-document text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 mb-4">No tasks created yet</p>
                    <a href="{{ route('teacher.tasks.create') }}" class="btn btn-sm btn-primary">
                        <i class="fi fi-rr-plus"></i>
                        Create Task
                    </a>
                </div>
            @else
                <ul class="text-sm space-y-3 max-h-72 overflow-auto">
                    @foreach($recentTasks->take(6) as $task)
                        <li class="border-l-4 border-accent pl-3 py-2 hover:bg-base-200 transition-colors rounded-r">
                            <a href="{{ route('teacher.tasks.show', $task->id) }}"
                               class="block">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-base truncate">{{ $task->title }}</h4>
                                        <p class="text-xs text-gray-600 mt-1">
                                            {{ $task->classroom->subject->name ?? 'N/A' }} -
                                            {{ $task->classroom->section->name ?? 'N/A' }}
                                        </p>
                                        <div class="flex flex-wrap items-center gap-2 mt-2">
                                            <span class="badge badge-xs {{ $task->deadline < now() ? 'badge-error' : 'badge-info' }}">
                                                <i class="fi fi-rr-calendar mr-1"></i>
                                                {{ $task?->deadline?->format('M d, Y')  ?? 'No Deadline' }}
                                            </span>
                                            @if($task->deadline < now())
                                                <span class="text-xs text-error font-medium">Overdue</span>
                                            @elseif($task->deadline->isToday())
                                                <span class="text-xs text-warning font-medium">Due Today</span>
                                            @elseif($task->deadline->isTomorrow())
                                                <span class="text-xs text-info font-medium">Due Tomorrow</span>
                                            @endif
                                        </div>
                                    </div>
                                    <i class="fi fi-rr-arrow-right text-gray-400 shrink-0"></i>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>

                @if($recentTasks->count() > 6)
                    <div class="mt-4 text-center">
                        <a href="{{ route('teacher.tasks.index') }}"
                           class="btn btn-sm btn-ghost btn-block">
                            <i class="fi fi-rr-arrow-right"></i>
                            View All Tasks
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Bottom section: Upcoming Deadlines -->
    <div class="grid grid-cols-1 gap-6 mt-6">
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-xl md:text-2xl font-bold text-primary flex items-center gap-2">
                <i class="fi fi-rr-time-fast"></i>
                Upcoming Deadlines
            </h2>

            @if($upcomingDeadlines->isEmpty())
                <div class="text-center py-8">
                    <i class="fi fi-rr-calendar-check text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">No upcoming deadlines in the next 30 days</p>
                </div>
            @else
                <!-- Mobile Cards View -->
                <div class="lg:hidden space-y-3">
                    @foreach($upcomingDeadlines as $deadline)
                        <a href="{{ route('teacher.tasks.show', $deadline->id) }}"
                           class="block card bg-base-50 border border-base-300 hover:shadow-md hover:border-primary transition-all">
                            <div class="card-body p-4">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <h4 class="font-semibold text-sm flex-1">{{ $deadline->title }}</h4>
                                    @if($deadline->deadline->isToday())
                                        <span class="badge badge-warning badge-sm">Today</span>
                                    @elseif($deadline->deadline->isTomorrow())
                                        <span class="badge badge-info badge-sm">Tomorrow</span>
                                    @elseif($deadline->deadline->diffInDays() <= 3)
                                        <span class="badge badge-error badge-sm">Urgent</span>
                                    @else
                                        <span class="badge badge-success badge-sm">Scheduled</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-600">
                                    {{ $deadline->classroom->subject->name ?? 'N/A' }} -
                                    {{ $deadline->classroom->section->name ?? 'N/A' }}
                                </p>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-xs text-gray-500">
                                        <i class="fi fi-rr-calendar"></i>
                                        {{ $deadline->deadline->format('M d, Y') }}
                                    </span>
                                    <span class="text-xs text-accent">
                                        {{ $deadline->deadline->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Classroom</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingDeadlines as $deadline)
                                <tr class="hover:bg-base-200">
                                    <td>
                                        <div class="font-semibold">{{ $deadline->title }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">
                                            {{ Str::limit($deadline->description, 50) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm">{{ $deadline->classroom->subject->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $deadline->classroom->section->name ?? 'N/A' }}</div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <i class="fi fi-rr-calendar text-accent"></i>
                                            <div>
                                                <div class="text-sm">{{ $deadline->deadline->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ $deadline->deadline->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($deadline->deadline->isToday())
                                            <span class="badge badge-warning badge-sm">Due Today</span>
                                        @elseif($deadline->deadline->isTomorrow())
                                            <span class="badge badge-info badge-sm">Tomorrow</span>
                                        @elseif($deadline->deadline->diffInDays() <= 3)
                                            <span class="badge badge-error badge-sm">Urgent</span>
                                        @else
                                            <span class="badge badge-success badge-sm">Scheduled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('teacher.tasks.show', $deadline->id) }}"
                                           class="btn btn-xs btn-ghost">
                                            <i class="fi fi-rr-eye"></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
        <a href="{{ route('teacher.classrooms.index') }}"
           class="btn btn-outline btn-primary gap-2 flex-col h-auto py-4">
            <i class="fi fi-rr-chalkboard text-2xl"></i>
            <span class="text-xs sm:text-sm">View Classrooms</span>
        </a>
        <a href="{{ route('teacher.tasks.index') }}"
           class="btn btn-outline btn-secondary gap-2 flex-col h-auto py-4">
            <i class="fi fi-rr-list-check text-2xl"></i>
            <span class="text-xs sm:text-sm">Manage Tasks</span>
        </a>
        <a href="{{ route('teacher.student.index') }}"
           class="btn btn-outline btn-accent gap-2 flex-col h-auto py-4">
            <i class="fi fi-rr-users text-2xl"></i>
            <span class="text-xs sm:text-sm">View Students</span>
        </a>
        <a href="{{ route('teacher.grades.index') }}"
           class="btn btn-outline btn-info gap-2 flex-col h-auto py-4">
            <i class="fi fi-rr-diploma text-2xl"></i>
            <span class="text-xs sm:text-sm">Manage Grades</span>
        </a>
    </div>
</x-dashboard.teacher.base>
