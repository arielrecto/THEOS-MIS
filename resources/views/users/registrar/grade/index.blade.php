<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Student Grades')" />
    <x-notification-message />

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <!-- Filters Section -->
        <div class="mb-6">
            <form method="GET" class="flex flex-wrap gap-4">
                <!-- Academic Year Filter -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Academic Year</span>
                    </label>
                    <select name="academic_year"
                            onchange="this.form.submit()"
                            class="select select-bordered min-w-[200px]">
                        <option value="">All Academic Years</option>
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
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium opacity-0">Clear</span>
                        </label>
                        <a href="{{ route('registrar.grades.index') }}"
                           class="btn btn-ghost btn-sm">
                            <i class="fi fi-rr-refresh mr-2"></i>
                            Clear Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Students Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($students as $student)
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="avatar placeholder">
                                <div class="bg-accent text-white rounded-full w-12">
                                    <span class="text-xl">{{ substr($student->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div>
                                <h2 class="card-title">{{ $student->name }}</h2>
                                <p class="text-sm text-gray-600">LRN: {{ $student->studentProfile->lrn }}</p>
                            </div>
                        </div>

                        <!-- Academic Records -->
                        <div class="space-y-3">
                            @forelse($student->studentProfile->academicRecords()->with(['academicYear', 'grades'])->get() as $record)
                                <div class="bg-base-200 p-4 rounded-lg">
                                    <div class="flex justify-between items-center mb-2">
                                        <div>
                                            <h3 class="font-medium">Grade {{ $record->grade_level }}</h3>
                                            <p class="text-sm text-gray-600">{{ $record->academicYear->name }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="font-bold text-accent">{{ number_format($record->average, 1) }}%</span>
                                            <div class="text-xs text-gray-500">Average</div>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="badge badge-sm">
                                            {{ $record->grades->count() }} subjects
                                        </span>
                                        <button class="btn btn-xs btn-ghost"
                                                onclick="grades_modal_{{ $record->id }}.showModal()">
                                            View Grades
                                        </button>
                                    </div>
                                </div>

                                <!-- Grades Modal -->
                                <dialog id="grades_modal_{{ $record->id }}" class="modal">
                                    <div class="modal-box">
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
