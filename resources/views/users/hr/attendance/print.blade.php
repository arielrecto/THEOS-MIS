<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report - {{ $employee->first_name }} {{ $employee->last_name }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print { display: none !important; }
            @page {
                margin: 2cm;
                size: portrait;
            }
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            .page-break { page-break-after: always; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <!-- Action Buttons -->
        <div class="flex justify-end gap-2 mb-4 no-print">
            <a href="{{ route('hr.attendance.show', $employee->id) }}" class="btn btn-ghost">
                <i class="fi fi-rr-arrow-left"></i>
                Back
            </a>
            <button onclick="window.print()" class="btn btn-accent">
                <i class="fi fi-rr-print"></i>
                Print Report
            </button>
        </div>

        <!-- Document Content -->
        <div class="bg-white p-8 shadow-sm">
            <!-- Header with Period -->
            <div class="flex justify-between items-start mb-8">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('logo.jpg') }}" alt="School Logo" class="w-16 h-16 object-contain">
                    <div>
                        <h1 class="text-2xl font-bold">Attendance Report</h1>
                        <p class="text-gray-600">{{ request('start_date', now()->startOfMonth()->format('M d, Y')) }} -
                           {{ request('end_date', now()->endOfMonth()->format('M d, Y')) }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Report Generated:</p>
                    <p class="font-medium">{{ now()->format('F d, Y h:i A') }}</p>
                </div>
            </div>

            <!-- Employee Info -->
            <div class="mb-8">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">Employee Name:</p>
                        <p class="font-medium">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Employee ID:</p>
                        <p class="font-medium">{{ str_pad($employee->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Department:</p>
                        <p class="font-medium">{{ $employee->position?->department?->name ?? 'Not Assigned' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Position:</p>
                        <p class="font-medium">{{ $employee->position?->name ?? 'Not Assigned' }}</p>
                    </div>
                </div>
            </div>

            <!-- Attendance Records -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4">Daily Attendance Records</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Status</th>
                                <th>Hours Worked</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $log)
                                <tr>
                                    <td>{{ $log->time_in->format('M d, Y') }}</td>
                                    <td>{{ $log->time_in->format('h:i A') }}</td>
                                    <td>{{ $log->time_out?->format('h:i A') ?? '-' }}</td>
                                    <td>
                                        @if($log->status === 'late')
                                            <span class="badge badge-warning">Late</span>
                                        @elseif($log->status === 'present')
                                            <span class="badge badge-success">Present</span>
                                        @else
                                            <span class="badge badge-error">Absent</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->time_out)
                                            {{ $log->time_out->diffInHours($log->time_in) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No attendance records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary -->
            <div class="border-t pt-6">
                <h2 class="text-lg font-semibold mb-4">Attendance Summary</h2>
                <div class="grid grid-cols-4 gap-4">
                    <div class="p-4 bg-success/10 rounded-lg">
                        <p class="text-sm text-gray-600">Present Days</p>
                        <p class="text-2xl font-bold text-success">{{ $summary['present'] }}</p>
                    </div>
                    <div class="p-4 bg-error/10 rounded-lg">
                        <p class="text-sm text-gray-600">Absent Days</p>
                        <p class="text-2xl font-bold text-error">{{ $summary['absent'] }}</p>
                    </div>
                    <div class="p-4 bg-warning/10 rounded-lg">
                        <p class="text-sm text-gray-600">Late Count</p>
                        <p class="text-2xl font-bold text-warning">{{ $summary['late'] }}</p>
                    </div>
                    <div class="p-4 bg-info/10 rounded-lg">
                        <p class="text-sm text-gray-600">Total Hours</p>
                        <p class="text-2xl font-bold text-info">{{ $summary['total_hours'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t">
                <p class="text-sm text-gray-500 text-center">
                    This is a computer-generated document. No signature is required.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
