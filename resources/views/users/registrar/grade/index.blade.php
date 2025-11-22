<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Student Grades')" />
    <x-notification-message />

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <!-- Filters Section -->
        <div class="mb-6">
            <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-4">
                <!-- Academic Year Filter -->
                <div class="form-control w-full sm:w-auto">
                    <label class="label">
                        <span class="label-text font-medium">Academic Year</span>
                    </label>
                    <select name="academic_year"
                            onchange="this.form.submit()"
                            class="select select-bordered w-full sm:w-auto">
                        <option value="">{{ __('All Academic Years') }}</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}"
                                    {{ request('academic_year') == $year->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Clear Filters -->
                @if(request('academic_year'))
                    <div class="form-control w-full sm:w-auto">
                        <label class="label">
                            <span class="label-text font-medium opacity-0">Clear</span>
                        </label>
                        <a href="{{ route('registrar.grades.index') }}"
                           class="btn btn-ghost btn-sm w-full sm:w-auto">
                            <i class="fi fi-rr-refresh mr-2"></i>
                            Clear Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Students Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($students as $student)
                <div class="card bg-base-100 shadow-xl flex flex-col">
                    <div class="card-body flex-1">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="avatar placeholder">
                                <div class="bg-accent text-white rounded-full w-12 h-12 flex items-center justify-center text-xl">
                                    {{ substr($student?->name ?? 'N/A', 0, 1) }}
                                </div>
                            </div>
                            <div class="min-w-0">
                                <h2 class="card-title truncate">{{ $student?->name ?? 'N/A' }}</h2>
                                <p class="text-sm text-gray-600 truncate">LRN: {{ $student?->studentProfile?->lrn ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Academic Records -->
                        <div class="space-y-3">
                            @forelse($student?->studentProfile?->academicRecords()->with(['academicYear', 'grades'])->get() as $record)
                                <div class="bg-base-200 p-4 rounded-lg">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 gap-3">
                                        <div>
                                            <h3 class="font-medium">Grade {{ $record?->grade_level ?? 'N/A' }}</h3>
                                            <p class="text-sm text-gray-600">{{ $record?->academicYear?->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="flex items-center justify-between sm:justify-end gap-3 mt-3 sm:mt-0">
                                            <div class="text-right">
                                                <span class="font-bold text-accent">{{ number_format($record->average, 1) }}%</span>
                                                <div class="text-xs text-gray-500">Average</div>
                                            </div>

                                            <!-- Desktop: modal trigger -->
                                            <button class="btn btn-xs btn-ghost hidden md:inline-flex"
                                                    onclick="document.getElementById('grades_modal_{{ $record->id }}').showModal()">
                                                View Grades
                                            </button>

                                            <!-- Mobile: collapsible -->
                                            <details class="md:hidden">
                                                <summary class="text-sm btn btn-xs btn-ghost w-full text-left">View Grades</summary>
                                                <div class="mt-3 overflow-x-auto">
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
                                                                    <td class="truncate">{{ $grade->subject }}</td>
                                                                    <td class="text-right font-medium">{{ number_format($grade->grade, 1) }}</td>
                                                                    <td class="text-right">
                                                                        <span class="badge {{ $grade->grade >= 75 ? 'badge-success' : 'badge-error' }}">
                                                                            {{ $grade->remarks }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="font-medium">Average</td>
                                                                <td class="text-right font-bold text-accent" colspan="2">
                                                                    {{ number_format($record->average, 1) }}%
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </details>

                                            <!-- Keep a consistent button on mobile for layout -->
                                            <button class="btn btn-xs btn-ghost w-full sm:hidden mt-2" onclick="document.getElementById('grades_modal_{{ $record->id }}').showModal()">Open</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Grades Modal (desktop/tablet) -->
                                <dialog id="grades_modal_{{ $record->id }}" class="modal">
                                    <div class="modal-box max-w-3xl w-full">
                                        <form method="dialog">
                                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                        </form>
                                        <h3 class="font-bold text-lg mb-4">
                                            Grade {{ $record->grade_level }} - {{ $record->academicYear->name }}
                                        </h3>

                                        <div class="overflow-x-auto">
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
                                                            <td class="truncate">{{ $grade->subject }}</td>
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
                                                <tfoot>
                                                    <tr>
                                                        <td class="font-medium">Average</td>
                                                        <td class="text-right font-bold text-accent" colspan="2">
                                                            {{ number_format($record->average, 1) }}%
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <form method="dialog" class="modal-backdrop">
                                        <button>close</button>
                                    </form>
                                </dialog>
                            @empty
                                <div class="text-center text-gray-500 py-4">
                                    No academic records found
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- <div class="card-actions mt-4">
                        <a href="{{ route('registrar.grades.student', $student->id ?? 0) }}" class="btn btn-sm btn-outline w-full sm:w-auto">
                            View Student
                        </a>
                    </div> --}}
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center p-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <div class="w-16 h-16 mb-4 text-gray-400">
                        <i class="fi fi-rr-users text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No Students Found</h3>
                    <p class="text-sm text-gray-500 text-center mt-1">Try adjusting your filters</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $students->links() }}
        </div>
    </div>
</x-dashboard.registrar.base>
