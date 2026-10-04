@php use App\Models\Logo; $reportLogo = Logo::where('is_active', true)->first()?->path ?? null; @endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Report - {{ config('app.name') }}</title>
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
        @page {
            margin: 1cm;
            size: portrait;
        }
    }
</style>

<body class="bg-gray-100">
    <div class="container p-4 mx-auto sm:p-6 print:p-0">
        <!-- Report Controls (hidden in print) -->
        <div class="mb-6 print:hidden">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex gap-4 items-center">
                    <a href="{{ route('hr.reports.index') }}" class="gap-2 btn btn-ghost btn-sm">
                        <i class="fi fi-rr-arrow-left"></i>
                        Back
                    </a>
                    <button class="gap-2 btn btn-primary btn-sm" onclick="window.print()">
                        <i class="fi fi-rr-print"></i>
                        Print Report
                    </button>
                </div>

                <form class="flex flex-col gap-2 items-start w-full sm:flex-row sm:items-center sm:w-auto">
                    <select name="department_id" class="w-full text-xs select select-bordered select-sm sm:w-auto">
                        <option value="">All Departments</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @selected(request('department_id') == $department->id)>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full btn btn-sm sm:w-auto">Generate</button>
                </form>
            </div>
        </div>

        <!-- Formal Report -->
        <div class="p-6 bg-white rounded-lg shadow-sm sm:p-8 print:p-0 print:shadow-none">
            <!-- Report Header -->
            <div class="mb-6 text-center">
                <div class="flex justify-center mb-3">
                    @if ($reportLogo)
                        <img src="{{ asset('storage/' . $reportLogo) }}" alt="School Logo" class="object-contain w-20 h-20">
                    @else
                        <img src="{{ asset('logo-modified.png') }}" alt="School Logo" class="object-contain w-20 h-20">
                    @endif
                </div>
                <h1 class="mb-1 text-xl font-bold sm:text-2xl">PAYROLL REPORT</h1>
                <div class="space-y-1 text-xs text-gray-600 sm:text-sm">
                    <p class="font-semibold">{{ config('app.name') }}</p>
                    <p>Salary summary as of {{ now()->format('F d, Y') }}</p>
                    <p>{{ request('department_id') ? $departments->find(request('department_id'))?->name : 'All Departments' }}</p>
                </div>
            </div>

            <!-- Summary -->
            <div class="mb-6">
                <h2 class="pb-2 mb-4 text-sm font-semibold border-b sm:text-lg">SALARY SUMMARY</h2>
                <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                    <div class="p-3 bg-gray-50 rounded">
                        <table class="min-w-full">
                            <tbody>
                                <tr>
                                    <td class="py-1">Employees:</td>
                                    <td class="py-1 font-medium text-right sm:text-left">{{ $stats['employees'] }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1">Total Salaries:</td>
                                    <td class="py-1 font-medium text-right sm:text-left">₱{{ number_format($stats['total_salary'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 bg-gray-50 rounded">
                        <table class="min-w-full">
                            <tbody>
                                <tr>
                                    <td class="py-1">Average Salary:</td>
                                    <td class="py-1 font-medium text-right sm:text-left">₱{{ number_format($stats['average_salary'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1">Missing Salary Records:</td>
                                    <td class="py-1 font-medium text-right sm:text-left {{ $stats['missing_salary'] > 0 ? 'text-error' : '' }}">{{ $stats['missing_salary'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- By Department -->
            <div class="mb-6">
                <h2 class="pb-2 mb-4 text-sm font-semibold border-b sm:text-lg">SALARY TOTALS BY DEPARTMENT</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-3 text-left">Department</th>
                                <th class="py-3 text-right">Employees</th>
                                <th class="py-3 text-right">Average</th>
                                <th class="py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($byDepartment as $row)
                                <tr class="border-b">
                                    <td class="py-3">{{ $row['department'] }}</td>
                                    <td class="py-3 text-right">{{ $row['employees'] }}</td>
                                    <td class="py-3 text-right whitespace-nowrap">₱{{ number_format($row['average'], 2) }}</td>
                                    <td class="py-3 font-medium text-right whitespace-nowrap">₱{{ number_format($row['total'], 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">No employees found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Employee listing -->
            <div>
                <h2 class="pb-2 mb-4 text-sm font-semibold border-b sm:text-lg">EMPLOYEE SALARY LISTING</h2>

                <!-- Mobile: stacked cards -->
                <div class="space-y-3 sm:hidden">
                    @forelse ($employees as $employee)
                        <div class="p-3 bg-white rounded-lg border shadow-sm">
                            <div class="flex justify-between items-start gap-2">
                                <div class="text-sm font-medium">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                <div class="text-sm font-semibold whitespace-nowrap">
                                    {{ (float) $employee->salary > 0 ? '₱' . number_format($employee->salary, 2) : 'Not set' }}
                                </div>
                            </div>
                            <div class="mt-1 text-xs text-gray-600">
                                {{ $employee->position?->name ?? 'No position' }} · {{ $employee->position?->department?->name ?? 'Unassigned' }}
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center text-gray-500">No employees found</div>
                    @endforelse
                </div>

                <!-- Desktop / tablet: table -->
                <div class="hidden overflow-x-auto sm:block">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-3 text-left">Employee</th>
                                <th class="py-3 text-left">Position</th>
                                <th class="py-3 text-left">Department</th>
                                <th class="py-3 text-left">Status</th>
                                <th class="py-3 text-right">Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                                <tr class="border-b">
                                    <td class="py-3">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                    <td class="py-3">{{ $employee->position?->name ?? '—' }}</td>
                                    <td class="py-3">{{ $employee->position?->department?->name ?? 'Unassigned' }}</td>
                                    <td class="py-3 capitalize">{{ $employee->status }}</td>
                                    <td class="py-3 text-right whitespace-nowrap {{ (float) $employee->salary > 0 ? 'font-medium' : 'text-error' }}">
                                        {{ (float) $employee->salary > 0 ? '₱' . number_format($employee->salary, 2) : 'Not set' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">No employees found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Signatory Section -->
            <div class="grid grid-cols-1 gap-6 mt-8 sm:grid-cols-3">
                <div class="text-center">
                    <div class="pt-2 border-t border-gray-300">
                        <p class="font-medium">Prepared by</p>
                        <p class="text-sm text-gray-600">HR</p>
                    </div>
                </div>
                <div class="text-center">
                    <div class="pt-2 border-t border-gray-300">
                        <p class="font-medium">Reviewed by</p>
                        <p class="text-sm text-gray-600">Admin</p>
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
                <p>Generated by: {{ auth()->user()->name }}</p>
                <p>Date Generated: {{ now()->format('F d, Y h:i A') }}</p>
            </div>
        </div>
    </div>
</body>

</html>
