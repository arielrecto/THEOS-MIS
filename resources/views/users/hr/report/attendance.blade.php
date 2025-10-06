<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">
    <!-- Screen view container -->
    <div class="container p-6 mx-auto print:p-0">
        <!-- Report Controls (hidden in print) -->
        <div class="mb-6 print:hidden">
            <div class="flex justify-between items-center">
                <div class="flex gap-4 items-center">
                    <a href="{{ route('hr.dashboard') }}" class="gap-2 btn btn-ghost btn-sm">
                        <i class="fi fi-rr-arrow-left"></i>
                        Back
                    </a>
                    <button class="gap-2 btn btn-primary btn-sm" onclick="window.print()">
                        <i class="fi fi-rr-print"></i>
                        Print Report
                    </button>
                    <form class="flex gap-4">
                        <select name="employee_id" class="select select-bordered select-sm">
                            <option value="">All Employees</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}"
                                        {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="date" name="start_date" class="input input-bordered input-sm"
                               value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                        <input type="date" name="end_date" class="input input-bordered input-sm"
                               value="{{ request('end_date', now()->format('Y-m-d')) }}">
                        <button type="submit" class="btn btn-sm">Generate</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Formal Report -->
        <div class="p-8 bg-white rounded-lg shadow-sm print:p-0 print:shadow-none">
            <!-- Company Logo (if available) -->
            <div class="mb-4 text-center">
                @if(config('app.logo'))
                    <img src="{{ asset(config('app.logo')) }}" alt="Company Logo" class="mx-auto mb-4 h-16">
                @endif
            </div>

            <!-- Report Header -->
            <div class="mb-8 text-center">
                <h1 class="mb-2 text-2xl font-bold">ATTENDANCE REPORT</h1>
                <div class="space-y-1 text-sm text-gray-600">
                    <p class="font-semibold">{{ config('app.name') }}</p>
                    <p>Period: {{ request('start_date', now()->startOfMonth()->format('F d, Y')) }}
                       to {{ request('end_date', now()->format('F d, Y')) }}</p>
                    @if(request('employee_id'))
                        <p>Employee: {{ $employees->find(request('employee_id'))->full_name }}</p>
                    @else
                        <p>All Employees</p>
                    @endif
                </div>
            </div>

            <!-- Summary Section -->
            <div class="mb-8">
                <h2 class="pb-2 mb-4 text-lg font-semibold border-b">ATTENDANCE SUMMARY</h2>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <table class="min-w-full">
                            <tbody class="text-sm">
                                <tr>
                                    <td class="py-2">Total Working Days:</td>
                                    <td class="py-2 font-medium">{{ $stats['total_present'] }} days</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Total Late Arrivals:</td>
                                    <td class="py-2 font-medium">{{ $stats['late_count'] }} instances</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class="min-w-full">
                            <tbody class="text-sm">
                                <tr>
                                    <td class="py-2">Average Daily Hours:</td>
                                    <td class="py-2 font-medium">{{ number_format($stats['avg_hours'], 1) }} hours</td>
                                </tr>
                                <tr>
                                    <td class="py-2">On-Time Percentage:</td>
                                    <td class="py-2 font-medium">{{ number_format($stats['ontime_percentage'], 1) }}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Detailed Records -->
            <div>
                <h2 class="pb-2 mb-4 text-lg font-semibold border-b">DETAILED ATTENDANCE RECORDS</h2>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="py-3 text-left">Date</th>
                            <th class="py-3 text-left">Employee Name</th>
                            <th class="py-3 text-left">Time In</th>
                            <th class="py-3 text-left">Time Out</th>
                            <th class="py-3 text-left">Work Hours</th>
                            <th class="py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                            <tr class="border-b">
                                <td class="py-3">{{ $record->time_in->format('M d, Y') }}</td>
                                <td class="py-3">
                                    {{ $record->employee->first_name }} {{ $record->employee->last_name }}
                                </td>
                                <td class="py-3">{{ $record->time_in->format('h:i A') }}</td>
                                <td class="py-3">
                                    {{ $record->time_out ? $record->time_out->format('h:i A') : '---' }}
                                </td>
                                <td class="py-3">
                                    {{ $record->time_out ? $record->time_out->diffInHours($record->time_in) : '---' }}
                                </td>
                                <td class="py-3">
                                    {{ ucfirst($record->status) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">
                                    No attendance records found for the selected criteria
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Signatory Section -->
            <div class="grid grid-cols-3 gap-8 mt-16">
                <div class="text-center">
                    <div class="pt-2 border-t border-gray-300">
                        <p class="font-medium">Prepared by</p>
                        <p class="text-sm text-gray-600">HR Staff</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="pt-2 border-t border-gray-300">
                        <p class="font-medium">Reviewed by</p>
                        <p class="text-sm text-gray-600 capitalize">{{ App\Models\User::first()->name }} Manager</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="pt-2 border-t border-gray-300">
                        <p class="font-medium">Approved by</p>
                        <p class="text-sm text-gray-600">Director</p>
                    </div>
                </div>
            </div>

            <!-- Report Footer -->
            <div class="pt-8 mt-8 text-sm border-t">
                <div class="flex justify-between">
                    <div>
                        <p>Generated by: {{ auth()->user()->name }}</p>
                        <p>Date Generated: {{ now()->format('F d, Y h:i A') }}</p>
                    </div>
                    <div class="text-right">
                        <p>Page 1 of 1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .container {
                width: 100%;
                max-width: none;
                margin: 0;
                padding: 0;
            }
            .print\:hidden {
                display: none !important;
            }
            .print\:p-0 {
                padding: 0 !important;
            }
            .print\:shadow-none {
                box-shadow: none !important;
            }
            table {
                width: 100%;
                break-inside: auto;
            }
            tr {
                break-inside: avoid;
            }
            thead {
                display: table-header-group;
            }
            tfoot {
                display: table-footer-group;
            }
            @page {
                margin: 1cm;
                size: portrait;
            }
        }
    </style>
</body>
</html>
