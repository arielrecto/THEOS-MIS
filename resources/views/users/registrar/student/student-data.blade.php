{{-- filepath: e:\Projects\Theos MIS\resources\views\users\registrar\student\student-data.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data Report - {{ $student->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                padding: 0;
                margin: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }

            .page-break {
                page-break-after: always;
            }

            .print-section {
                page-break-inside: avoid;
            }
        }

        .data-report {
            max-width: 8.5in;
            margin: 0 auto;
            padding: 0.5in;
            background: white;
        }

        .header-logo {
            width: 100px;
            height: auto;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .info-table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-table td:first-child {
            font-weight: 600;
            width: 40%;
            color: #374151;
        }

        .section-title {
            background: #3b82f6;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .grades-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }

        .grade-card {
            border: 1px solid #e5e7eb;
            padding: 1rem;
            border-radius: 8px;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 0.9rem;
        }

        .payment-table th,
        .payment-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .payment-table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Print Button -->
    <div class="no-print fixed top-4 right-4 flex gap-2 z-50">
        <a href="{{ route('registrar.students.show', $student->id) }}" class="btn btn-ghost">
            <i class="fi fi-rr-arrow-left mr-2"></i>Back
        </a>
        <button onclick="window.print()" class="btn btn-accent">
            <i class="fi fi-rr-print mr-2"></i>Print Report
        </button>
    </div>

    <div class="data-report">
        <!-- Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('logo-modified.png') }}" alt="School Logo" class="header-logo mx-auto mb-4">
            <h1 class="text-2xl font-bold">Theos Higher Ground Academe</h1>
            <p class="text-gray-600">Fairgrounds, Imus City, Cavite</p>
            <h2 class="text-xl font-bold mt-6 mb-2">STUDENT DATA REPORT</h2>
            <p class="text-sm text-gray-500">Generated on {{ now()->format('F d, Y') }}</p>
        </div>

        <!-- Student Profile Section -->
        <div class="print-section">
            <div class="section-title">STUDENT INFORMATION</div>

            <div class="flex items-start gap-6 mb-6">
                <div class="flex-shrink-0">
                    @if($student->profilePicture)
                        <img src="{{ asset($student->profilePicture->file_dir) }}"
                             alt="Student Photo"
                             class="w-32 h-32 rounded-lg object-cover border-2 border-gray-300">
                    @else
                        <div class="w-32 h-32 rounded-lg bg-gray-200 flex items-center justify-center">
                            <i class="fi fi-rr-user text-4xl text-gray-400"></i>
                        </div>
                    @endif
                </div>

                <table class="info-table flex-1">
                    <tr>
                        <td>Full Name</td>
                        <td>{{ $student->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Learner Reference Number (LRN)</td>
                        <td>{{ $student->studentProfile?->lrn ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Email Address</td>
                        <td>{{ $student->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td>{{ $student->studentProfile?->birthdate ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Birthplace</td>
                        <td>{{ $student->studentProfile?->birthplace ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                        <td>{{ $student->studentProfile?->contact_number ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            <table class="info-table">
                <tr>
                    <td>Current Address</td>
                    <td>
                        {{ $student->studentProfile?->house_no ?? '' }}
                        {{ $student->studentProfile?->street ?? '' }},
                        {{ $student->studentProfile?->barangay ?? '' }},
                        {{ $student->studentProfile?->city ?? '' }},
                        {{ $student->studentProfile?->province ?? '' }}
                        {{ $student->studentProfile?->zip_code ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td>Permanent Address</td>
                    <td>
                        {{ $student->studentProfile?->perm_house_no ?? '' }}
                        {{ $student->studentProfile?->perm_street ?? '' }},
                        {{ $student->studentProfile?->perm_barangay ?? '' }},
                        {{ $student->studentProfile?->perm_city ?? '' }},
                        {{ $student->studentProfile?->perm_province ?? '' }}
                        {{ $student->studentProfile?->perm_zip_code ?? '' }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Parent/Guardian Information -->
        <div class="print-section">
            <div class="section-title">PARENT/GUARDIAN INFORMATION</div>

            <table class="info-table">
                <tr>
                    <td>Parent/Guardian Name</td>
                    <td>{{ $student->studentProfile?->parent_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Relationship</td>
                    <td>{{ $student->studentProfile?->relationship ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Occupation</td>
                    <td>{{ $student->studentProfile?->occupation ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <!-- Academic Performance Summary -->
        <div class="print-section page-break">
            <div class="section-title">ACADEMIC PERFORMANCE SUMMARY</div>

            @forelse($student->studentProfile?->academicRecords ?? [] as $record)
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-3">
                        Grade {{ $record->grade_level }} - {{ $record->academicYear?->name ?? 'N/A' }}
                    </h3>

                    <div class="grades-summary">
                        <div class="grade-card">
                            <p class="text-sm text-gray-600">General Average</p>
                            <p class="text-3xl font-bold {{ $record->average >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($record->average ?? 0, 2) }}
                            </p>
                        </div>
                        <div class="grade-card">
                            <p class="text-sm text-gray-600">Number of Subjects</p>
                            <p class="text-3xl font-bold text-blue-600">
                                {{ $record->grades->groupBy('subject')->count() }}
                            </p>
                        </div>
                        <div class="grade-card">
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="text-xl font-bold {{ $record->average >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $record->average >= 75 ? 'PASSED' : 'FAILED' }}
                            </p>
                        </div>
                    </div>

                    <!-- Detailed Grades -->
                    <table class="payment-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th class="text-center">Q1</th>
                                <th class="text-center">Q2</th>
                                <th class="text-center">Q3</th>
                                <th class="text-center">Q4</th>
                                <th class="text-center">Final Grade</th>
                                <th class="text-center">Remarks</th>
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
                                            'Q4' => $grades->firstWhere('quarter', 'Q4')?->grade ?? '-',
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
                                        <span class="{{ $finalGrade >= 75 ? 'text-green-600' : 'text-red-600' }} font-semibold">
                                            {{ $finalGrade >= 75 ? 'PASSED' : 'FAILED' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">No academic records available.</p>
            @endforelse
        </div>

        <!-- Payment History -->
        <div class="print-section page-break">
            <div class="section-title">PAYMENT HISTORY</div>

            <!-- Payment Summary -->
            <div class="grades-summary mb-6">
                <div class="grade-card bg-green-50">
                    <p class="text-sm text-gray-600">Total Paid</p>
                    <p class="text-2xl font-bold text-green-600">
                        ₱{{ number_format($paymentStats['total_paid'], 2) }}
                    </p>
                </div>
                <div class="grade-card bg-yellow-50">
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">
                        ₱{{ number_format($paymentStats['total_pending'], 2) }}
                    </p>
                </div>
                <div class="grade-card bg-blue-50">
                    <p class="text-sm text-gray-600">Payment Rate</p>
                    <p class="text-2xl font-bold text-blue-600">
                        {{ number_format($paymentStats['payment_rate'], 1) }}%
                    </p>
                </div>
            </div>

            <!-- Payment Details -->
            <table class="payment-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Payment For</th>
                        <th>Method</th>
                        <th class="text-right">Amount</th>
                        <th class="text-center">Status</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                            <td>{{ $payment->paymentAccount?->name ?? 'N/A' }}</td>
                            <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                            <td class="text-right font-semibold">₱{{ number_format($payment->amount, 2) }}</td>
                            <td class="text-center">
                                @if($payment->status === 'approved')
                                    <span class="text-green-600 font-semibold">APPROVED</span>
                                @elseif($payment->status === 'pending')
                                    <span class="text-yellow-600 font-semibold">PENDING</span>
                                @else
                                    <span class="text-red-600 font-semibold">REJECTED</span>
                                @endif
                            </td>
                            <td>{{ $payment->note ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">
                                No payment records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="font-bold bg-gray-100">
                        <td colspan="3" class="text-right">TOTAL PAID:</td>
                        <td class="text-right text-green-600">₱{{ number_format($paymentStats['total_paid'], 2) }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Enrolled Subjects (Current) -->
        <div class="print-section">
            <div class="section-title">CURRENT ENROLLED SUBJECTS</div>

            <table class="payment-table">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Classroom</th>
                        <th class="text-center">Current Grade</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $studentClassrooms = $student->asStudentClassrooms ?? collect();
                        $latestRecord = $student->studentProfile?->academicRecords->sortByDesc('id')->first();
                    @endphp

                    @forelse($studentClassrooms as $classroomStudent)
                        @php
                            $classroom = $classroomStudent->classroom ?? $classroomStudent;
                            $subject = $classroom->subject ?? null;
                            $matchedGrade = null;
                            if ($latestRecord && $latestRecord->grades && $subject) {
                                $matchedGrade = $latestRecord->grades->firstWhere('subject', $subject->name);
                            }
                        @endphp
                        <tr>
                            <td>{{ $subject->name ?? 'N/A' }}</td>
                            <td>{{ $classroom->name ?? 'N/A' }}</td>
                            <td class="text-center font-semibold">
                                @if($matchedGrade)
                                    <span class="{{ $matchedGrade->grade >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($matchedGrade->grade, 1) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($matchedGrade)
                                    <span class="{{ $matchedGrade->grade >= 75 ? 'text-green-600' : 'text-red-600' }} font-semibold">
                                        {{ $matchedGrade->remarks ?? 'N/A' }}
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-4">
                                No enrolled subjects found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer/Certification -->
        <div class="print-section mt-16">
            <div class="border-t-2 border-gray-300 pt-8">
                <p class="text-center mb-12">
                    This is a computer-generated report for <strong>{{ $student->name }}</strong>.
                    <br>
                    Generated on {{ now()->format('F d, Y \a\t h:i A') }}
                </p>

                <div class="grid grid-cols-2 gap-12 mt-16">
                    <div class="text-center">
                        <div class="border-t-2 border-black pt-2 mt-16">
                            <p class="font-bold">Prepared By</p>
                            <p class="text-sm text-gray-600">Registrar Staff</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="border-t-2 border-black pt-2 mt-16">
                            <p class="font-bold">Verified By</p>
                            <p class="text-sm text-gray-600">School Registrar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-print on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>

</html>