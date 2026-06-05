<x-dashboard.student.base>
    <div class="container max-w-7xl px-4 sm:px-6 lg:px-8 py-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-700">My Report Card</h1>

            @if($selectedRecord && $isFullyPaid && !$selectedQuarter)
                <a href="{{ route('student.report-card.print', $selectedRecord->id) }}"
                   class="btn btn-accent btn-sm gap-2 no-print">
                    <i class="fi fi-rr-print"></i>
                    Print Report Card
                </a>
            @endif
        </div>

        {{-- Filters --}}
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

                    @if($isFullyPaid)
                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Quarter</span></label>
                            <select name="quarter" class="text-xs select select-bordered select-sm" onchange="this.form.submit()">
                                <option value="" @selected(!$selectedQuarter)>All Quarters</option>
                                <option value="Q1" @selected($selectedQuarter === 'Q1')>1st Quarter</option>
                                <option value="Q2" @selected($selectedQuarter === 'Q2')>2nd Quarter</option>
                                <option value="Q3" @selected($selectedQuarter === 'Q3')>3rd Quarter</option>
                                <option value="Q4" @selected($selectedQuarter === 'Q4')>4th Quarter</option>
                            </select>
                        </div>

                        @if($selectedQuarter)
                            <a href="{{ route('student.report-card.index', ['academic_record_id' => $selectedRecord?->id]) }}"
                               class="btn btn-ghost btn-sm self-end">
                                <i class="fi fi-rr-cross-small mr-1"></i> Clear
                            </a>
                        @endif
                    @endif
                </form>
            </div>
        @endif

        @if(!$selectedRecord)
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <i class="fi fi-rr-document text-4xl text-gray-300"></i>
                <p class="mt-4 text-gray-500">No academic records found. Please contact the registrar.</p>
            </div>
        @elseif($isPaid && !$gradesReleased)
            {{-- Paid but grades not yet released --}}
            <div class="alert alert-info shadow-sm">
                <i class="fi fi-rr-clock text-xl"></i>
                <div>
                    <h3 class="font-bold">Grades Not Yet Released</h3>
                    <p class="text-sm">Your tuition fee has been settled. Please wait for the registrar to release your grades.</p>
                </div>
            </div>
        @elseif(!$isFullyPaid)
            {{-- Payment Gate --}}
            <div class="space-y-4">

                {{-- Alert --}}
                <div class="alert alert-warning shadow-sm">
                    <i class="fi fi-rr-lock text-xl"></i>
                    <div>
                        <h3 class="font-bold">Report Card Locked</h3>
                        <p class="text-sm">Your report card is only available once your tuition fee is fully settled.</p>
                    </div>
                </div>

                {{-- Payment Summary --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-base font-bold text-gray-700 mb-4 flex items-center gap-2">
                        <i class="fi fi-rr-receipt"></i> Payment Summary
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <div class="bg-base-100 border border-base-300 rounded-lg p-4 text-center">
                            <p class="text-xs text-gray-500 mb-1">Total Due</p>
                            <p class="text-xl font-bold text-gray-800">₱{{ number_format($totalDue, 2) }}</p>
                        </div>
                        <div class="bg-success/10 border border-success/30 rounded-lg p-4 text-center">
                            <p class="text-xs text-gray-500 mb-1">Total Paid</p>
                            <p class="text-xl font-bold text-success">₱{{ number_format($totalPaid, 2) }}</p>
                        </div>
                        <div class="bg-error/10 border border-error/30 rounded-lg p-4 text-center">
                            <p class="text-xs text-gray-500 mb-1">Remaining Balance</p>
                            <p class="text-xl font-bold text-error">₱{{ number_format($balance, 2) }}</p>
                        </div>
                    </div>

                    @if($totalPending > 0)
                        <div class="alert alert-info alert-sm text-sm mb-4">
                            <i class="fi fi-rr-clock"></i>
                            <span>You have <strong>₱{{ number_format($totalPending, 2) }}</strong> in pending payments awaiting approval.</span>
                        </div>
                    @endif

                    {{-- Tuition Fee Breakdown --}}
                    @if($tuitionFees->count() > 0)
                        <h3 class="text-sm font-semibold text-gray-600 mb-3">Fee Breakdown</h3>
                        <div class="overflow-x-auto mb-6">
                            <table class="table table-xs w-full border border-base-300 text-sm">
                                <thead>
                                    <tr class="bg-base-200">
                                        <th class="border border-base-300">Fee Name</th>
                                        <th class="border border-base-300">Type</th>
                                        <th class="border border-base-300 text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tuitionFees as $fee)
                                        <tr>
                                            <td class="border border-base-300">{{ $fee->name }}</td>
                                            <td class="border border-base-300">
                                                <span class="badge badge-xs badge-ghost">
                                                    {{ $fee->is_monthly ? 'Monthly' : ($fee->is_onetime_fee ? 'One-time' : $fee->type) }}
                                                </span>
                                            </td>
                                            <td class="border border-base-300 text-right font-medium">₱{{ number_format($fee->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- Payment Accounts --}}
                    @if($paymentAccounts->count() > 0)
                        <h3 class="text-sm font-semibold text-gray-600 mb-3">How to Pay</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($paymentAccounts as $account)
                                <div class="border border-base-300 rounded-lg p-4 flex items-start gap-3">
                                    @if($account->qr_image_path)
                                        <img src="{{ asset($account->qr_image_path) }}" alt="QR Code" class="w-16 h-16 object-contain rounded">
                                    @else
                                        <div class="w-16 h-16 bg-base-200 rounded flex items-center justify-center">
                                            <i class="fi fi-rr-credit-card text-2xl text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-sm">{{ $account->provider }}</p>
                                        <p class="text-sm text-gray-600">{{ $account->account_name }}</p>
                                        <p class="text-xs text-gray-500 font-mono mt-1">{{ $account->account_number }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-4">After payment, go to <a href="{{ route('student.payments.index') }}" class="text-accent underline">Payments</a> to submit your proof of payment.</p>
                    @endif
                </div>
            </div>
        @else
            {{-- Report Card --}}
            <div class="bg-white rounded-lg shadow-sm p-6 space-y-8">

                {{-- School Header --}}
                <div class="text-center">
                    <img src="/logo-3.png" alt="Theos Higher Ground Academe" class="mx-auto mb-2" style="max-height:200px;">
                    <h2 class="text-lg font-bold">STUDENT REPORT CARD</h2>
                    <p class="text-sm text-gray-500">Academic Year {{ $selectedRecord->academicYear->name }}</p>
                </div>

                {{-- Student Info --}}
                <div class="flex justify-between items-start gap-4 text-sm">
                    <div class="space-y-1">
                        <p><span class="font-semibold">Student Name:</span> {{ $student->name }}</p>
                        <p><span class="font-semibold">LRN:</span> {{ $student->studentProfile->lrn }}</p>
                    </div>
                    <div class="space-y-1 text-right">
                        <p><span class="font-semibold">Grade Level:</span> {{ $selectedRecord->grade_level }}</p>
                        <p><span class="font-semibold">School Year:</span> {{ $selectedRecord->school_year ?? $selectedRecord->academicYear->name }}</p>
                    </div>
                </div>

                {{-- Grades Table --}}
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <h3 class="font-bold text-gray-700">ACADEMIC PERFORMANCE</h3>
                        @if($selectedQuarter)
                            @php $quarterLabels = ['Q1' => '1st Quarter', 'Q2' => '2nd Quarter', 'Q3' => '3rd Quarter', 'Q4' => '4th Quarter']; @endphp
                            <span class="badge badge-accent badge-sm">{{ $quarterLabels[$selectedQuarter] ?? $selectedQuarter }}</span>
                        @endif
                    </div>
                    <div class="overflow-x-auto">
                        @php $subjects = $selectedRecord->grades->groupBy('subject'); @endphp

                        @if($selectedQuarter)
                            {{-- Single-quarter view --}}
                            <table class="table table-xs border border-base-300 w-full text-sm">
                                <thead>
                                    <tr class="bg-base-200">
                                        <th class="border border-base-300">Learning Areas</th>
                                        <th class="border border-base-300 text-center">Grade</th>
                                        <th class="border border-base-300 text-center">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subjects as $subject => $grades)
                                        @php
                                            $qGrade = $grades->firstWhere('quarter', $selectedQuarter);
                                            $gradeVal = $qGrade?->grade;
                                        @endphp
                                        <tr>
                                            <td class="border border-base-300">{{ $subject }}</td>
                                            <td class="border border-base-300 text-center font-bold {{ $gradeVal !== null ? ($gradeVal >= 75 ? 'text-success' : 'text-error') : 'text-gray-400' }}">
                                                {{ $gradeVal !== null ? number_format($gradeVal, 1) : '—' }}
                                            </td>
                                            <td class="border border-base-300 text-center">
                                                @if($gradeVal !== null)
                                                    @if($gradeVal >= 75)
                                                        <span class="text-success font-semibold">Passed</span>
                                                    @else
                                                        <span class="text-error font-semibold">Failed</span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-gray-400 py-4">No grades recorded yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    @php
                                        $qAvg = $selectedRecord->grades->where('quarter', $selectedQuarter)->avg('grade');
                                    @endphp
                                    <tr class="font-bold bg-base-200">
                                        <td class="border border-base-300">Quarter Average</td>
                                        <td class="border border-base-300 text-center">
                                            {{ $qAvg ? number_format($qAvg, 1) : '—' }}
                                        </td>
                                        <td class="border border-base-300 text-center">
                                            @if($qAvg)
                                                @if($qAvg >= 75)
                                                    <span class="text-success">Passed</span>
                                                @else
                                                    <span class="text-error">Failed</span>
                                                @endif
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            {{-- All-quarters view --}}
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
                        @endif
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
