<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 137 - Permanent Academic Record</title>
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

            .header-section {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }

        .form-137 {
            max-width: 8.5in;
            margin: 0 auto;
            padding: 0.5in;
        }

        .header-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #000;
        }

        .header-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .header-center {
            flex: 1;
            text-align: center;
            padding: 0 1rem;
        }

        .header-center h3 {
            margin: 0;
            font-size: 11px;
            font-weight: normal;
            line-height: 1.3;
        }

        .header-center h1 {
            margin: 0.25rem 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header-center p {
            margin: 0;
            font-size: 10px;
            line-height: 1.3;
        }

        .form-title {
            text-align: center;
            margin: 2rem 0 1.5rem;
        }

        .form-title h2 {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 1px;
        }

        .form-title p {
            font-size: 14px;
            margin: 0.25rem 0 0 0;
        }

        .student-info {
            margin: 1.5rem 0;
            font-size: 13px;
        }

        .student-info p {
            margin: 0.5rem 0;
            line-height: 1.6;
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 12px;
        }

        .grades-table th,
        .grades-table td {
            border: 1px solid #333;
            padding: 8px;
        }

        .grades-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .grades-table td {
            text-align: left;
        }

        .grades-table td.text-center {
            text-align: center;
        }

        .grades-table tfoot {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .grade-year-header {
            font-weight: bold;
            margin: 2rem 0 0.5rem;
            font-size: 14px;
            padding: 0.5rem;
            background-color: #f0f0f0;
            border-left: 4px solid #000;
        }

        .certification-section {
            margin-top: 3rem;
            text-align: center;
        }

        .certification-section p {
            font-size: 13px;
            margin-bottom: 3rem;
        }

        .signature-section {
            display: flex;
            justify-content: space-around;
            margin-top: 4rem;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 2px solid #000;
            padding-top: 0.5rem;
            margin-top: 2rem;
        }

        .signature-line p {
            margin: 0.25rem 0;
            font-size: 12px;
        }

        .signature-line .name {
            font-weight: bold;
            font-size: 13px;
        }

        .signature-line .title {
            font-style: italic;
        }

        .footer-note {
            margin-top: 2rem;
            text-align: center;
            font-size: 10px;
            font-style: italic;
            color: #666;
        }
    </style>
</head>

<body>
    <!-- Print Button -->
    <div class="no-print fixed top-4 right-4 flex gap-2 z-50">
        <a href="{{ route('registrar.students.show', $student->id) }}" class="btn btn-ghost">
            <i class="fi fi-rr-arrow-left mr-2"></i>Back
        </a>
        <button onclick="window.print()" class="btn btn-accent">
            <i class="fi fi-rr-print mr-2"></i>Print Form 137
        </button>
    </div>

    <div class="form-137">
        <!-- Header Section -->
        <div class="header-section">
            <!-- Left Logo - Department of Education -->
            <div class="header-left">
                <img src="{{ asset('department_of_education.svg') }}"
                     alt="Department of Education Logo"
                     class="header-logo">
            </div>

            <!-- Center Text -->
            <div class="header-center">
                <h3>Republic of the Philippines</h3>
                <h3>Department of Education</h3>
                <h3>Region IV-A CALABARZON</h3>
                <h1>THEOS HIGHER GROUND ACADEME</h1>
                <p>Brgy. Biga 1, Imus City, Cavite</p>
            </div>

            <!-- Right Logo - School Logo -->
            <div class="header-right">
                <img src="{{ asset('logo-modified.png') }}"
                     alt="Theos Higher Ground Academe Logo"
                     class="header-logo">
            </div>
        </div>

        <!-- Form Title -->
        <div class="form-title">
            <h2>PERMANENT ACADEMIC RECORD</h2>
            <p>(Form 137)</p>
        </div>

        <!-- Student Information -->
        <div class="student-info">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p><strong>Student Name:</strong> {{ strtoupper($student->name) }}</p>
                    <p><strong>LRN:</strong> {{ $student->studentProfile?->lrn ?? 'N/A' }}</p>
                    <p><strong>Date of Birth:</strong> {{ $student->studentProfile?->birthdate ? \Carbon\Carbon::parse($student->studentProfile->birthdate)->format('F d, Y') : 'N/A' }}</p>
                </div>
                <div>
                    <p><strong>Address:</strong> {{ $student->studentProfile?->address ?? 'N/A' }}</p>
                    <p><strong>Parent/Guardian:</strong> {{ $student->studentProfile?->parent_name ?? 'N/A' }}</p>
                    <p><strong>Contact Number:</strong> {{ $student->studentProfile?->contact_number ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Academic Records -->
        @if (!$student->studentProfile?->academicRecords || $student->studentProfile->academicRecords->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500 text-lg">No academic records found.</p>
            </div>
        @else
            @foreach ($student->studentProfile->academicRecords as $record)
                <div class="{{ !$loop->last ? 'page-break' : '' }}">
                    <div class="grade-year-header">
                        Grade {{ $record->grade_level }} - School Year {{ $record->academicYear->name }}
                        @if($record->section)
                            - Section: {{ $record->section->name }}
                        @endif
                    </div>

                    <table class="grades-table">
                        <thead>
                            <tr>
                                <th style="width: 30%;">LEARNING AREAS</th>
                                <th style="width: 10%;">1st</th>
                                <th style="width: 10%;">2nd</th>
                                <th style="width: 10%;">3rd</th>
                                <th style="width: 10%;">4th</th>
                                <th style="width: 15%;">FINAL</th>
                                <th style="width: 15%;">REMARKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $subjectGrades = $record->grades->groupBy('subject');
                            @endphp

                            @forelse($subjectGrades as $subject => $grades)
                                <tr>
                                    <td>{{ $subject }}</td>
                                    @php
                                        $quarterGrades = [
                                            'Q1' => $grades->firstWhere('quarter', 'Q1')?->grade ?? '-',
                                            'Q2' => $grades->firstWhere('quarter', 'Q2')?->grade ?? '-',
                                            'Q3' => $grades->firstWhere('quarter', 'Q3')?->grade ?? '-',
                                            'Q4' => $grades->firstWhere('quarter', 'Q4')?->grade ?? '-',
                                        ];
                                        $numericGrades = collect($quarterGrades)->filter(fn($g) => is_numeric($g));
                                        $finalGrade = $numericGrades->isNotEmpty() ? $numericGrades->avg() : 0;
                                    @endphp

                                    @foreach ($quarterGrades as $grade)
                                        <td class="text-center">
                                            {{ is_numeric($grade) ? number_format($grade, 1) : $grade }}
                                        </td>
                                    @endforeach

                                    <td class="text-center font-bold">
                                        {{ $finalGrade > 0 ? number_format($finalGrade, 1) : '-' }}
                                    </td>
                                    <td class="text-center">
                                        @if($finalGrade > 0)
                                            {{ $finalGrade >= 75 ? 'Passed' : 'Failed' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500">No grades recorded</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($subjectGrades->isNotEmpty())
                            <tfoot>
                                <tr>
                                    <td><strong>General Average</strong></td>
                                    <td colspan="4"></td>
                                    <td class="text-center">
                                        <strong>{{ $record->average ? number_format($record->average, 1) : '-' }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong>
                                            @if($record->average)
                                                {{ $record->average >= 75 ? 'Passed' : 'Failed' }}
                                            @else
                                                -
                                            @endif
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            @endforeach
        @endif

        <!-- Certification Section -->
        <div class="certification-section">
            <p>I hereby certify that this is a true and accurate record of <strong>{{ strtoupper($student->name) }}</strong>.</p>

            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-line">
                        <p class="name">_______________________</p>
                        <p class="title">Class Adviser</p>
                    </div>
                </div>

                <div class="signature-box">
                    <div class="signature-line">
                        <p class="name">_______________________</p>
                        <p class="title">School Registrar</p>
                    </div>
                </div>

                <div class="signature-box">
                    <div class="signature-line">
                        <p class="name">Jun Rendal</p>
                        <p class="title">School Head</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="footer-note">
            <p>Not valid without school seal</p>
            <p>Generated on {{ now()->format('F d, Y - h:i A') }}</p>
        </div>
    </div>
</body>

</html>
