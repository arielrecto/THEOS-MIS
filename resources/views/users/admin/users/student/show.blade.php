<x-dashboard.admin.base>
    <x-dashboard.page-title :title="$student->name" :back_url="route('admin.users.students.index')">
        <x-slot name="other">
            <a href="{{ route('admin.users.students.edit', $student->id) }}"
               class="btn btn-accent btn-sm gap-2 text-white">
                <i class="fi fi-rr-edit"></i>
                <span class="hidden sm:inline">Edit</span>
            </a>
        </x-slot>
    </x-dashboard.page-title>

    <x-notification-message />

    <div class="space-y-6">

        {{-- Profile Header --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">

                {{-- Avatar --}}
                <div class="shrink-0">
                    <div class="avatar">
                        <div class="w-24 h-24 rounded-full ring-2 ring-accent ring-offset-2 overflow-hidden">
                            @if($student->profilePicture)
                                <img src="{{ asset($student->profilePicture->file_dir) }}"
                                     alt="{{ $student->name }}" class="object-cover w-full h-full">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=256&background=random"
                                     alt="{{ $student->name }}" class="object-cover w-full h-full">
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Identity --}}
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-xl font-bold text-gray-800">{{ $student->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $student->email }}</p>
                    @if($student->studentProfile?->lrn)
                        <p class="text-xs text-gray-400 mt-1">LRN: {{ $student->studentProfile->lrn }}</p>
                    @endif

                    {{-- Latest grade level badge --}}
                    @php $latestRecord = $student->studentProfile?->academicRecords->sortByDesc('id')->first(); @endphp
                    @if($latestRecord)
                        <div class="mt-3 flex flex-wrap justify-center sm:justify-start gap-2">
                            <span class="badge badge-accent">{{ $latestRecord->grade_level }}</span>
                            @if($latestRecord->academicYear)
                                <span class="badge badge-ghost badge-sm">{{ $latestRecord->academicYear->name }}</span>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 w-full sm:w-auto mt-2 sm:mt-0">
                    <div class="bg-accent/10 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-accent">{{ $student->asStudentClassrooms->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Classrooms</p>
                    </div>
                    <div class="bg-primary/10 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-accent">{{ $student->studentProfile?->academicRecords->count() ?? 0 }}</p>
                        <p class="text-xs text-gray-500 mt-1">Records</p>
                    </div>
                    <div class="bg-secondary/10 rounded-lg p-3 text-center col-span-2 sm:col-span-1">
                        @php $avg = $student->studentProfile?->academicRecords->avg('average') ?? 0; @endphp
                        <p class="text-2xl font-bold text-secondary">{{ $avg ? number_format($avg, 1) : '—' }}</p>
                        <p class="text-xs text-gray-500 mt-1">Avg Grade</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Personal Info --}}
            <div class="lg:col-span-1 space-y-6">

                <div class="bg-base-100 rounded-lg shadow-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fi fi-rr-user text-accent"></i>
                        <h3 class="font-bold text-accent">Personal Information</h3>
                    </div>
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Full Name</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">
                                {{ trim(collect([
                                    $student->studentProfile?->first_name,
                                    $student->studentProfile?->middle_name,
                                    $student->studentProfile?->last_name,
                                    $student->studentProfile?->extension_name,
                                ])->filter()->join(' ')) ?: $student->name }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Date of Birth</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">
                                {{ $student->studentProfile?->birthdate ?? '—' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Contact</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">
                                {{ $student->studentProfile?->contact_number ?? '—' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Address</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">
                                {{ collect([
                                    $student->studentProfile?->barangay,
                                    $student->studentProfile?->city,
                                    $student->studentProfile?->province,
                                ])->filter()->join(', ') ?: '—' }}
                            </dd>
                        </div>
                        <div class="pt-2 border-t border-base-200">
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Parent / Guardian</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $student->studentProfile?->parent_name ?? '—' }}</dd>
                            <dd class="text-xs text-gray-500">{{ $student->studentProfile?->relationship ?? '' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Academic Records --}}
                @if($student->studentProfile?->academicRecords->count())
                    <div class="bg-base-100 rounded-lg shadow-lg p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fi fi-rr-graduation-cap text-accent"></i>
                            <h3 class="font-bold text-accent">Academic Records</h3>
                        </div>
                        <div class="space-y-2">
                            @foreach($student->studentProfile->academicRecords->sortByDesc('id') as $record)
                                <div class="flex items-center justify-between p-3 rounded-lg bg-base-200">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">{{ $record->grade_level }}</p>
                                        <p class="text-xs text-gray-500">{{ $record->academicYear?->name ?? '—' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-sm {{ ($record->average ?? 0) >= 75 ? 'text-success' : 'text-error' }}">
                                            {{ $record->average ? number_format($record->average, 1) . '%' : '—' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            {{-- Right: Classrooms --}}
            <div class="lg:col-span-2">
                <div class="bg-base-100 rounded-lg shadow-lg p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <i class="fi fi-rr-chalkboard-user text-accent"></i>
                        <h3 class="font-bold text-accent">Enrolled Classrooms</h3>
                        <span class="badge badge-ghost badge-sm ml-auto">
                            {{ $student->asStudentClassrooms->count() }}
                        </span>
                    </div>

                    @if($student->asStudentClassrooms->count())

                        {{-- Desktop Table --}}
                        <div class="hidden sm:block overflow-x-auto rounded-lg border border-base-200">
                            <table class="table table-zebra w-full text-sm">
                                <thead>
                                    <tr class="bg-base-200 text-gray-600 uppercase text-xs tracking-wide">
                                        <th>Classroom</th>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Grade Level</th>
                                        <th>School Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($student->asStudentClassrooms as $cs)
                                        @php $room = $cs->classroom; @endphp
                                        <tr class="hover">
                                            <td>
                                                <p class="font-semibold text-gray-800">{{ $room->name ?? '—' }}</p>
                                                <p class="text-xs text-gray-400">{{ $room->class_code ?? '' }}</p>
                                            </td>
                                            <td>{{ $room->subject?->name ?? '—' }}</td>
                                            <td>{{ $room->teacher?->name ?? '—' }}</td>
                                            <td>
                                                @if($room->strand)
                                                    <span class="badge badge-ghost badge-sm">{{ $room->strand->acronym ?? $room->strand->name }}</span>
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
                                <div class="rounded-lg border border-base-200 p-4 space-y-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm">{{ $room->name ?? '—' }}</p>
                                            <p class="text-xs text-gray-400">{{ $room->class_code ?? '' }}</p>
                                        </div>
                                        @if($room->strand)
                                            <span class="badge badge-ghost badge-sm">{{ $room->strand->acronym ?? $room->strand->name }}</span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                        <div>
                                            <span class="text-gray-400">Subject</span>
                                            <p class="font-medium">{{ $room->subject?->name ?? '—' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-400">Teacher</span>
                                            <p class="font-medium">{{ $room->teacher?->name ?? '—' }}</p>
                                        </div>
                                        <div class="col-span-2">
                                            <span class="text-gray-400">School Year</span>
                                            <p class="font-medium">{{ $room->academicYear?->name ?? '—' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    @else
                        <div class="text-center py-12 text-gray-400">
                            <i class="fi fi-rr-chalkboard-user block text-3xl mb-2"></i>
                            <p class="text-sm">No classrooms assigned yet</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-dashboard.admin.base>
