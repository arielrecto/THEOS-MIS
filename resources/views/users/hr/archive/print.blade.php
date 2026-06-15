@php use App\Models\Logo; $reportLogo = Logo::where('is_active', true)->first()?->path ?? null; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Employees – {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            #no-print { display: none; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background: white; }
            @page { margin: 1cm; size: portrait; }
        }
    </style>
</head>
<body class="bg-gray-100 p-4 sm:p-8">

    <div class="flex fixed top-4 right-4 z-50 gap-3" id="no-print">
        <a href="{{ url()->previous() }}"
           class="px-4 py-2 font-semibold text-black bg-gray-200 rounded-lg shadow hover:bg-gray-300">
            Back
        </a>
        <button onclick="document.getElementById('no-print').style.display='none'; window.print(); document.getElementById('no-print').style.display='flex';"
                class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">
            Print
        </button>
    </div>

    <div class="mx-auto max-w-5xl bg-white shadow-lg">

        {{-- Header --}}
        <div class="p-6 border-b text-center">
            <div class="flex justify-center mb-3">
                @if($reportLogo)
                    <img src="{{ asset('storage/' . $reportLogo) }}" alt="School Logo" class="w-20 h-20 object-contain">
                @else
                    <img src="{{ asset('logo-modified.png') }}" alt="School Logo" class="w-20 h-20 object-contain">
                @endif
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ config('app.name') }}</h1>
            <h2 class="text-lg font-semibold text-gray-700 mt-1">ARCHIVED EMPLOYEES REPORT</h2>
            <p class="text-xs text-gray-500 mt-1">Generated: {{ now()->format('F d, Y – h:i A') }}</p>
        </div>

        {{-- Summary --}}
        <div class="px-6 py-4 border-b bg-gray-50">
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600">Total Archived Employees:</span>
                <span class="font-bold text-gray-800 text-lg">{{ $employees->count() }}</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="p-6">
            @if($employees->count())
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="text-left px-3 py-2">#</th>
                            <th class="text-left px-3 py-2">Employee</th>
                            <th class="text-left px-3 py-2">Position</th>
                            <th class="text-left px-3 py-2">Department</th>
                            <th class="text-left px-3 py-2">Contact</th>
                            <th class="text-left px-3 py-2">Archived Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $i => $employee)
                            <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} border-b border-gray-200">
                                <td class="px-3 py-2 text-gray-500">{{ $i + 1 }}</td>
                                <td class="px-3 py-2">
                                    <p class="font-semibold text-gray-800">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                                    <p class="text-xs text-gray-400">{{ $employee->user?->email ?? '—' }}</p>
                                </td>
                                <td class="px-3 py-2 text-gray-700">{{ $employee->position?->name ?? '—' }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $employee->position?->department?->name ?? '—' }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $employee->phone ?? '—' }}</td>
                                <td class="px-3 py-2 text-gray-500">{{ $employee->updated_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-gray-400 py-8">No archived employees found.</p>
            @endif
        </div>

        {{-- Signature --}}
        <div class="p-6 border-t grid grid-cols-2 gap-12 mt-4">
            <div>
                <div class="border-b-2 border-black h-8 mb-1"></div>
                <p class="text-xs text-center text-gray-600">Prepared by</p>
                <p class="text-xs text-center text-gray-400">HR</p>
            </div>
            <div>
                <div class="border-b-2 border-black h-8 mb-1"></div>
                <p class="text-xs text-center text-gray-600">Noted by</p>
                <p class="text-xs text-center text-gray-400">Principal</p>
            </div>
        </div>

    </div>
</body>
</html>
