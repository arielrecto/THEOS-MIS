<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report Card</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet">
    <style>
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none;
            }
            .page-break {
                page-break-after: always;
            }
            .school-logo {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
        .report-card {
            max-width: 8.5in;
            margin: 0 auto;
            padding: 1in 0.5in;
        }
        .school-header {
            text-align: center;
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        .grades-table th,
        .grades-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .grades-table th {
            background-color: #f5f5f5;
        }
        .signature-section {
            margin-top: 2rem;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin-top: 1.5rem;
            text-align: center;
        }
        .school-logo {
            width: 80px;
            height: auto;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print fixed top-4 right-4 flex gap-2">
        <a href="{{ route('registrar.students.show', $student->id) }}" class="btn btn-ghost">
            <i class="fi fi-rr-arrow-left mr-2"></i>
            Back
        </a>
        <button onclick="window.print()" class="btn btn-accent">
            <i class="fi fi-rr-print mr-2"></i>
            Print Report Card
        </button>
    </div>

    <div class="report-card">
        <!-- School Header -->
        <div class="school-header">
            <img src="{{ asset('logo-modified.png') }}"
                 alt="Theos Higher Ground Academe Logo"
                 class="school-logo">
            <h1 class="text-xl font-bold">Theos Higher Ground Academe</h1>
            <p>Daang Amaya III, Tanza, Cavite</p>
            <h2 class="text-lg font-bold mt-4">STUDENT REPORT CARD</h2>
            <p class="text-sm">Academic Year {{ $academicRecord->academicYear->name }}</p>
        </div>

        <!-- Student Information -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p><strong>Student Name:</strong> {{ $student->name }}</p>
                <p><strong>LRN:</strong> {{ $student->studentProfile->lrn }}</p>
            </div>
            <div>
                <p><strong>Grade Level:</strong> {{ $academicRecord->grade_level }}</p>
                <p><strong>School Year:</strong> {{ $academicRecord->school_year }}</p>
            </div>
        </div>

        <!-- Grades Table -->
        <table class="grades-table">
            <thead>
                <tr>
                    <th rowspan="2">LEARNING AREAS</th>
                    <th colspan="4">QUARTER</th>
                    <th rowspan="2">FINAL<br>GRADE</th>
                    <th rowspan="2">REMARKS</th>
                </tr>
                <tr>
                    <th>1st</th>
                    <th>2nd</th>
                    <th>3rd</th>
                    <th>4th</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subjects = $academicRecord->grades->groupBy('subject');
                @endphp

                @foreach($subjects as $subject => $grades)
                    <tr>
                        <td>{{ $subject }}</td>
                        @php
                            $quarterGrades = [
                                'Q1' => $grades->firstWhere('quarter', 'Q1')?->grade ?? '-',
                                'Q2' => $grades->firstWhere('quarter', 'Q2')?->grade ?? '-',
                                'Q3' => $grades->firstWhere('quarter', 'Q3')?->grade ?? '-',
                                'Q4' => $grades->firstWhere('quarter', 'Q4')?->grade ?? '-'
                            ];
                            $finalGrade = $grades->avg('grade');
                        @endphp

                        @foreach($quarterGrades as $grade)
                            <td class="text-center">{{ is_numeric($grade) ? number_format($grade, 1) : $grade }}</td>
                        @endforeach

                        <td class="text-center font-bold">
                            {{ number_format($finalGrade, 1) }}
                        </td>
                        <td class="text-center">
                            @if($finalGrade >= 75)
                                <span class="text-success">Passed</span>
                            @else
                                <span class="text-error">Failed</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-bold">
                    <td>General Average</td>
                    <td colspan="4"></td>
                    <td class="text-center">{{ number_format($academicRecord->average, 1) }}</td>
                    <td class="text-center">
                        @if($academicRecord->average >= 75)
                            <span class="text-success">Passed</span>
                        @else
                            <span class="text-error">Failed</span>
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Attendance Summary -->
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
                        @for($i = 0; $i < 13; $i++)
                            <td class="text-center">-</td>
                        @endfor
                    </tr>
                    <tr>
                        <td>Days Present</td>
                        @for($i = 0; $i < 13; $i++)
                            <td class="text-center">-</td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Signature Section -->
        <div class="signature-section grid grid-cols-2 gap-8 mt-16">
            <div>
                <div class="signature-line">
                    <p class="font-bold">Class Adviser</p>
                </div>
            </div>
            <div>
                <div class="signature-line">
                    <p class="font-bold">Principal</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
