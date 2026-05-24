<x-dashboard.student.base>
    <div class="container max-w-7xl px-4 sm:px-6 lg:px-8 py-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-700">My Report Card</h1>

            @if($selectedRecord)
                <a href="{{ route('student.report-card.print', $selectedRecord->id) }}"
                   class="btn btn-accent btn-sm gap-2 no-print">
                    <i class="fi fi-rr-print"></i>
                    Print Report Card
                </a>
            @endif
        </div>

        {{-- Academic Year Selector --}}
        @if($academicRecords->count() > 0)
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <form method="GET" action="{{ route('student.report-card.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-medium">School Year</span></label>
                        <select name="academic_record_id" class="text-xs select select-bordered select-sm" onchange="this.form.submit()">
                            @foreach($academicRecords as $record)
                                <option value="{{ $record->id }}" @selected($selectedRecord?->id === $record->id)>
                                    {{ $record->academicYear->name }} — Grade {{ $record->grade_level }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        @endif

        @if(!$selectedRecord)
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <i class="fi fi-rr-document text-4xl text-gray-300"></i>
                <p class="mt-4 text-gray-500">No academic records found. Please contact the registrar.</p>
            </div>
        @else
            {{-- Report Card --}}
            <div class="bg-white rounded-lg shadow-sm p-6 space-y-8">

                {{-- School Header --}}
                <div class="text-center">
                    <img src="/logo-3.png" alt="Theos Higher Ground Academe" class="mx-auto mb-2" style="max-height:80px;">
                    <h2 class="text-lg font-bold">STUDENT REPORT CARD</h2>
                    <p class="text-sm text-gray-500">Academic Year {{ $selectedRecord->academicYear->name }}</p>
                </div>

                {{-- Student Info --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-1">
                        <p><span class="font-semibold">Student Name:</span> {{ $student->name }}</p>
                        <p><span class="font-semibold">LRN:</span> {{ $student->studentProfile->lrn }}</p>
                    </div>
                    <div class="space-y-1">
                        <p><span class="font-semibold">Grade Level:</span> {{ $selectedRecord->grade_level }}</p>
                        <p><span class="font-semibold">School Year:</span> {{ $selectedRecord->school_year ?? $selectedRecord->academicYear->name }}</p>
                    </div>
                </div>

                {{-- Grades Table --}}
                <div>
                    <h3 class="font-bold text-gray-700 mb-3">ACADEMIC PERFORMANCE</h3>
                    <div class="overflow-x-auto">
                        <table class="table table-xs border border-base-300 w-full text-sm">
                            <thead>
                                <tr class="bg-base-200">
                                    <th rowspan="2" class="border border-base-300 align-middle">Learning Areas</th>
                                    <th colspan="4" class="border border-base-300 text-center">Quarter</th>
                                    <th rowspan="2" class="border border-base-300 text-center align-middle">Final Grade</th>
                                    <th rowspan="2" class="border border-base-300 text-center align-middle">Remarks</th>
                                </tr>
                                <tr class="bg-base-200">
                                    <th class="border border-base-300 text-center">1st</th>
                                    <th class="border border-base-300 text-center">2nd</th>
                                    <th class="border border-base-300 text-center">3rd</th>
                                    <th class="border border-base-300 text-center">4th</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $subjects = $selectedRecord->grades->groupBy('subject'); @endphp
                                @forelse($subjects as $subject => $grades)
                                    @php
                                        $quarterGrades = [
                                            'Q1' => $grades->firstWhere('quarter', 'Q1')?->grade ?? '-',
                                            'Q2' => $grades->firstWhere('quarter', 'Q2')?->grade ?? '-',
                                            'Q3' => $grades->firstWhere('quarter', 'Q3')?->grade ?? '-',
                                            'Q4' => $grades->firstWhere('quarter', 'Q4')?->grade ?? '-',
                                        ];
                                        $finalGrade = $grades->avg('grade');
                                    @endphp
                                    <tr>
                                        <td class="border border-base-300">{{ $subject }}</td>
                                        @foreach($quarterGrades as $grade)
                                            <td class="border border-base-300 text-center">
                                                {{ is_numeric($grade) ? number_format($grade, 1) : $grade }}
                                            </td>
                                        @endforeach
                                        <td class="border border-base-300 text-center font-bold">
                                            {{ number_format($finalGrade, 1) }}
                                        </td>
                                        <td class="border border-base-300 text-center">
                                            @if($finalGrade >= 75)
                                                <span class="text-success font-semibold">Passed</span>
                                            @else
                                                <span class="text-error font-semibold">Failed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-gray-400 py-4">No grades recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="font-bold bg-base-200">
                                    <td class="border border-base-300">General Average</td>
                                    <td colspan="4" class="border border-base-300"></td>
                                    <td class="border border-base-300 text-center">
                                        {{ $selectedRecord->average ? number_format($selectedRecord->average, 1) : '-' }}
                                    </td>
                                    <td class="border border-base-300 text-center">
                                        @if($selectedRecord->average)
                                            @if($selectedRecord->average >= 75)
                                                <span class="text-success">Passed</span>
                                            @else
                                                <span class="text-error">Failed</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Attendance --}}
                <div>
                    <h3 class="font-bold text-gray-700 mb-3">ATTENDANCE RECORD</h3>
                    <div class="overflow-x-auto">
                        <table class="table table-xs border border-base-300 w-full text-sm">
                            <thead>
                                <tr class="bg-base-200">
                                    <th class="border border-base-300"></th>
                                    @foreach(['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May'] as $month)
                                        <th class="border border-base-300 text-center">{{ $month }}</th>
                                    @endforeach
                                    <th class="border border-base-300 text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-base-300">Days of School</td>
                                    @foreach($daysOfSchool as $val)
                                        <td class="border border-base-300 text-center">{{ $val }}</td>
                                    @endforeach
                                    <td class="border border-base-300 text-center font-bold">{{ $totalSchool ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-base-300">Days Present</td>
                                    @foreach($daysPresent as $val)
                                        <td class="border border-base-300 text-center">{{ $val }}</td>
                                    @endforeach
                                    <td class="border border-base-300 text-center font-bold">{{ $totalPresent ?: '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Core Values --}}
                @if(!empty($coreValues))
                    <div>
                        <h3 class="font-bold text-gray-700 mb-3">REPORT ON LEARNER'S OBSERVED VALUES</h3>
                        <div class="overflow-x-auto">
                            <table class="table table-xs border border-base-300 w-full text-sm">
                                <thead>
                                    <tr class="bg-base-200">
                                        <th class="border border-base-300">Core Value</th>
                                        <th class="border border-base-300">Behavior Statement</th>
                                        <th class="border border-base-300 text-center">Q1</th>
                                        <th class="border border-base-300 text-center">Q2</th>
                                        <th class="border border-base-300 text-center">Q3</th>
                                        <th class="border border-base-300 text-center">Q4</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coreValues as $core => $statements)
                                        @foreach($statements as $statement)
                                            @php $rec = $coreValueRecords[$core][$statement] ?? null; @endphp
                                            <tr>
                                                <td class="border border-base-300 font-medium">{{ $core }}</td>
                                                <td class="border border-base-300">{{ $statement }}</td>
                                                <td class="border border-base-300 text-center">{{ $rec->quarter_1 ?? '-' }}</td>
                                                <td class="border border-base-300 text-center">{{ $rec->quarter_2 ?? '-' }}</td>
                                                <td class="border border-base-300 text-center">{{ $rec->quarter_3 ?? '-' }}</td>
                                                <td class="border border-base-300 text-center">{{ $rec->quarter_4 ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            <strong>Marking:</strong> AO - Always Observed, SO - Sometimes Observed, RO - Rarely Observed, NO - Not Observed
                        </p>
                    </div>
                @endif

            </div>
        @endif

    </div>
</x-dashboard.student.base>
