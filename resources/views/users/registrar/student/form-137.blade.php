
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form 137</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet">
    <style>
        @media print {
            body { padding: 0; margin: 0; }
            .no-print { display: none; }
            .page-break { page-break-after: always; }
        }
        .form-137 {
            max-width: 8.5in;
            margin: 0 auto;
            padding: 0.5in;
        }
        .school-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .school-logo {
            width: 80px;
            height: auto;
            margin-bottom: 1rem;
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
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print fixed top-4 right-4 flex gap-2">
        <a href="{{ route('registrar.students.show', $student->id) }}" class="btn btn-ghost">
            <i class="fi fi-rr-arrow-left mr-2"></i>Back
        </a>
        <button onclick="window.print()" class="btn btn-accent">
            <i class="fi fi-rr-print mr-2"></i>Print Form 137
        </button>
    </div>

    <div class="form-137">
        <div class="school-header">
            <img src="{{ asset('logo-modified.png') }}" alt="School Logo" class="school-logo">
            <h1 class="text-xl font-bold">Theos Higher Ground
                Academe</h1>
            <p>Fairgrounds, Imus City,
Cavite.</p>
            <h2 class="text-lg font-bold mt-4">PERMANENT ACADEMIC RECORD</h2>
            <p class="text-sm">(Form 137)</p>
        </div>

        <!-- Student Information -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p><strong>Student Name:</strong> {{ $student->name }}</p>
                <p><strong>LRN:</strong> {{ $student->studentProfile->lrn }}</p>
                <p><strong>Date of Birth:</strong> {{ $student->studentProfile->birthdate }}</p>
            </div>
            <div>
                <p><strong>Address:</strong> {{ $student->studentProfile->address }}</p>
                <p><strong>Parent/Guardian:</strong> {{ $student->studentProfile->parent_name }}</p>
            </div>
        </div>

        <!-- Academic Records -->
        @foreach($student->studentProfile->academicRecords as $record)
            <div class="{{ !$loop->last ? 'page-break' : '' }}">
                <h3 class="font-bold mb-2">Grade {{ $record->grade_level }} - {{ $record->academicYear->name }}</h3>

                <table class="grades-table">
                    <thead>
                        <tr>
                            <th>LEARNING AREAS</th>
                            <th>1st</th>
                            <th>2nd</th>
                            <th>3rd</th>
                            <th>4th</th>
                            <th>FINAL</th>
                            <th>REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($record->grades->groupBy('subject') as $subject => $grades)
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
                                    <td class="text-center">
                                        {{ is_numeric($grade) ? number_format($grade, 1) : $grade }}
                                    </td>
                                @endforeach
                                <td class="text-center font-bold">{{ number_format($finalGrade, 1) }}</td>
                                <td class="text-center">
                                    {{ $finalGrade >= 75 ? 'Passed' : 'Failed' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-bold">
                            <td>General Average</td>
                            <td colspan="4"></td>
                            <td class="text-center">{{ number_format($record->average, 1) }}</td>
                            <td class="text-center">
                                {{ $record->average >= 75 ? 'Passed' : 'Failed' }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endforeach

        <!-- Certification -->
        <div class="mt-16">
            <p class="text-center">I hereby certify that this is a true record of {{ $student->name }}.</p>
            <div class="signature-line mt-8 text-center">
                <p class="font-bold">School Registrar</p>
            </div>
        </div>
    </div>
</body>
</html>
