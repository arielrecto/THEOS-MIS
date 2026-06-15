<x-dashboard.student.base>
    <div class="container px-4 sm:px-6 lg:px-8 py-6">
        <h1 class="mb-4 text-2xl sm:text-3xl font-bold text-gray-700 break-words">Student Dashboard</h1>

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
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-3">
                    <h2 class="text-lg font-bold text-gray-700">Upcoming Tasks</h2>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('student.tasks.index') }}"
                            class="text-sm text-accent hover:underline whitespace-nowrap hidden sm:inline">
                            View All
                        </a>

                        <!-- mobile view link -->
                        <a href="{{ route('student.tasks.index') }}"
                            class="text-sm text-accent hover:underline sm:hidden">
                            View
                        </a>
                    </div>
                </div>

                <div class="flex-1 overflow-hidden">
                    <div class="space-y-3 max-h-72 md:max-h-none overflow-auto pr-2">
                        @forelse($tasks as $studentTask)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-medium text-gray-800 truncate break-words">
                                            {{ $studentTask->task->title }}
                                        </h3>

                                        <div class="mt-1 space-y-1">
                                            <p class="text-sm text-gray-600 line-clamp-3 break-words">
                                                {{ Str::limit($studentTask->task->description, 100) }}
                                            </p>

                                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                                <span class="flex items-center gap-1 min-w-0">
                                                    <i class="fi fi-rr-book-alt"></i>
                                                    <span
                                                        class="truncate min-w-0">{{ $studentTask->task->classroom->subject->name }}</span>
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fi fi-rr-calendar"></i>
                                                    <span class="truncate">Due:
                                                        {{ Carbon\Carbon::parse($studentTask->task->due_date)->format('M d, Y') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0 ml-3 flex flex-col items-end gap-2">
                                        <span
                                            class="badge {{ $studentTask->status === 'completed' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($studentTask->status) }}
                                        </span>

                                        <a href="{{ route('student.tasks.show', $studentTask->task) }}"
                                            class="text-xs text-accent hover:underline whitespace-nowrap">
                                            View Details
                                        </a>
                                    </div>
                                </div>

                                @if ($studentTask->task->attachments_count > 0)
                                    <div class="mt-2 text-xs text-gray-500 flex items-center gap-2">
                                        <i class="fi fi-rr-clip"></i>
                                        <span class="truncate">{{ $studentTask->task->attachments_count }}
                                            attachment(s)</span>
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
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-3">
                    <h2 class="text-lg font-bold text-gray-700">Latest Announcements</h2>
                    <a href="{{ route('student.announcements.index') }}"
                        class="text-sm text-accent hover:underline whitespace-nowrap">
                        View All
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($announcements as $announcement)
                        <article class="mb-4 overflow-hidden bg-gray-50 rounded-lg">
                            <div class="p-4">
                                <div
                                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800 truncate break-words">
                                            {{ $announcement->title }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600 line-clamp-3 break-words">
                                            {!! Str::limit(strip_tags($announcement->content), 150) !!}
                                        </p>
                                    </div>

                                    @if ($announcement->is_important)
                                        <span
                                            class="mt-2 sm:mt-0 px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full whitespace-nowrap">
                                            Important
                                        </span>
                                    @endif
                                </div>

                                <div class="flex flex-wrap items-center gap-3 mt-3 text-sm text-gray-500">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <i class="fi fi-rr-user"></i>
                                        <span class="truncate">{{ $announcement->postedBy->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fi fi-rr-calendar"></i>
                                        <span>{{ $announcement->created_at->format('M d, Y') }}</span>
                                    </div>

                                    @if ($announcement->attachments_count > 0)
                                        <div class="flex items-center gap-2">
                                            <i class="fi fi-rr-clip"></i>
                                            <span class="text-xs">{{ $announcement->attachments_count }}
                                                attachment(s)</span>
                                        </div>
                                    @endif

                                    <div class="ml-auto">
                                        <a href="{{ route('student.announcements.show', $announcement) }}"
                                            class="text-sm text-accent hover:underline whitespace-nowrap">
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

            <!-- My Subjects -->
            <div class="p-4 bg-white rounded-lg shadow-md md:col-span-3">
                <div class="flex items-center gap-2 mb-4">
                    <i class="fi fi-rr-book-alt text-accent"></i>
                    <h2 class="text-lg font-bold text-gray-700">My Subjects</h2>
                    @php $gradeLevel = $student->studentProfile?->academicRecords?->first()?->grade_level; @endphp
                    @if($gradeLevel)
                        <span class="badge badge-accent badge-sm ml-1">{{ $gradeLevel }}</span>
                    @endif
                    <span class="badge badge-ghost badge-sm ml-auto">
                        {{ $student->asStudentClassrooms->count() }} subject(s)
                    </span>
                </div>

                @if($student->asStudentClassrooms->count())
                    {{-- Desktop Table --}}
                    <div class="hidden sm:block overflow-x-auto rounded-lg border border-gray-100">
                        <table class="table table-zebra w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wide">
                                    <th>#</th>
                                    <th>Subject</th>
                                    <th>Classroom</th>
                                    <th>Teacher</th>
                                    <th>Grade Level</th>
                                    <th>School Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->asStudentClassrooms as $i => $cs)
                                    @php $room = $cs->classroom; @endphp
                                    <tr class="hover">
                                        <td class="text-gray-400 text-xs">{{ $i + 1 }}</td>
                                        <td>
                                            <p class="font-semibold text-gray-800">{{ $room->subject?->name ?? '—' }}</p>
                                            @if($room->subject?->subject_code)
                                                <p class="text-xs text-gray-400">{{ $room->subject->subject_code }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="text-gray-700">{{ $room->name ?? '—' }}</p>
                                            <p class="text-xs text-gray-400">{{ $room->class_code ?? '' }}</p>
                                        </td>
                                        <td class="text-gray-700">{{ $room->teacher?->name ?? '—' }}</td>
                                        <td>
                                            @if($room->strand)
                                                <span class="badge badge-ghost badge-sm">{{ $room->strand->name }}</span>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="text-xs text-gray-500">{{ $room->academicYear?->name ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="block sm:hidden space-y-3">
                        @foreach($student->asStudentClassrooms as $cs)
                            @php $room = $cs->classroom; @endphp
                            <div class="rounded-lg border border-gray-100 p-4 bg-gray-50 space-y-2">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ $room->subject?->name ?? '—' }}</p>
                                        <p class="text-xs text-gray-500">{{ $room->name ?? '' }}</p>
                                    </div>
                                    @if($room->strand)
                                        <span class="badge badge-ghost badge-sm">{{ $room->strand->name }}</span>
                                    @endif
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                    <div>
                                        <span class="text-gray-400">Teacher</span>
                                        <p class="font-medium">{{ $room->teacher?->name ?? '—' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-400">School Year</span>
                                        <p class="font-medium">{{ $room->academicYear?->name ?? '—' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-8 text-center text-gray-400 bg-gray-50 rounded-lg">
                        <i class="fi fi-rr-book-alt text-3xl block mb-2"></i>
                        <p class="text-sm">No subjects assigned yet. Please contact your administrator.</p>
                    </div>
                @endif
            </div>

            <!-- Profile Information -->
            <div class="p-4 bg-white rounded-lg shadow-md">
                <h2 class="text-lg font-bold text-gray-700">Student Profile</h2>
                <p class="mt-2 text-sm text-gray-600 break-words">
                    <strong>Name:</strong> <span class="block sm:inline">{{ $student->name }}</span><br>
                    <strong>Student ID:</strong> <span
                        class="block sm:inline">{{ $student->studentProfile->lrn ?? 'Not Enrolled' }}</span><br>
                    <strong>Grade Level:</strong>
                    <span
                        class="block sm:inline">{{ $student->studentProfile?->academicRecords()?->latest()->first()?->grade_level }}</span>
                </p>
            </div>

            <!-- Account Settings -->
            <div class="p-4 bg-white rounded-lg shadow-md md:col-span-2">
                <h2 class="text-lg font-bold text-gray-700 mb-3">Account Settings</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('student.settings.index') }}"
                       class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 hover:bg-accent/10 transition-colors">
                        <i class="fi fi-rr-user-pen text-accent text-xl"></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Edit Profile</p>
                            <p class="text-xs text-gray-500">Update your personal information</p>
                        </div>
                    </a>
                    <a href="{{ route('student.settings.index') }}"
                       class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 hover:bg-accent/10 transition-colors">
                        <i class="fi fi-rr-lock text-accent text-xl"></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Change Password</p>
                            <p class="text-xs text-gray-500">Update your account password</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Academic Grades Section -->
            <div class="p-4 bg-white rounded-lg shadow-md md:col-span-3">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-3">
                    <h2 class="text-lg font-bold text-gray-700">My Grades</h2>
                </div>

                @if($student?->studentProfile?->academicRecords && $student->studentProfile->academicRecords->count() > 0)
                    <div class="space-y-6">
                        @foreach($student->studentProfile->academicRecords->take(3) as $record)
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <!-- Record Header -->
                                <div class="bg-gradient-to-r from-accent/10 to-accent/5 px-4 py-3 border-b">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <div>
                                            <h3 class="font-semibold text-gray-800">
                                                {{ $record->grade_level }}
                                                @if($record->section && $record->section->strand)
                                                    - {{ $record->section->strand->acronym ?? $record->section->strand->name }}
                                                @endif
                                            </h3>
                                            <p class="text-sm text-gray-600">
                                                {{ $record->academicYear->name }}
                                                @if($record->section)
                                                    • Section: {{ $record->section->name }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-accent">
                                                {{ number_format($record->average ?? 0, 1) }}%
                                            </div>
                                            <div class="text-xs text-gray-600">General Average</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Grades Table - Desktop -->
                                <div class="hidden md:block overflow-x-auto">
                                    <table class="table table-zebra w-full text-sm">
                                        <thead>
                                            <tr class="bg-gray-50">
                                                <th class="text-left">Subject</th>
                                                <th class="text-center">Q1</th>
                                                <th class="text-center">Q2</th>
                                                <th class="text-center">Q3</th>
                                                <th class="text-center">Q4</th>
                                                <th class="text-center">Final</th>
                                                <th class="text-center">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $subjectGrades = $record->grades->groupBy('subject');
                                            @endphp

                                            @forelse($subjectGrades as $subject => $grades)
                                                <tr>
                                                    <td class="font-medium">{{ $subject }}</td>
                                                    @php
                                                        $quarterGrades = [
                                                            'Q1' => $grades->firstWhere('quarter', 'Q1')?->grade ?? '-',
                                                            'Q2' => $grades->firstWhere('quarter', 'Q2')?->grade ?? '-',
                                                            'Q3' => $grades->firstWhere('quarter', 'Q3')?->grade ?? '-',
                                                            'Q4' => $grades->firstWhere('quarter', 'Q4')?->grade ?? '-',
                                                        ];
                                                        $numericGrades = collect($quarterGrades)->filter(fn($g) => is_numeric($g));
                                                        $finalGrade = $numericGrades->isNotEmpty() ? $numericGrades->avg() : 0;
                                                    @endphp

                                                    @foreach($quarterGrades as $grade)
                                                        <td class="text-center">
                                                            {{ is_numeric($grade) ? number_format($grade, 1) : $grade }}
                                                        </td>
                                                    @endforeach

                                                    <td class="text-center font-bold">
                                                        {{ $finalGrade > 0 ? number_format($finalGrade, 1) : '-' }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if($finalGrade > 0)
                                                            <span class="badge badge-sm {{ $finalGrade >= 75 ? 'badge-success' : 'badge-error' }}">
                                                                {{ $finalGrade >= 75 ? 'Passed' : 'Failed' }}
                                                            </span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-gray-500 py-4">
                                                        No grades recorded yet
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Grades Cards - Mobile -->
                                <div class="md:hidden divide-y">
                                    @php
                                        $subjectGrades = $record->grades->groupBy('subject');
                                    @endphp

                                    @forelse($subjectGrades as $subject => $grades)
                                        @php
                                            $quarterGrades = [
                                                'Q1' => $grades->firstWhere('quarter', 'Q1')?->grade ?? '-',
                                                'Q2' => $grades->firstWhere('quarter', 'Q2')?->grade ?? '-',
                                                'Q3' => $grades->firstWhere('quarter', 'Q3')?->grade ?? '-',
                                                'Q4' => $grades->firstWhere('quarter', 'Q4')?->grade ?? '-',
                                            ];
                                            $numericGrades = collect($quarterGrades)->filter(fn($g) => is_numeric($g));
                                            $finalGrade = $numericGrades->isNotEmpty() ? $numericGrades->avg() : 0;
                                        @endphp

                                        <div class="p-4">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="font-semibold text-gray-800">{{ $subject }}</h4>
                                                <div class="text-right">
                                                    <div class="font-bold text-lg text-accent">
                                                        {{ $finalGrade > 0 ? number_format($finalGrade, 1) : '-' }}
                                                    </div>
                                                    @if($finalGrade > 0)
                                                        <span class="badge badge-sm {{ $finalGrade >= 75 ? 'badge-success' : 'badge-error' }}">
                                                            {{ $finalGrade >= 75 ? 'Passed' : 'Failed' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-4 gap-2 text-center text-sm">
                                                @foreach($quarterGrades as $quarter => $grade)
                                                    <div class="bg-gray-50 rounded p-2">
                                                        <div class="text-xs text-gray-600 mb-1">{{ $quarter }}</div>
                                                        <div class="font-medium">
                                                            {{ is_numeric($grade) ? number_format($grade, 1) : $grade }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-4 text-center text-gray-500 text-sm">
                                            No grades recorded yet
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach

                        @if($student->studentProfile->academicRecords->count() > 3)
                            <div class="text-center pt-2">
                                <p class="text-sm text-gray-600">
                                    Showing 3 of {{ $student->studentProfile->academicRecords->count() }} academic records
                                </p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500 bg-gray-50 rounded-lg">
                        <i class="fi fi-rr-document text-4xl mb-3"></i>
                        <p class="text-sm">No academic records found</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-dashboard.student.base>
