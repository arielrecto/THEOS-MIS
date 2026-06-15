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

            {{-- Generate Enrollment Form --}}
            @php $latestEnrollmentForm = $student->enrollmentForms->first(); @endphp
            <div class="mt-4 flex justify-end">
                @if($latestEnrollmentForm)
                    <a href="{{ route('enrollment.print', $latestEnrollmentForm->id) }}"
                       class="btn btn-sm gap-2 text-white"
                       style="background-color:#3277C5;border-color:#3277C5;"
                       target="_blank">
                        <i class="fi fi-rr-document text-white"></i>
                        Generate Enrollment Form
                    </a>
                @else
                    <button class="btn btn-sm gap-2 text-white opacity-50 cursor-not-allowed" disabled
                            style="background-color:#3277C5;border-color:#3277C5;">
                        <i class="fi fi-rr-document text-white"></i>
                        No Enrollment Form
                    </button>
                @endif
            </div>
        </div>

        <div class="space-y-6">

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                {{-- Personal Information --}}
                <div class="bg-base-100 rounded-lg shadow-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fi fi-rr-user text-accent"></i>
                        <h3 class="font-bold text-accent">Personal Information</h3>
                    </div>
                    @php $sp = $student->studentProfile; @endphp
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">LRN</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->lrn ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Last Name</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->last_name ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">First Name</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->first_name ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Middle Name</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->middle_name ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Extension Name</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->extension_name ?? '—' }}</dd>
                        </div>
                        <div class="pt-2 border-t border-base-200">
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Date of Birth</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">
                                {{ $sp?->birthdate ? \Carbon\Carbon::parse($sp->birthdate)->format('F d, Y') : '—' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Place of Birth</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->birthplace ?? ($latestEnrollmentForm?->birthplace ?? '—') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Contact Number</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->contact_number ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Email</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->email ?? $student->email }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Address --}}
                <div class="bg-base-100 rounded-lg shadow-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fi fi-rr-marker text-accent"></i>
                        <h3 class="font-bold text-accent">Address</h3>
                    </div>
                    <dl class="space-y-3 text-sm">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Current Address</p>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">House / Block / Lot</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->house_no ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Street</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->street ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Barangay</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->barangay ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">City / Municipality</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->city ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Province</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->province ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Zip Code</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->zip_code ?? '—' }}</dd>
                        </div>

                        @if($sp?->perm_barangay || $sp?->perm_city || $sp?->perm_province)
                            <div class="pt-3 border-t border-base-200">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Permanent Address</p>
                                <div class="space-y-3">
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">House / Block / Lot</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->perm_house_no ?? '—' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Street</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->perm_street ?? '—' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Barangay</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->perm_barangay ?? '—' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">City / Municipality</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->perm_city ?? '—' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Province</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->perm_province ?? '—' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Zip Code</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->perm_zip_code ?? '—' }}</dd>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Family Information --}}
                <div class="bg-base-100 rounded-lg shadow-lg p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fi fi-rr-users text-accent"></i>
                        <h3 class="font-bold text-accent">Family Information</h3>
                    </div>
                    <dl class="space-y-3 text-sm">
                        {{-- Father --}}
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Father</p>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Name</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">
                                {{ trim(collect([
                                    $latestEnrollmentForm?->parent_name,
                                    $latestEnrollmentForm?->parent_last_name,
                                ])->filter()->join(' ')) ?: ($sp?->parent_name ?? '—') }}
                            </dd>
                        </div>
                        @if($latestEnrollmentForm?->parent_middle_name)
                            <div>
                                <dt class="text-xs text-gray-500 uppercase tracking-wide">Middle Name</dt>
                                <dd class="font-medium text-gray-800 mt-0.5">{{ $latestEnrollmentForm->parent_middle_name }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Contact</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->contact_number ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Occupation</dt>
                            <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->occupation ?? ($latestEnrollmentForm?->occupation ?? '—') }}</dd>
                        </div>

                        {{-- Mother --}}
                        @if($latestEnrollmentForm?->mother_name || $latestEnrollmentForm?->mother_last_name)
                            <div class="pt-3 border-t border-base-200">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Mother</p>
                                <div class="space-y-3">
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Name</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">
                                            {{ trim(collect([
                                                $latestEnrollmentForm->mother_name,
                                                $latestEnrollmentForm->mother_middle_name,
                                                $latestEnrollmentForm->mother_last_name,
                                            ])->filter()->join(' ')) ?: '—' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Contact</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $latestEnrollmentForm->mother_contact_number ?? '—' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Occupation</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $latestEnrollmentForm->mother_occupation ?? '—' }}</dd>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Guardian --}}
                        @if($latestEnrollmentForm?->guardian_name || $latestEnrollmentForm?->guardian_last_name)
                            <div class="pt-3 border-t border-base-200">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Guardian</p>
                                <div class="space-y-3">
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Name</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">
                                            {{ trim(collect([
                                                $latestEnrollmentForm->guardian_name,
                                                $latestEnrollmentForm->guardian_middle_name,
                                                $latestEnrollmentForm->guardian_last_name,
                                            ])->filter()->join(' ')) ?: '—' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Relationship</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $latestEnrollmentForm->guardian_relationship ?? '—' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Contact</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $latestEnrollmentForm->guardian_contact_number ?? '—' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Occupation</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $latestEnrollmentForm->guardian_occupation ?? '—' }}</dd>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Academic Preferences --}}
                @if($sp?->preferred_track || $sp?->preferred_strand || $sp?->modality)
                    <div class="bg-base-100 rounded-lg shadow-lg p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fi fi-rr-book-alt text-accent"></i>
                            <h3 class="font-bold text-accent">Academic Preferences</h3>
                        </div>
                        <dl class="space-y-3 text-sm">
                            <div>
                                <dt class="text-xs text-gray-500 uppercase tracking-wide">Preferred Track</dt>
                                <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->preferred_track ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500 uppercase tracking-wide">Preferred Strand</dt>
                                <dd class="font-medium text-gray-800 mt-0.5">{{ $sp?->preferred_strand ?? '—' }}</dd>
                            </div>
                            @if($sp?->modality)
                                <div>
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">Modality</dt>
                                    <dd class="font-medium text-gray-800 mt-0.5">
                                        @foreach((array) $sp->modality as $mod)
                                            <span class="badge badge-ghost badge-sm">{{ $mod }}</span>
                                        @endforeach
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                @endif

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

            {{-- Assign Subjects --}}
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <div class="flex items-center gap-2 mb-5">
                    <i class="fi fi-rr-book-alt text-accent"></i>
                    <h3 class="font-bold text-accent">Assign Subjects</h3>
                    @if($gradeLevel)
                        <span class="badge badge-accent badge-sm ml-2">{{ $gradeLevel }}</span>
                    @endif
                </div>

                @if($availableClassrooms->count())
                    <form action="{{ route('admin.users.students.classrooms-assign', $student->id) }}" method="POST">
                        @csrf
                        <p class="text-sm text-gray-500 mb-3">Select classrooms to assign to this student:</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-4">
                            @foreach($availableClassrooms as $classroom)
                                <label class="flex items-start gap-3 p-3 rounded-lg border border-base-200 hover:bg-base-200 cursor-pointer">
                                    <input type="checkbox" name="classroom_ids[]" value="{{ $classroom->id }}"
                                           class="checkbox checkbox-accent checkbox-sm mt-0.5 shrink-0">
                                    <div class="text-sm min-w-0">
                                        <p class="font-semibold text-gray-800 truncate">{{ $classroom->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $classroom->subject?->name ?? '—' }}</p>
                                        <p class="text-xs text-gray-400">{{ $classroom->teacher?->name ?? 'No teacher' }}</p>
                                        <p class="text-xs text-gray-400">{{ $classroom->academicYear?->name ?? '' }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn btn-sm gap-2 text-white"
                                    style="background-color:#3277C5;border-color:#3277C5;">
                                <i class="fi fi-rr-plus text-white"></i>
                                Assign Selected
                            </button>
                        </div>
                    </form>
                @elseif(!$gradeLevel)
                    <div class="text-center py-8 text-gray-400">
                        <i class="fi fi-rr-book-alt block text-3xl mb-2"></i>
                        <p class="text-sm">No grade level on record. Cannot suggest classrooms.</p>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <i class="fi fi-rr-check block text-3xl mb-2"></i>
                        <p class="text-sm">All available classrooms for <strong>{{ $gradeLevel }}</strong> are already assigned.</p>
                    </div>
                @endif
            </div>

            {{-- Enrolled Classrooms --}}
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <i class="fi fi-rr-chalkboard-user text-accent"></i>
                        <h3 class="font-bold text-accent">Enrolled Classrooms</h3>
                        <span class="badge badge-ghost badge-sm">
                            {{ $student->asStudentClassrooms->count() }}
                        </span>
                        <a href="{{ route('admin.users.students.classrooms-print', $student->id) }}"
                           target="_blank"
                           class="btn btn-sm gap-2 text-white ml-auto"
                           style="background-color:#3277C5;border-color:#3277C5;">
                            <i class="fi fi-rr-print text-white"></i>
                            <span class="hidden sm:inline">Generate PDF</span>
                        </a>
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
                                        <th></th>
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
                                            <td>
                                                <form action="{{ route('admin.users.students.classrooms-remove', [$student->id, $room->id]) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Remove this classroom from student?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-ghost btn-xs text-error">
                                                        <i class="fi fi-rr-cross text-sm"></i>
                                                    </button>
                                                </form>
                                            </td>
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

        {{-- Payment History --}}
        @php
            $allPayments     = $student->payments->sortByDesc('created_at');
            $totalPaid       = $allPayments->where('status', 'approved')->sum('amount');
            $paymentsByMonth = $allPayments->sortBy('created_at')
                ->groupBy(fn($p) => \Carbon\Carbon::parse($p->created_at)->format('M Y'));
            $paymentLabels   = $paymentsByMonth->keys()->toArray();
            $paymentAmounts  = $paymentsByMonth->map(fn($g) => round($g->sum('amount'), 2))->values()->toArray();
        @endphp

        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-money-bill-wave text-accent"></i>
                <h3 class="font-bold text-accent">Payment History</h3>
                <span class="badge badge-ghost badge-sm ml-auto">{{ $allPayments->count() }}</span>
            </div>

            @if($allPayments->count())

                {{-- Summary --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6 text-center">
                    <div class="bg-base-200 rounded-lg p-3">
                        <p class="text-xl font-bold text-gray-800">{{ $allPayments->count() }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Transactions</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3">
                        <p class="text-xl font-bold text-green-600">{{ $allPayments->where('status', 'approved')->count() }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Approved</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-3">
                        <p class="text-xl font-bold text-yellow-500">{{ $allPayments->where('status', 'pending')->count() }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Pending</p>
                    </div>
                    <div class="bg-accent/10 rounded-lg p-3">
                        <p class="text-xl font-bold text-accent">₱{{ number_format($totalPaid, 2) }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">Total Paid</p>
                    </div>
                </div>

                {{-- Line Chart --}}
                @if(count($paymentLabels))
                    <div class="mb-6 pb-6 border-b border-base-200">
                        <x-charts.bar-chart
                            chartId="paymentHistory"
                            type="bar"
                            :labels="$paymentLabels"
                            :datasets="[[
                                'label'           => 'Amount (₱)',
                                'data'            => $paymentAmounts,
                                'backgroundColor' => 'rgba(5,150,105,0.7)',
                                'borderColor'     => '#059669',
                                'borderWidth'     => 1,
                                'borderRadius'    => 4,
                            ]]"
                            :options="[
                                'plugins' => ['legend' => ['display' => false]],
                                'scales'  => ['y' => ['beginAtZero' => true]],
                            ]"
                            height="260px"
                        />
                    </div>
                @endif

                {{-- Desktop Table --}}
                <div class="hidden sm:block overflow-x-auto rounded-lg border border-base-200">
                    <table class="table table-zebra w-full text-sm">
                        <thead>
                            <tr class="bg-base-200 text-gray-600 uppercase text-xs tracking-wide">
                                <th>#</th>
                                <th>Date</th>
                                 <th>Account / Channel</th>
                                <th>Method</th>
                                <th class="text-right">Amount</th>
                                <th>Note</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allPayments as $i => $payment)
                                <tr class="hover">
                                    <td class="text-gray-400">{{ $i + 1 }}</td>
                                    <td class="text-xs text-gray-500 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($payment->created_at)->format('M d, Y') }}
                                    </td>
                                    <td>{{ $payment->paymentAccount?->account_name ?? '—' }} / {{ $payment->paymentAccount?->account_number ?? '-' }}</td>
                                    <td class="capitalize">{{ $payment->payment_method ?? '—' }}</td>
                                    <td class="text-right font-semibold">₱{{ number_format($payment->amount, 2) }}</td>
                                    <td class="text-xs text-gray-500 max-w-xs truncate">{{ $payment->note ?? '—' }}</td>
                                    <td>
                                        @php
                                            $cls = match($payment->status) {
                                                'approved' => 'badge-success',
                                                'pending'  => 'badge-warning',
                                                'rejected' => 'badge-error',
                                                default    => 'badge-ghost',
                                            };
                                        @endphp
                                        <span class="badge badge-sm {{ $cls }}">{{ ucfirst($payment->status) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-base-300 font-semibold text-sm">
                                <td colspan="4" class="py-3 text-right">Total Approved:</td>
                                <td class="py-3 text-right text-green-600">₱{{ number_format($totalPaid, 2) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="block sm:hidden space-y-3">
                    @foreach($allPayments as $payment)
                        <div class="rounded-lg border border-base-200 p-4 space-y-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">{{ $payment->paymentAccount?->name ?? '—' }}</p>
                                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($payment->created_at)->format('M d, Y') }}</p>
                                </div>
                                @php
                                    $cls = match($payment->status) {
                                        'approved' => 'badge-success',
                                        'pending'  => 'badge-warning',
                                        'rejected' => 'badge-error',
                                        default    => 'badge-ghost',
                                    };
                                @endphp
                                <span class="badge badge-sm {{ $cls }}">{{ ucfirst($payment->status) }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                <div>
                                    <span class="text-gray-400">Method</span>
                                    <p class="font-medium capitalize">{{ $payment->payment_method ?? '—' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400">Amount</span>
                                    <p class="font-bold text-gray-800">₱{{ number_format($payment->amount, 2) }}</p>
                                </div>
                                @if($payment->note)
                                    <div class="col-span-2">
                                        <span class="text-gray-400">Note</span>
                                        <p class="font-medium">{{ $payment->note }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="text-center py-12 text-gray-400">
                    <i class="fi fi-rr-money-bill-wave block text-3xl mb-2"></i>
                    <p class="text-sm">No payment records found.</p>
                </div>
            @endif
        </div>

    </div>
</x-dashboard.admin.base>
