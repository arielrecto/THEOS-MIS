<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Report - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>

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

<body class="bg-gray-100">
    <div class="container p-4 sm:p-6 mx-auto print:p-0">
        <!-- Report Controls (hidden in print) -->
        <div class="mb-6 print:hidden">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('hr.dashboard') }}" class="gap-2 btn btn-ghost btn-sm">
                        <i class="fi fi-rr-arrow-left"></i>
                        Back
                    </a>
                    <button class="gap-2 btn btn-primary btn-sm" onclick="window.print()">
                        <i class="fi fi-rr-print"></i>
                        Print Report
                    </button>
                </div>

                <form class="flex flex-col sm:flex-row items-start sm:items-center gap-2 w-full sm:w-auto">
                    <select name="employee_id" class="text-xs select select-bordered select-sm w-full sm:w-auto">
                        <option value="">All Employees</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" class="text-xs select select-bordered select-sm w-full sm:w-auto">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved
                        </option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected
                        </option>
                    </select>

                    <div class="flex gap-2 w-full sm:w-auto">
                        <input type="date" name="start_date" class="input input-bordered input-sm w-full"
                            value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                        <input type="date" name="end_date" class="input input-bordered input-sm w-full"
                            value="{{ request('end_date', now()->format('Y-m-d')) }}">
                    </div>

                    <button type="submit" class="btn btn-sm w-full sm:w-auto">Generate</button>
                </form>
            </div>
        </div>

        <!-- Formal Report -->
        <div class="p-6 sm:p-8 bg-white rounded-lg shadow-sm print:p-0 print:shadow-none">
            <!-- Report Header -->
            <div class="mb-6 text-center">
                <h1 class="mb-1 text-xl sm:text-2xl font-bold">LEAVE REPORT</h1>
                <div class="space-y-1 text-xs sm:text-sm text-gray-600">
                    <p class="font-semibold">{{ config('app.name') }}</p>
                    <p class="text-xs sm:text-sm">Period: {{ request('start_date', now()->startOfMonth()->format('F d, Y')) }}
                        to {{ request('end_date', now()->format('F d, Y')) }}</p>
                    @if (request('employee_id'))
                        <p class="text-xs sm:text-sm">Employee: {{ $employees->find(request('employee_id'))->full_name }}</p>
                    @else
                        <p class="text-xs sm:text-sm">All Employees</p>
                    @endif
                </div>
            </div>

            <!-- Summary Section -->
            <div class="mb-6">
                <h2 class="pb-2 mb-4 text-sm sm:text-lg font-semibold border-b">LEAVE SUMMARY</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="bg-gray-50 rounded p-3">
                        <table class="min-w-full">
                            <tbody class="text-sm">
                                <tr>
                                    <td class="py-1">Total Leave Requests:</td>
                                    <td class="py-1 font-medium text-right sm:text-left">{{ $stats['total_requests'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1">Pending Requests:</td>
                                    <td class="py-1 font-medium text-right sm:text-left">{{ $stats['pending_requests'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-50 rounded p-3">
                        <table class="min-w-full">
                            <tbody class="text-sm">
                                <tr>
                                    <td class="py-1">Approved Requests:</td>
                                    <td class="py-1 font-medium text-right sm:text-left">{{ $stats['approved_requests'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1">Rejected Requests:</td>
                                    <td class="py-1 font-medium text-right sm:text-left">{{ $stats['rejected_requests'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Detailed Records -->
            <div>
                <h2 class="pb-2 mb-4 text-sm sm:text-lg font-semibold border-b">DETAILED LEAVE RECORDS</h2>

                <!-- Mobile: stacked cards -->
                <div class="space-y-3 sm:hidden">
                    @forelse($records as $record)
                        <div class="bg-white border rounded-lg p-3 shadow-sm">
                            <div class="flex items-start justify-between mb-2">
                                <div class="text-sm font-medium">{{ $record->employee->first_name }} {{ $record->employee->last_name }}</div>
                                <div class="text-xs">
                                    <span
                                        class="badge {{ $record->status === 'approved' ? 'badge-success' : ($record->status === 'pending' ? 'badge-warning' : 'badge-error') }} badge-sm">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="text-xs text-gray-600 mb-2">
                                <div><strong>Type:</strong> {{ ucfirst($record->leave_type) }}</div>
                                <div><strong>Filed:</strong> {{ $record->created_at->format('M d, Y') }}</div>
                            </div>

                            <div class="text-xs text-gray-700">
                                <div><strong>Duration:</strong></div>
                                <div>{{ date('M d, Y', strtotime($record->start_date)) }} - {{ date('M d, Y', strtotime($record->end_date)) }}</div>
                                <div class="text-xs text-gray-500">{{ $record->days }} days</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-6">No leave records found for the selected criteria</div>
                    @endforelse
                </div>

                <!-- Desktop / tablet: table -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-3 text-left">Employee</th>
                                <th class="py-3 text-left">Leave Type</th>
                                <th class="py-3 text-left">Duration</th>
                                <th class="py-3 text-left">Status</th>
                                <th class="py-3 text-left">Filed Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $record)
                                <tr class="border-b">
                                    <td class="py-3">
                                        {{ $record->employee->first_name }} {{ $record->employee->last_name }}
                                    </td>
                                    <td class="py-3">{{ ucfirst($record->leave_type) }}</td>
                                    <td class="py-3">
                                        {{ date('M d, Y', strtotime($record->start_date))  }} -
                                        {{ date('M d, Y', strtotime($record->end_date))  }}
                                        <div class="text-xs text-gray-500">
                                            {{ $record->days }} days
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge {{ $record->status === 'approved' ? 'badge-success' : ($record->status === 'pending' ? 'badge-warning' : 'badge-error') }}">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3">{{ $record->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">
                                        No leave records found for the selected criteria
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Signatory Section -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-8">
                <div class="text-center">
                    <div class="pt-2 border-t border-gray-300">
                        <p class="font-medium">Prepared by</p>
                        <p class="text-sm text-gray-600">HR</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="pt-2 border-t border-gray-300">
                        <p class="font-medium">Reviewed by</p>
                        <p class="text-sm text-gray-600 capitalize">Admin</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="pt-2 border-t border-gray-300">
                        <p class="font-medium">Approved by</p>
                        <p class="text-sm text-gray-600">Admin</p>
                    </div>
                </div>
            </div>

            <!-- Report Footer -->
            <div class="pt-6 mt-6 text-sm border-t">
                <div class="flex flex-col sm:flex-row justify-between gap-4">
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

</body>

</html>
