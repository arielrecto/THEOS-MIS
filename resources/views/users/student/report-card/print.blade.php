<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report Card</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet">
    <style>
        @media print {
            body { padding: 0; margin: 0; }
            .no-print { display: none; }
            .school-logo { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
        }
        .report-card { max-width: 8.5in; margin: 0 auto; padding: 1in 0.5in; }
        .school-header { text-align: center; margin-bottom: 2rem; }
        .grades-table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        .grades-table th, .grades-table td { border: 1px solid #ddd; padding: 8px; }
        .grades-table th { background-color: #f5f5f5; }
        .signature-section { margin-top: 2rem; }
        .signature-line { width: 200px; border-top: 1px solid #000; margin-top: 1.5rem; text-align: center; }
    </style>
</head>
<body>
    <div class="no-print fixed top-4 right-4 flex gap-2">
        <a href="{{ route('student.report-card.index', ['academic_record_id' => $academicRecord->id]) }}" class="btn btn-ghost btn-sm">
            <i class="fi fi-rr-arrow-left mr-2"></i> Back
        </a>
        <button onclick="window.print()" class="btn btn-accent btn-sm">
            <i class="fi fi-rr-print mr-2"></i> Print
        </button>
    </div>

    <div class="report-card">
        <div class="school-header" style="text-align:center;">
            <img src="/logo-3.png" alt="Theos Higher Ground Academe" style="max-height:200px; display:block; margin:0 auto;">
            <h2 class="text-lg font-bold mt-4">STUDENT REPORT CARD</h2>
            <p class="text-sm">Academic Year {{ $academicRecord->academicYear->name }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p><strong>Student Name:</strong> {{ $student->name }}</p>
                <p><strong>LRN:</strong> {{ $student->studentProfile->lrn }}</p>
            </div>
            <div>
                <p><strong>Grade Level:</strong> {{ $academicRecord->grade_level }}</p>
                <p><strong>School Year:</strong> {{ $academicRecord->school_year ?? $academicRecord->academicYear->name }}</p>
            </div>
        </div>

        <table class="grades-table">
            <thead>
                <tr>
                    <th rowspan="2">LEARNING AREAS</th>
                    <th colspan="4">QUARTER</th>
                    <th rowspan="2">FINAL<br>GRADE</th>
                    <th rowspan="2">REMARKS</th>
                </tr>
                <tr>
                    <th>1st</th><th>2nd</th><th>3rd</th><th>4th</th>
                </tr>
            </thead>
            <tbody>
                @php $subjects = $academicRecord->grades->groupBy('subject'); @endphp
                @foreach($subjects as $subject => $grades)
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
                        <td>{{ $subject }}</td>
                        @foreach($quarterGrades as $grade)
                            <td class="text-center">{{ is_numeric($grade) ? number_format($grade, 1) : $grade }}</td>
                        @endforeach
                        <td class="text-center font-bold">{{ number_format($finalGrade, 1) }}</td>
                        <td class="text-center">
                            @if($finalGrade >= 75)
                                <span style="color:green">Passed</span>
                            @else
                                <span style="color:red">Failed</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-bold">
                    <td>General Average</td>
                    <td colspan="4"></td>
                    <td class="text-center">{{ $academicRecord->average ? number_format($academicRecord->average, 1) : '-' }}</td>
                    <td class="text-center">
                        @if($academicRecord->average)
                            @if($academicRecord->average >= 75)
                                <span style="color:green">Passed</span>
                            @else
                                <span style="color:red">Failed</span>
                            @endif
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-8">
            <h3 class="font-bold mb-2">ATTENDANCE RECORD</h3>
            <table class="grades-table">
                <thead>
                    <tr>
                        <th></th>
                        @foreach(['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May'] as $month)
                            <th>{{ $month }}</th>
                        @endforeach
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Days of School</td>
                        @foreach($daysOfSchool as $val)
                            <td class="text-center">{{ $val }}</td>
                        @endforeach
                        <td class="text-center font-bold">{{ $totalSchool ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Days Present</td>
                        @foreach($daysPresent as $val)
                            <td class="text-center">{{ $val }}</td>
                        @endforeach
                        <td class="text-center font-bold">{{ $totalPresent ?: '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="display:flex; justify-content:center; gap:5rem; margin-top:4rem;">
            <div style="text-align:center;">
                <div style="width:200px; border-top:1px solid #000; padding-top:0.5rem;">
                    <p class="font-bold">Class Adviser</p>
                </div>
            </div>
            <div style="text-align:center;">
                <div style="width:200px; border-top:1px solid #000; padding-top:0.5rem;">
                    <p class="font-bold">Principal</p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="font-bold mb-2">REPORT ON LEARNER'S OBSERVED VALUES</h3>
            <table class="grades-table">
                <thead>
                    <tr>
                        <th>Core Value</th>
                        <th>Behavior Statement</th>
                        <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coreValues as $core => $statements)
                        @foreach($statements as $statement)
                            @php $rec = $coreValueRecords[$core][$statement] ?? null; @endphp
                            <tr>
                                <td>{{ $core }}</td>
                                <td>{{ $statement }}</td>
                                <td class="text-center">{{ $rec->quarter_1 ?? '-' }}</td>
                                <td class="text-center">{{ $rec->quarter_2 ?? '-' }}</td>
                                <td class="text-center">{{ $rec->quarter_3 ?? '-' }}</td>
                                <td class="text-center">{{ $rec->quarter_4 ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <div class="text-xs mt-2">
                <strong>Marking:</strong> AO - Always Observed, SO - Sometimes Observed, RO - Rarely Observed, NO - Not Observed
            </div>
        </div>
    </div>
</body>
</html>
