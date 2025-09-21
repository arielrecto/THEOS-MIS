<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report - {{ auth()->user()->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @page {
            margin: 1cm;
            size: A4;
        }
        body {
            font-family: Arial, sans-serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .header {
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        .summary-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-error {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                font-size: 12px;
            }
            .break-after {
                page-break-after: always;
            }
        }
    </style>
</head>
<body class="p-6 bg-white">
    <div class="mb-6 no-print">
        <button onclick="window.print()" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
            <i class="mr-2 fas fa-print"></i>Print Report
        </button>
        <button onclick="window.history.back()" class="px-4 py-2 ml-2 bg-gray-200 rounded hover:bg-gray-300">
            <i class="mr-2 fas fa-arrow-left"></i>Back
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Attendance Report</h1>
                <p class="text-gray-600">Generated on {{ now()->format('F j, Y h:i A') }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-semibold">{{ auth()->user()->name }}</h2>
                <p class="text-gray-600">{{ auth()->user()->employee?->position->name ?? 'Employee' }}</p>
                <p class="text-sm text-gray-500">{{ auth()->user()->employee?->department->name ?? '' }}</p>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
        <div class="bg-green-50 summary-card">
            <h3 class="text-sm font-medium text-gray-500">Days Present</h3>
            <p class="text-2xl font-bold text-green-700">{{ $attendanceLogs->count() }}</p>
            <p class="mt-1 text-xs text-gray-500">Total working days</p>
        </div>
        <div class="bg-blue-50 summary-card">
            <h3 class="text-sm font-medium text-gray-500">Total Hours</h3>
            <p class="text-2xl font-bold text-blue-700">
                {{ number_format($totalHours, 2) }} hrs
            </p>
            <p class="mt-1 text-xs text-gray-500">Total working hours</p>
        </div>
        <div class="bg-yellow-50 summary-card">
            <h3 class="text-sm font-medium text-gray-500">Average Hours/Day</h3>
            <p class="text-2xl font-bold text-yellow-700">
                {{ $attendanceLogs->count() > 0 ? number_format($totalHours / $attendanceLogs->count(), 2) : 0 }} hrs
            </p>
            <p class="mt-1 text-xs text-gray-500">Average working hours</p>
        </div>
    </div>

    <!-- Detailed Logs -->
    <div class="mb-6">
        <h2 class="mb-3 text-lg font-semibold">Attendance Logs</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Day</th>
                        <th class="px-4 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Time In</th>
                        <th class="px-4 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Time Out</th>
                        <th class="px-4 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Hours Worked</th>
                        <th class="px-4 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($attendanceLogs as $log)
                        @php
                            $hoursWorked = $log->time_out ? $log->time_out->diffInMinutes($log->time_in) / 60 : 0;
                            $isLate = $log->time_in->format('H:i') > '08:30';
                            $isEarlyOut = $log->time_out && $log->time_out->format('H:i') < '17:00';
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900 whitespace-nowrap">
                                {{ $log->time_in->format('M j, Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                {{ $log->time_in->format('l') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                {{ $log->time_in->format('h:i A') }}
                                @if($isLate)
                                    <span class="ml-2 badge badge-error">Late</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                {{ $log->time_out ? $log->time_out->format('h:i A') : '--:-- --' }}
                                @if($isEarlyOut)
                                    <span class="ml-2 badge badge-warning">Early Out</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                @if($log->time_out)
                                    {{ floor($hoursWorked) }}h {{ round(($hoursWorked - floor($hoursWorked)) * 60) }}m
                                @else
                                    --:--
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if(!$log->time_out)
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($hoursWorked >= 8)
                                    <span class="badge badge-success">Complete</span>
                                @else
                                    <span class="badge badge-error">Incomplete</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-sm text-center text-gray-500">
                                No attendance records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary -->
    <div class="pt-4 mt-8 text-xs text-gray-500 border-t border-gray-200">
        <p>This is a computer-generated report. No signature is required.</p>
        <p class="mt-1">Generated by {{ config('app.name') }} on {{ now()->format('F j, Y \a\t h:i A') }}</p>
    </div>

    <script>
        // Auto-print when the page loads
        window.onload = function() {
            if (window.location.search.includes('autoprint')) {
                window.print();
            }
        };
    </script>
</body>
</html>