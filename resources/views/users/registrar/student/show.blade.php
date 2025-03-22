<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Student Record')" :back_url="route('registrar.students.index')" />
    <x-notification-message />

    <!-- Student Profile Header -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-start gap-6">
            <div class="avatar">
                <div class="w-24 h-24 rounded-full ring-2 ring-accent ring-offset-2">
                    <img src="{{ $student->studentProfile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}"
                         alt="Profile Photo">
                </div>
            </div>
            <div class="flex-1">
                <div class="flex justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $student->name }}</h2>
                        <p class="text-gray-600">LRN: {{ $student->studentProfile->lrn }}</p>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('registrar.students.good-moral', $student->id) }}"
                           target="_blank"
                           class="btn btn-outline btn-accent">
                            <i class="fi fi-rr-diploma mr-2"></i>
                            Good Moral Certificate
                        </a>
                        <a href="{{ route('registrar.students.form-137', $student->id) }}"
                           target="_blank"
                           class="btn btn-outline btn-accent">
                            <i class="fi fi-rr-document mr-2"></i>
                            Form 137
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <!-- Student Information -->
        <div class="col-span-12 md:col-span-4">
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Personal Information</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                                <p class="mt-1">{{ $student->studentProfile->birthdate }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Contact</p>
                                <p class="mt-1">{{ $student->studentProfile->contact_number }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Address</p>
                            <p class="mt-1">{{ $student->studentProfile->address }}</p>
                        </div>
                        <div class="pt-4 border-t">
                            <p class="text-sm font-medium text-gray-500">Parent/Guardian</p>
                            <p class="mt-1 font-medium">{{ $student->studentProfile->parent_name }}</p>
                            <p class="text-sm text-gray-500">{{ $student->studentProfile->relationship }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Records -->
        <div class="col-span-12 md:col-span-8">
            <div class="bg-white rounded-lg shadow-lg">
                <!-- Filter Section -->
                <div class="p-4 border-b">
                    <form method="GET" class="flex items-center gap-4">
                        <div class="form-control flex-1">
                            <select name="academic_year"
                                    onchange="this.form.submit()"
                                    class="select select-bordered w-full max-w-xs">
                                <option value="">All Academic Years</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}"
                                            {{ request('academic_year') == $year->id ? 'selected' : '' }}>
                                        {{ $year->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if(request('academic_year'))
                            <a href="{{ route('registrar.students.show', $student->id) }}"
                               class="btn btn-ghost btn-sm">
                                <i class="fi fi-rr-refresh mr-2"></i>
                                Clear
                            </a>
                        @endif
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

                    @forelse($student->studentProfile->academicRecords as $record)
                        <div class="mb-8 last:mb-0">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h4 class="text-lg font-medium">Grade {{ $record->grade_level }}</h4>
                                    <p class="text-sm text-gray-600">{{ $record->academicYear->name }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <span class="text-2xl font-bold {{ $record->average >= 75 ? 'text-success' : 'text-error' }}">
                                            {{ number_format($record->average, 1) }}%
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
                                        @foreach($record->grades as $grade)
                                            <tr>
                                                <td>{{ $grade->subject }}</td>
                                                <td class="text-right font-medium">
                                                    {{ number_format($grade->grade, 1) }}
                                                </td>
                                                <td class="text-right">
                                                    <span class="badge {{ $grade->grade >= 75 ? 'badge-success' : 'badge-error' }}">
                                                        {{ $grade->remarks }}
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
            </div>
        </div>
    </div>
</x-dashboard.registrar.base>
