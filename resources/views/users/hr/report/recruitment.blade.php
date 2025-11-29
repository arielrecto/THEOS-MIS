<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Report - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">
    <div class="container p-4 sm:p-6 mx-auto print:p-0">
        <!-- Report Controls (hidden in print) -->
        <div class="mb-6 print:hidden">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4 w-full sm:w-auto">
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
                    <select name="department_id" class="text-xs select select-bordered select-sm w-full sm:w-auto">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}"
                                    {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" class="text-xs select select-bordered select-sm w-full sm:w-auto">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                        <option value="shortlisted" {{ request('status') === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="interviewed" {{ request('status') === 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                        <option value="hired" {{ request('status') === 'hired' ? 'selected' : '' }}>Hired</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>

                    <input type="date" name="start_date" class="input input-bordered input-sm w-full sm:w-auto"
                           value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                    <input type="date" name="end_date" class="input input-bordered input-sm w-full sm:w-auto"
                           value="{{ request('end_date', now()->format('Y-m-d')) }}">

                    <button type="submit" class="btn btn-sm w-full sm:w-auto">Generate</button>
                </form>
            </div>
        </div>

        <!-- Formal Report -->
        <div class="p-6 sm:p-8 bg-white rounded-lg shadow-sm print:p-0 print:shadow-none">
            <!-- Report Header -->
            <div class="mb-6 text-center">
                <h1 class="mb-2 text-xl sm:text-2xl font-bold">RECRUITMENT REPORT</h1>
                <div class="space-y-1 text-xs sm:text-sm text-gray-600">
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
            <div class="mb-6">
                <h2 class="pb-2 mb-4 text-sm sm:text-lg font-semibold border-b">RECRUITMENT SUMMARY</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <table class="min-w-full text-sm">
                            <tbody>
                                <tr>
                                    <td class="py-2">Total Applications:</td>
                                    <td class="py-2 font-medium text-right sm:text-left">{{ $stats['total_applications'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Pending Review:</td>
                                    <td class="py-2 font-medium text-right sm:text-left">{{ $stats['pending_applications'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Shortlisted:</td>
                                    <td class="py-2 font-medium text-right sm:text-left">{{ $stats['shortlisted'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class="min-w-full text-sm">
                            <tbody>
                                <tr>
                                    <td class="py-2">Interviewed:</td>
                                    <td class="py-2 font-medium text-right sm:text-left">{{ $stats['interviewed'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Hired:</td>
                                    <td class="py-2 font-medium text-right sm:text-left">{{ $stats['hired'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2">Rejected:</td>
                                    <td class="py-2 font-medium text-right sm:text-left">{{ $stats['rejected'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Detailed Records -->
            <div>
                <h2 class="pb-2 mb-4 text-sm sm:text-lg font-semibold border-b">APPLICATION DETAILS</h2>

                <!-- Mobile: stacked cards -->
                <div class="space-y-3 sm:hidden">
                    @forelse($records as $record)
                        <div class="bg-white border rounded-lg p-3 shadow-sm">
                            <div class="flex items-start justify-between mb-2">
                                <div class="text-sm font-semibold">{{ $record['position'] }}</div>
                                <div class="text-xs">
                                    <span class="badge {{ $record['status'] === 'open' ? 'badge-success' : 'badge-error' }} badge-sm">
                                        {{ ucfirst($record['status']) }}
                                    </span>
                                </div>
                            </div>

                            <div class="text-xs text-gray-600 mb-2">
                                <div><strong>Department:</strong> {{ $record['department'] }}</div>
                            </div>

                            <div class="grid grid-cols-3 gap-2 text-xs text-gray-700">
                                <div class="text-center">
                                    <div class="font-medium">{{ $record['total_applications'] }}</div>
                                    <div class="text-gray-500">Applications</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-medium">{{ $record['shortlisted_count'] }}</div>
                                    <div class="text-gray-500">Shortlisted</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-medium">{{ $record['hired_count'] }}</div>
                                    <div class="text-gray-500">Hired</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-6">No recruitment records found for the selected criteria</div>
                    @endforelse
                </div>

                <!-- Desktop / tablet: table -->
                <div class="hidden sm:block overflow-x-auto">
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
                                        <span class="badge {{ $record['status'] === 'open' ? 'badge-success' : 'badge-error' }}">
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
                        <p class="text-sm text-gray-600 capitalize">Administrator</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="pt-2 border-t border-gray-300">
                        <p class="font-medium">Approved by</p>
                        <p class="text-sm text-gray-600">Administrator</p>
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
