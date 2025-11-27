<x-dashboard.student.base>
    <div class="container max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="mb-4 text-2xl font-bold text-gray-700">Student Dashboard</h1>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

            <!-- Enrollment Status -->
            <div class="p-4 bg-white rounded-lg shadow-md">
                <h2 class="text-lg font-bold text-gray-700">Enrollment Status</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Status: <span class="font-semibold text-green-600">Approved</span>
                </p>
            </div>

            <!-- Tasks -->
            <div class="p-4 bg-white rounded-lg shadow-md md:col-span-2 flex flex-col">
                <div class="flex items-center justify-between mb-4 gap-3">
                    <h2 class="text-lg font-bold text-gray-700">Upcoming Tasks</h2>
                    <a href="{{ route('student.tasks.index') }}"
                       class="text-sm text-accent hover:underline hidden sm:inline">
                        View All
                    </a>
                    <!-- mobile view link -->
                    <a href="{{ route('student.tasks.index') }}"
                       class="text-sm text-accent hover:underline sm:hidden">
                        View
                    </a>
                </div>

                <div class="flex-1 overflow-hidden">
                    <div class="space-y-3 max-h-72 md:max-h-none overflow-auto pr-2">
                        @forelse($tasks as $studentTask)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-start justify-between">
                                    <div class="min-w-0">
                                        <h3 class="font-medium text-gray-800 truncate">
                                            {{ $studentTask->task->title }}
                                        </h3>
                                        <div class="mt-1 space-y-1">
                                            <p class="text-sm text-gray-600 line-clamp-3">
                                                {{ Str::limit($studentTask->task->description, 100) }}
                                            </p>
                                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                                <span class="flex items-center gap-1">
                                                    <i class="fi fi-rr-book-alt"></i>
                                                    <span class="truncate">{{ $studentTask->task->classroom->subject->name }}</span>
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fi fi-rr-calendar"></i>
                                                    <span>Due: {{ Carbon\Carbon::parse($studentTask->task->due_date)->format('M d, Y') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0 ml-3 flex flex-col items-end gap-2">
                                        <span class="badge {{ $studentTask->status === 'completed' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($studentTask->status) }}
                                        </span>

                                        <a href="{{ route('student.tasks.show', $studentTask->task) }}"
                                           class="text-xs text-accent hover:underline">
                                            View Details
                                        </a>
                                    </div>
                                </div>

                                @if($studentTask->task->attachments_count > 0)
                                    <div class="mt-2 text-xs text-gray-500 flex items-center gap-2">
                                        <i class="fi fi-rr-clip"></i>
                                        <span>{{ $studentTask->task->attachments_count }} attachment(s)</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="p-4 text-sm text-center text-gray-500 bg-gray-50 rounded-lg">
                                <i class="text-xl fi fi-rr-info"></i>
                                <p class="mt-1">No upcoming tasks at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <a href="{{ route('student.tasks.index') }}" class="btn btn-sm w-full sm:w-auto">
                        View All Tasks
                    </a>
                </div>
            </div>

            <!-- Announcements -->
            <div class="p-4 bg-white rounded-lg shadow-md md:col-span-3">
                <div class="flex items-center justify-between mb-4 gap-3">
                    <h2 class="text-lg font-bold text-gray-700">Latest Announcements</h2>
                    <a href="{{ route('student.announcements.index') }}" class="text-sm text-accent hover:underline">
                        View All
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($announcements as $announcement)
                        <article class="mb-4 overflow-hidden bg-gray-50 rounded-lg">
                            <div class="p-4">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-800 truncate">
                                            {{ $announcement->title }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600 line-clamp-3">
                                            {!! Str::limit(strip_tags($announcement->content), 150) !!}
                                        </p>
                                    </div>

                                    @if($announcement->is_important)
                                        <span class="mt-2 sm:mt-0 px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                            Important
                                        </span>
                                    @endif
                                </div>

                                <div class="flex flex-wrap items-center gap-3 mt-3 text-sm text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <i class="fi fi-rr-user"></i>
                                        <span class="truncate">{{ $announcement->postedBy->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fi fi-rr-calendar"></i>
                                        <span>{{ $announcement->created_at->format('M d, Y') }}</span>
                                    </div>

                                    @if($announcement->attachments_count > 0)
                                        <div class="flex items-center gap-2">
                                            <i class="fi fi-rr-clip"></i>
                                            <span class="text-xs">{{ $announcement->attachments_count }} attachment(s)</span>
                                        </div>
                                    @endif

                                    <div class="ml-auto">
                                        <a href="{{ route('student.announcements.show', $announcement) }}"
                                           class="text-sm text-accent hover:underline">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="p-4 text-sm text-center text-gray-500 bg-gray-50 rounded-lg">
                            <i class="text-xl fi fi-rr-info"></i>
                            <p class="mt-1">No announcements available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Profile Information -->
            <div class="p-4 bg-white rounded-lg shadow-md">
                <h2 class="text-lg font-bold text-gray-700">Student Profile</h2>
                <p class="mt-2 text-sm text-gray-600">
                    <strong>Name:</strong> {{ $student->name }}<br>
                    <strong>Student ID:</strong> {{ $student->studentProfile->lrn ?? 'Not Enrolled' }}<br>
                    <strong>Grade Level:</strong>
                    {{ $student->studentProfile?->academicRecords()?->latest()->first()?->grade_level }}
                </p>
            </div>

            <!-- Account Settings -->
            <div class="p-4 bg-white rounded-lg shadow-md">
                <h2 class="text-lg font-bold text-gray-700">Account Settings</h2>
                <p class="mt-2 text-sm text-gray-600">
                    <a href="{{ route('student.settings.index') }}" class="text-blue-600 hover:underline block sm:inline">Edit Profile</a>
                </p>
            </div>

        </div>
    </div>
</x-dashboard.student.base>
