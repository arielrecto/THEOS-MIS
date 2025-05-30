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
    <div class="container mx-auto p-6 print:p-0">
        <!-- Report Controls (hidden in print) -->
        <div class="mb-6 print:hidden">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('hr.dashboard') }}" class="btn btn-ghost btn-sm gap-2">
                        <i class="fi fi-rr-arrow-left"></i>
                        Back
                    </a>
                    <button class="btn btn-primary btn-sm gap-2" onclick="window.print()">
                        <i class="fi fi-rr-print"></i>
                        Print Report
                    </button>
                    <form class="flex gap-4">
                        <select name="employee_id" class="select text-xs select-bordered select-sm">
                            <option value="">All Employees</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="status" class="select text-xs select-bordered select-sm">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
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
        <div class="bg-white rounded-lg shadow-sm p-8 print:p-0 print:shadow-none">
            <!-- Report Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold mb-2">LEAVE REPORT</h1>
                <div class="text-sm text-gray-600 space-y-1">
                    <p class="font-semibold">{{ config('app.name') }}</p>
                    <p>Period: {{ request('start_date', now()->startOfMonth()->format('F d, Y')) }}
                        to {{ request('end_date', now()->format('F d, Y')) }}</p>
                    @if (request('employee_id'))
                        <p>Employee: {{ $employees->find(request('employee_id'))->full_name }}</p>
                    @else
                        <p>All Employees</p>
                    @endif
                </div>
            </div>

            <!-- Summary Section -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">LEAVE SUMMARY</h2>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <table class="min-w-full">
                            <tbody class="text-sm">
                                <tr>
                                    <td class="py-2">Total Leave Requests:</td>
                                    <td class="py-2 font-medium">{{ $stats['total_requests'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Pending Requests:</td>
                                    <td class="py-2 font-medium">{{ $stats['pending_requests'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class="min-w-full">
                            <tbody class="text-sm">
                                <tr>
                                    <td class="py-2">Approved Requests:</td>
                                    <td class="py-2 font-medium">{{ $stats['approved_requests'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Rejected Requests:</td>
                                    <td class="py-2 font-medium">{{ $stats['rejected_requests'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Detailed Records -->
            <div>
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">DETAILED LEAVE RECORDS</h2>
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
                                        class="badge badge-{{ $record->status === 'approved' ? 'success' : ($record->status === 'pending' ? 'warning' : 'error') }}">
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

            <!-- Signatory Section -->
            <div class="mt-16 grid grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="border-t border-gray-300 pt-2">
                        <p class="font-medium">Prepared by</p>
                        <p class="text-sm text-gray-600">HR Staff</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="border-t border-gray-300 pt-2">
                        <p class="font-medium">Reviewed by</p>
                        <p class="text-sm text-gray-600">HR Manager</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="border-t border-gray-300 pt-2">
                        <p class="font-medium">Approved by</p>
                        <p class="text-sm text-gray-600">Director</p>
                    </div>
                </div>
            </div>

            <!-- Report Footer -->
            <div class="mt-8 pt-8 border-t text-sm">
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

</body>

</html>
