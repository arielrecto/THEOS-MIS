<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Report – {{ $selectedYear?->name ?? 'All Years' }} – {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            body { background: white; margin: 0; padding: 0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .print\:hidden { display: none !important; }
            .print\:p-0 { padding: 0 !important; }
            .print\:shadow-none { box-shadow: none !important; }
            table { width: 100%; break-inside: auto; }
            tr { break-inside: avoid; }
            thead { display: table-header-group; }
            @page { margin: 1cm; size: landscape; }
        }
    </style>
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-6 print:p-0">

    {{-- Controls (hidden on print) --}}
    <div class="mb-6 print:hidden">
        <div class="flex flex-wrap items-center gap-3 mb-4">
            <a href="{{ route('registrar.reports.index') }}" class="btn btn-ghost btn-sm gap-2">
                <i class="fi fi-rr-arrow-left"></i> Back
            </a>
            <button onclick="window.print()" class="btn btn-accent btn-sm gap-2 text-white">
                <i class="fi fi-rr-print"></i> Print Report
            </button>
        </div>

        <form method="GET" class="flex flex-wrap gap-3">
            <select name="academic_year_id" class="text-xs select select-bordered select-sm">
                <option value="">All School Years</option>
                @foreach($academicYears as $ay)
                    <option value="{{ $ay->id }}" {{ request('academic_year_id') == $ay->id ? 'selected' : '' }}>
                        {{ $ay->name }}{{ $ay->status === 'active' ? ' (Active)' : '' }}
                    </option>
                @endforeach
            </select>
            <select name="grade_level" class="text-xs select select-bordered select-sm">
                <option value="">All Grade Levels</option>
                @foreach($gradeLevels as $level)
                    <option value="{{ $level }}" {{ request('grade_level') === $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
            </select>
            <select name="status" class="text-xs select select-bordered select-sm">
                <option value="">All Statuses</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="btn btn-sm btn-neutral gap-2">
                <i class="fi fi-rr-search"></i> Generate
            </button>
            @if(request()->hasAny(['academic_year_id','grade_level','status']))
                <a href="{{ route('registrar.reports.enrollment') }}" class="btn btn-ghost btn-sm">Clear</a>
            @endif
        </form>
    </div>

    {{-- Printable Document --}}
    <div class="bg-white rounded-lg shadow-sm p-8 print:p-0 print:shadow-none">

        {{-- Header --}}
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold uppercase tracking-wide">Enrollment Report</h1>
            <p class="font-semibold text-gray-700 mt-1">{{ config('app.name') }}</p>
            <p class="text-sm text-gray-500">
                School Year: {{ $selectedYear?->name ?? 'All Years' }}
                @if(request('grade_level')) &nbsp;|&nbsp; Grade Level: {{ request('grade_level') }} @endif
                @if(request('status'))      &nbsp;|&nbsp; Status: {{ ucfirst(request('status')) }} @endif
            </p>
            <p class="text-xs text-gray-400 mt-1">Generated: {{ now()->format('F d, Y h:i A') }}</p>
        </div>

        {{-- Summary Stats --}}
        <div class="grid grid-cols-4 gap-4 mb-6 text-center">
            <div class="border rounded-lg p-3">
                <p class="text-2xl font-bold text-gray-800">{{ $summary['total'] }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Total Enrollees</p>
            </div>
            <div class="border rounded-lg p-3">
                <p class="text-2xl font-bold text-green-600">{{ $summary['approved'] }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Approved</p>
            </div>
            <div class="border rounded-lg p-3">
                <p class="text-2xl font-bold text-yellow-500">{{ $summary['pending'] }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Pending</p>
            </div>
            <div class="border rounded-lg p-3">
                <p class="text-2xl font-bold text-red-500">{{ $summary['rejected'] }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Rejected</p>
            </div>
        </div>

        {{-- Enrollee Table --}}
        <h2 class="font-semibold text-gray-700 border-b pb-2 mb-3">Enrollee List</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-300 text-left text-xs uppercase text-gray-600">
                    <th class="py-2 pr-3">#</th>
                    <th class="py-2 pr-3">LRN</th>
                    <th class="py-2 pr-3">Last Name</th>
                    <th class="py-2 pr-3">First Name</th>
                    <th class="py-2 pr-3">Middle Name</th>
                    <th class="py-2 pr-3">Grade Level</th>
                    <th class="py-2 pr-3">School Year</th>
                    <th class="py-2 pr-3">Contact</th>
                    <th class="py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollees as $i => $enrollee)
                    <tr class="border-b border-gray-100 {{ $i % 2 === 0 ? '' : 'bg-gray-50' }}">
                        <td class="py-2 pr-3 text-gray-400">{{ $i + 1 }}</td>
                        <td class="py-2 pr-3">{{ $enrollee->lrn ?? '—' }}</td>
                        <td class="py-2 pr-3 font-medium">{{ $enrollee->last_name }}</td>
                        <td class="py-2 pr-3">{{ $enrollee->first_name }}</td>
                        <td class="py-2 pr-3">{{ $enrollee->middle_name ?? '—' }}</td>
                        <td class="py-2 pr-3">{{ $enrollee->grade_level }}</td>
                        <td class="py-2 pr-3 text-xs text-gray-500">{{ $enrollee->academicYear?->name ?? '—' }}</td>
                        <td class="py-2 pr-3 text-xs">{{ $enrollee->contact_number ?? '—' }}</td>
                        <td class="py-2">
                            <span class="px-2 py-0.5 rounded text-xs font-semibold
                                {{ $enrollee->status === 'approved' ? 'bg-green-100 text-green-700' :
                                   ($enrollee->status === 'pending'  ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($enrollee->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-8 text-center text-gray-400">No enrollees found for the selected criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Signatories --}}
        <div class="grid grid-cols-2 gap-16 mt-16">
            <div class="text-center">
                <p class="font-bold text-gray-800 uppercase">{{ $registrar?->name ?? 'Registrar' }}</p>
                <div class="border-t border-gray-400 mt-1 pt-2">
                    <p class="text-sm font-medium text-gray-600">Registrar</p>
                    <p class="text-xs text-gray-400">Prepared &amp; Certified by</p>
                </div>
            </div>
            <div class="text-center">
                <p class="font-bold text-gray-800 uppercase">{{ $admin?->name ?? 'School Administrator' }}</p>
                <div class="border-t border-gray-400 mt-1 pt-2">
                    <p class="text-sm font-medium text-gray-600">School Administrator</p>
                    <p class="text-xs text-gray-400">Approved by</p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-8 pt-4 border-t text-xs text-gray-400 flex justify-between">
            <span>Generated by: {{ auth()->user()->name }}</span>
            <span>{{ now()->format('F d, Y h:i A') }}</span>
        </div>

    </div>
</div>
</body>
</html>
