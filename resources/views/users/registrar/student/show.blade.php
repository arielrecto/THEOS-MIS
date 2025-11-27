<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Student Record')" :back_url="route('registrar.students.index')" />
    <x-notification-message />

    <!-- Student Profile Header -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            <div class="md:col-span-3 flex justify-center md:justify-start">
                <div class="avatar">
                    <div class="w-24 h-24 rounded-full ring-2 ring-accent ring-offset-2 overflow-hidden">
                        <img class="object-cover w-full h-full"
                             src="{{ $student->studentProfile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}"
                             alt="Profile Photo">
                    </div>
                </div>
            </div>

            <div class="md:col-span-6 flex flex-col justify-center">
                <h2 class="text-2xl font-bold truncate">{{ $student->name }}</h2>
                <p class="text-gray-600 mt-1 truncate">LRN: {{ $student?->studentProfile?->lrn ?? 'N/A' }}</p>

                <div class="mt-3 flex flex-col sm:flex-row sm:items-center gap-2">
                    <p class="text-sm text-gray-500">
                        <span class="font-medium">Contact:</span>
                        <span class="ml-1">{{ $student?->studentProfile?->contact_number ?? 'N/A' }}</span>
                    </p>

                    <p class="text-sm text-gray-500">
                        <span class="font-medium">Address:</span>
                        <span class="ml-1 truncate">{{ $student?->studentProfile?->address ?? 'N/A' }}</span>
                    </p>
                </div>
            </div>

            <div class="md:col-span-3 flex flex-col items-start md:items-end gap-2">
                <div class="w-full flex gap-2">
                    <a href="{{ route('registrar.students.good-moral', $student->id) }}"
                       target="_blank"
                       class="btn btn-outline btn-accent flex-1 md:flex-none w-full md:w-auto justify-center">
                        <i class="fi fi-rr-diploma mr-2"></i>
                        <span class="hidden sm:inline">Good Moral Certificate</span>
                    </a>
                    <a href="{{ route('registrar.students.form-137', $student->id) }}"
                       target="_blank"
                       class="btn btn-outline btn-accent flex-1 md:flex-none w-full md:w-auto justify-center">
                        <i class="fi fi-rr-document mr-2"></i>
                        <span class="hidden sm:inline">Form 137</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Student Information -->
        <div class="col-span-1 lg:col-span-4">
            <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
                <h3 class="text-lg font-bold mb-4">Personal Information</h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                            <p class="mt-1">{{ $student?->studentProfile?->birthdate ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact</p>
                            <p class="mt-1">{{ $student?->studentProfile?->contact_number ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Address</p>
                        <p class="mt-1 break-words">{{ $student?->studentProfile?->address ?? 'N/A' }}</p>
                    </div>

                    <div class="pt-4 border-t">
                        <p class="text-sm font-medium text-gray-500">Parent/Guardian</p>
                        <p class="mt-1 font-medium">{{ $student?->studentProfile?->parent_name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $student?->studentProfile?->relationship ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Records -->
        <div class="col-span-1 lg:col-span-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Filter Section -->
                <div class="p-4 border-b">
                    <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <div class="form-control w-full sm:w-auto">
                            <select name="academic_year"
                                    onchange="this.form.submit()"
                                    class="select select-bordered w-full">
                                <option value="">{{ __('All Academic Years') }}</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}"
                                            {{ request('academic_year') == $year->id ? 'selected' : '' }}>
                                        {{ $year->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-2 ml-auto">
                            @if(request('academic_year'))
                                <a href="{{ route('registrar.students.show', $student->id) }}"
                                   class="btn btn-ghost btn-sm">
                                    <i class="fi fi-rr-refresh mr-2"></i>
                                    <span class="hidden sm:inline">Clear</span>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Academic Records</h3>
                        @if(request('academic_year'))
                            <span class="badge badge-accent">
                                {{ $academicYears->find(request('academic_year'))->name }}
                            </span>
                        @endif
                    </div>

                    {{-- NEW: Enrolled subjects from ClassroomStudent with grades (if present) --}}
                    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                        <h4 class="text-base font-medium mb-3">Enrolled Subjects (from Classrooms)</h4>

                        @php
                            // pick record to check grades against: prefer requested academic year, fallback to latest
                            $profile = $student?->studentProfile;
                            $selectedRecord = null;
                            if($profile) {
                                if(request('academic_year')) {
                                    $selectedRecord = $profile->academicRecords->firstWhere('academic_year_id', request('academic_year'));
                                }
                                $selectedRecord = $selectedRecord ?? $profile->academicRecords->sortByDesc('id')->first();
                            }
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @php
                                // prefer the explicit user relation if available (asStudentClassrooms),
                                // otherwise fall back to classroomStudents
                                $studentClassrooms = $student->asStudentClassrooms ?? $student->classroomStudents ?? collect();
                            @endphp

                            @forelse($studentClassrooms as $classroomStudent)
                                @php
                                    // support cases where relation returns ClassroomStudent or Classroom directly
                                    $classroom = $classroomStudent->classroom ?? $classroomStudent;
                                    $subject = $classroom->subject ?? null;

                                    // grade records store subject as string — match by subject name when available
                                    $matchedGrade = null;
                                    if ($selectedRecord && $selectedRecord->grades && $subject) {
                                        $matchedGrade = $selectedRecord->grades->firstWhere('subject', $subject->name);
                                    }
                                @endphp

                                <div class="flex items-center justify-between bg-base-100 rounded-md p-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">
                                            {{ $subject->name ?? ($classroom->name ?? 'N/A') }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">
                                            Classroom: {{ $classroom->name ?? 'N/A' }}
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        @if($matchedGrade)
                                            <div class="text-sm font-semibold {{ $matchedGrade->grade >= 75 ? 'text-success' : 'text-error' }}">
                                                {{ number_format($matchedGrade->grade, 1) }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                <span class="badge {{ $matchedGrade->grade >= 75 ? 'badge-success' : 'badge-error' }} text-xs">
                                                    {{ $matchedGrade->remarks ?? 'N/A' }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500">No grade</div>
                                            <div class="text-xs text-gray-400 mt-1">Record: {{ $selectedRecord?->academicYear?->name ?? '—' }}</div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-gray-500">No enrolled classrooms found for this student.</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Desktop / Tablet: table view --}}
                    <div class="hidden md:block">
                        @forelse($student?->studentProfile?->academicRecords ?? [] as $record)
                            <div class="mb-8 last:mb-0">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <h4 class="text-lg font-medium">Grade {{ $record?->grade_level ?? 'N/A' }}</h4>
                                        <p class="text-sm text-gray-600">{{ $record?->academicYear?->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="text-right">
                                            <span class="text-2xl font-bold {{ $record?->average >= 75 ? 'text-success' : 'text-error' }}">
                                                {{ number_format($record?->average ?? 0, 1) }}%
                                            </span>
                                            <div class="text-sm text-gray-500">Average</div>
                                        </div>
                                        <a href="{{ route('registrar.students.print', ['student' => $student->id, 'record' => $record->id]) }}"
                                           target="_blank"
                                           class="btn btn-ghost btn-sm">
                                            <i class="fi fi-rr-print mr-2"></i>
                                            Report Card
                                        </a>
                                    </div>
                                </div>

                                <div class="overflow-x-auto bg-base-100 rounded-lg border">
                                    <table class="table table-zebra w-full">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th class="text-right">Grade</th>
                                                <th class="text-right">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($record?->grades ?? [] as $grade)
                                                <tr>
                                                    <td>{{ $grade?->subject ?? 'N/A' }}</td>
                                                    <td class="text-right font-medium">
                                                        {{ number_format($grade?->grade ?? 0, 1) }}
                                                    </td>
                                                    <td class="text-right">
                                                        <span class="badge {{ $grade?->grade >= 75 ? 'badge-success' : 'badge-error' }}">
                                                            {{ $grade?->remarks ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-base-200 mb-4">
                                    <i class="fi fi-rr-book-open-cover text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">No Records Found</h3>
                                <p class="text-gray-500 mt-1">No academic records available for this student.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Mobile: stacked cards --}}
                    <div class="md:hidden space-y-4">
                        @forelse($student?->studentProfile?->academicRecords ?? [] as $record)
                            <div class="bg-base-100 rounded-lg border p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h4 class="text-base font-medium truncate">Grade {{ $record?->grade_level ?? 'N/A' }}</h4>
                                        <p class="text-xs text-gray-500 truncate">{{ $record?->academicYear?->name ?? 'N/A' }}</p>

                                        <div class="mt-3 text-sm text-gray-600">
                                            <p class="truncate">
                                                Subjects: {{ $record?->grades->count() ?? 0 }}
                                                · Avg: <span class="{{ $record?->average >= 75 ? 'text-success font-bold' : 'text-error font-bold' }}">
                                                    {{ number_format($record?->average ?? 0, 1) }}%
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0 flex flex-col items-end gap-2">
                                        <a href="{{ route('registrar.students.print', ['student' => $student->id, 'record' => $record->id]) }}"
                                           target="_blank"
                                           class="btn btn-ghost btn-xs">
                                            <i class="fi fi-rr-print"></i>
                                        </a>

                                        {{-- <button type="button" class="btn btn-outline btn-xs" x-data @click="$dispatch('open-record', {{ $record->id ?? 'null' }})">
                                            View Subjects
                                        </button> --}}
                                    </div>
                                </div>

                                {{-- Collapsible subjects for mobile (small, hidden by default; optional JS can toggle) --}}
                                <details class="mt-3">
                                    <summary class="text-sm text-gray-600 cursor-pointer">Show subjects ({{ $record?->grades->count() ?? 0 }})</summary>
                                    <div class="mt-2 space-y-2">
                                        @foreach($record?->grades ?? [] as $grade)
                                            <div class="flex justify-between items-center text-sm">
                                                <div class="truncate">{{ $grade->subject ?? 'N/A' }}</div>
                                                <div class="text-right">
                                                    <span class="font-medium">{{ number_format($grade->grade ?? 0, 1) }}</span>
                                                    <div class="text-xs {{ $grade->grade >= 75 ? 'text-success' : 'text-error' }}">
                                                        {{ $grade->remarks ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            </div>
                        @empty
                            <div class="bg-base-100 rounded-lg p-6 text-center text-gray-500">
                                <i class="fi fi-rr-book-open-cover text-2xl mb-2"></i>
                                <p>No academic records found</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.registrar.base>
