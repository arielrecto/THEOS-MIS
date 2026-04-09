<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List - Theos Higher Ground Academe</title>
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
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
        .report-container {
            max-width: 11in;
            margin: 0 auto;
            padding: 0.5in;
        }
        .school-header {
            text-align: center;
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .school-logo {
            width: 80px;
            height: auto;
            margin-bottom: 1rem;
        }
        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        .students-table th,
        .students-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .students-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .students-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .filter-info {
            background-color: #f0f7ff;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        .signature-section {
            margin-top: 3rem;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 250px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 2rem;
            padding-top: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print fixed top-4 right-4 flex gap-2">
        <a href="{{ route('registrar.students.index') }}" class="btn btn-ghost">
            <i class="fi fi-rr-arrow-left mr-2"></i>
            Back to List
        </a>
        <button onclick="window.print()" class="btn btn-accent">
            <i class="fi fi-rr-print mr-2"></i>
            Print List
        </button>
    </div>

    <div class="report-container">
        <!-- School Header -->
        <div class="school-header">
            <img src="{{ asset('logo-modified.png') }}"
                 alt="Theos Higher Ground Academe Logo"
                 class="school-logo">
            <h1 class="text-2xl font-bold">Theos Higher Ground Academe</h1>
            <p class="text-sm">Fairgrounds, Imus City, Cavite</p>
            <h2 class="text-xl font-bold mt-4">STUDENT LIST</h2>
            <p class="text-sm">Generated on {{ now()->format('F d, Y - h:i A') }}</p>
        </div>

        <!-- Filter Information -->
        @if($filterInfo)
            <div class="filter-info">
                <h3 class="font-bold text-sm mb-2">Applied Filters:</h3>
                <div class="text-xs space-y-1">
                    @if($filterInfo['academic_year'])
                        <p><strong>Academic Year:</strong> {{ $filterInfo['academic_year'] }}</p>
                    @endif
                    @if($filterInfo['grade_level'])
                        <p><strong>Grade Level:</strong> {{ $filterInfo['grade_level'] }}</p>
                    @endif
                    @if($filterInfo['search'])
                        <p><strong>Search Term:</strong> "{{ $filterInfo['search'] }}"</p>
                    @endif
                    @if($filterInfo['sort'])
                        <p><strong>Sort Order:</strong> {{ $filterInfo['sort'] }}</p>
                    @endif
                </div>
            </div>
        @endif

        <!-- Summary -->
        <div class="mb-4">
            <p class="text-sm"><strong>Total Students:</strong> {{ $students->count() }}</p>
        </div>

        <!-- Students Table -->
        <table class="students-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 15%;">LRN</th>
                    <th style="width: 30%;">Student Name</th>
                    <th style="width: 15%;">Grade Level</th>
                    <th style="width: 20%;">Academic Year</th>
                    <th style="width: 15%;">Section</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $index => $student)
                    @php
                        $latestRecord = $student->studentProfile?->academicRecords
                            ->sortByDesc('grade_level')
                            ->first();
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $student->studentProfile?->lrn ?? 'N/A' }}</td>
                        <td>{{ $student->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $latestRecord?->grade_level ?? 'N/A' }}</td>
                        <td class="text-center">{{ $latestRecord?->academicYear?->name ?? 'N/A' }}</td>
                        <td class="text-center">{{ $latestRecord?->section?->name ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8">
                            No students found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">
                    <p class="font-bold text-sm">Prepared by</p>
                    <p class="text-xs mt-1">Registrar</p>
                </div>
            </div>

            <div class="signature-box">
                <div class="signature-line">
                    <p class="font-bold text-sm">Noted by</p>
                    <p class="text-xs mt-1">Principal</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-xs text-gray-500">
            <p>This is a computer-generated document. No signature is required.</p>
            <p class="mt-1">Page {{ $students->count() > 0 ? '1' : '0' }} of 1</p>
        </div>
    </div>
</body>
</html>
