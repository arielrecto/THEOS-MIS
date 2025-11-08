<x-dashboard.student.base>
    <div class="container p-6 mx-auto">
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
            <div class="p-4 bg-white rounded-lg shadow-md md:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-700">Upcoming Tasks</h2>
                    <a href="{{ route('student.tasks.index') }}" class="text-sm text-accent hover:underline">
                        View All
                    </a>
                </div>

                @forelse($tasks as $studentTask)
                    <div class="mb-3 p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-medium text-gray-800">
                                    {{ $studentTask->task->title }}
                                </h3>
                                <div class="mt-1 space-y-1">
                                    <p class="text-sm text-gray-600">
                                        {{ Str::limit($studentTask->task->description, 100) }}
                                    </p>
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span class="flex items-center">
                                            <i class="fi fi-rr-book-alt mr-1"></i>
                                            {{ $studentTask->task->classroom->subject->name }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fi fi-rr-calendar mr-1"></i>
                                            Due: {{ Carbon\Carbon::parse($studentTask->task->due_date)->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span class="badge {{ $studentTask->status === 'completed' ? 'badge-success' : 'badge-warning' }}">
                                {{ ucfirst($studentTask->status) }}
                            </span>
                        </div>

                        @if($studentTask->task->attachments_count > 0)
                            <div class="mt-2 text-xs text-gray-500">
                                <i class="fi fi-rr-clip mr-1"></i>
                                {{ $studentTask->task->attachments_count }} attachment(s)
                            </div>
                        @endif

                        <div class="mt-2">
                            <a href="{{ route('student.tasks.show', $studentTask->task) }}"
                               class="text-sm text-accent hover:underline">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-sm text-center text-gray-500 bg-gray-50 rounded-lg">
                        <i class="text-xl fi fi-rr-info"></i>
                        <p class="mt-1">No upcoming tasks at the moment.</p>
                    </div>
                @endforelse
            </div>

            <!-- Announcements -->
            <div class="p-4 bg-white rounded-lg shadow-md md:col-span-3">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-700">Latest Announcements</h2>
                    <a href="{{ route('student.announcements.index') }}" class="text-sm text-accent hover:underline">
                        View All
                    </a>
                </div>

                @forelse($announcements as $announcement)
                    <div class="mb-4 overflow-hidden bg-gray-50 rounded-lg">
                        <div class="p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        {{ $announcement->title }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {!! Str::limit(strip_tags($announcement->content), 150) !!}
                                    </p>
                                </div>
                                @if($announcement->is_important)
                                    <span class="px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                        Important
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center gap-4 mt-3">
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="mr-1 fi fi-rr-user"></i>
                                    {{ $announcement->postedBy->name }}
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="mr-1 fi fi-rr-calendar"></i>
                                    {{ $announcement->created_at->format('M d, Y') }}
                                </div>
                            </div>

                            <div class="flex items-center gap-2 mt-3">
                                @if($announcement->attachments_count > 0)
                                    <span class="flex items-center text-xs text-gray-500">
                                        <i class="mr-1 fi fi-rr-clip"></i>
                                        {{ $announcement->attachments_count }} attachment(s)
                                    </span>
                                @endif
                                <a href="{{ route('student.announcements.show', $announcement) }}"
                                   class="text-sm text-accent hover:underline">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-sm text-center text-gray-500 bg-gray-50 rounded-lg">
                        <i class="text-xl fi fi-rr-info"></i>
                        <p class="mt-1">No announcements available at the moment.</p>
                    </div>
                @endforelse
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
                    <a href="{{ route('student.settings.index') }}" class="text-blue-600 hover:underline">Edit Profile</a>
                </p>
            </div>

        </div>
    </div>

</x-dashboard.student.base>
