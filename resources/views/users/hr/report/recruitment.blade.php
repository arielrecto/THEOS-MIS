<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Report - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
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
                        <select name="department_id" class="select text-xs select-bordered select-sm">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                        {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="status" class="select text-xs select-bordered select-sm">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="shortlisted" {{ request('status') === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                            <option value="interviewed" {{ request('status') === 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                            <option value="hired" {{ request('status') === 'hired' ? 'selected' : '' }}>Hired</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                <h1 class="text-2xl font-bold mb-2">RECRUITMENT REPORT</h1>
                <div class="text-sm text-gray-600 space-y-1">
                    <p class="font-semibold">{{ config('app.name') }}</p>
                    <p>Period: {{ request('start_date', now()->startOfMonth()->format('F d, Y')) }}
                       to {{ request('end_date', now()->format('F d, Y')) }}</p>
                    @if(request('department_id'))
                        <p>Department: {{ $departments->find(request('department_id'))->name }}</p>
                    @else
                        <p>All Departments</p>
                    @endif
                </div>
            </div>

            <!-- Summary Section -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">RECRUITMENT SUMMARY</h2>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <table class="min-w-full">
                            <tbody class="text-sm">
                                <tr>
                                    <td class="py-2">Total Applications:</td>
                                    <td class="py-2 font-medium">{{ $stats['total_applications'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Pending Review:</td>
                                    <td class="py-2 font-medium">{{ $stats['pending_applications'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Shortlisted:</td>
                                    <td class="py-2 font-medium">{{ $stats['shortlisted'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class="min-w-full">
                            <tbody class="text-sm">
                                <tr>
                                    <td class="py-2">Interviewed:</td>
                                    <td class="py-2 font-medium">{{ $stats['interviewed'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Hired:</td>
                                    <td class="py-2 font-medium">{{ $stats['hired'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Rejected:</td>
                                    <td class="py-2 font-medium">{{ $stats['rejected'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Detailed Records -->
            <div>
                <h2 class="text-lg font-semibold mb-4 border-b pb-2">APPLICATION DETAILS</h2>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="py-3 text-left">Position</th>
                            <th class="py-3 text-left">Department</th>
                            <th class="py-3 text-left">Applications</th>
                            <th class="py-3 text-left">Shortlisted</th>
                            <th class="py-3 text-left">Hired</th>
                            <th class="py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                            <tr class="border-b">
                                <td class="py-3">{{ $record['position'] }}</td>
                                <td class="py-3">{{ $record['department'] }}</td>
                                <td class="py-3">{{ $record['total_applications'] }}</td>
                                <td class="py-3">{{ $record['shortlisted_count'] }}</td>
                                <td class="py-3">{{ $record['hired_count'] }}</td>
                                <td class="py-3">
                                    <span class="badge badge-{{ $record['status'] === 'open' ? 'success' : 'error' }}">
                                        {{ ucfirst($record['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">
                                    No recruitment records found for the selected criteria
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
                        <p class="text-sm text-gray-600">HR Recruitment Officer</p>
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
            .print\:hidden { display: none !important; }
            .print\:p-0 { padding: 0 !important; }
            .print\:shadow-none { box-shadow: none !important; }
            table { width: 100%; break-inside: auto; }
            tr { break-inside: avoid; }
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
            @page {
                margin: 1cm;
                size: portrait;
            }
        }
    </style>
</body>
</html>
