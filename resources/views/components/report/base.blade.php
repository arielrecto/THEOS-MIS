{{--
    Shared printable report (browser "Save as PDF / Print").
    One header / logo / signature design for every list report in the system.

    Usage:
    <x-report.base title="Student Records Report" info-title="Report Information"
                   section-title="Student Records" :back-url="...">
        <x-slot:info> ...grid of <x-report.field> ... </x-slot:info>
        ...table...
    </x-report.base>
--}}
@props([
    'title',
    'sectionTitle' => null,
    'infoTitle' => 'Report Information',
    'backUrl' => null,
    'preparedBy' => 'Admin',
    'notedBy' => 'Principal',
])

@php
    use App\Models\Logo;

    $logo = Logo::where('type', 'main')->where('is_active', true)->latest()->first()?->path;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} – {{ config('school.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page { size: A4; margin: 12mm; }
        @media print {
            #no-print { display: none !important; }
            body { background: #fff !important; padding: 0 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .report { box-shadow: none !important; max-width: none !important; }
            thead { display: table-header-group; }
            tr { page-break-inside: avoid; }
        }
        .field-label { font-size: 0.75rem; color: #555; }
    </style>
</head>
<body class="p-4 bg-gray-100 sm:p-8">

    <div class="flex fixed top-4 right-4 z-50 gap-3" id="no-print">
        <a href="{{ $backUrl ?? url()->previous() }}"
           class="px-4 py-2 font-semibold text-black bg-gray-200 rounded-lg shadow hover:bg-gray-300">
            Back
        </a>
        <button onclick="window.print()"
                class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">
            Save as PDF / Print
        </button>
    </div>

    <div class="mx-auto max-w-4xl bg-white shadow-lg report">

        {{-- Header --}}
        <div class="flex justify-between items-center p-6 border-b">
            <div>
                <h1 class="text-3xl font-bold text-blue-900 uppercase">{{ config('school.name') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ $title }}</p>
                <p class="text-xs text-gray-400">Generated: {{ now()->format('F d, Y – h:i A') }}</p>
            </div>
            <img src="{{ $logo ? asset('storage/' . $logo) : asset('logo-modified.png') }}"
                 onerror="this.src='{{ asset('logo-modified.png') }}'"
                 alt="School Logo" class="object-contain w-20 h-20">
        </div>

        {{-- Info panel --}}
        @isset($info)
            <div class="p-6 border-b bg-blue-50">
                <p class="mb-3 text-xs font-semibold tracking-wide text-blue-700 uppercase">{{ $infoTitle }}</p>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    {{ $info }}
                </div>
            </div>
        @endisset

        {{-- Body --}}
        <div class="p-6">
            @if ($sectionTitle)
                <p class="mb-4 text-xs font-semibold tracking-wide text-blue-700 uppercase">{{ $sectionTitle }}</p>
            @endif
            {{ $slot }}
        </div>

        {{-- Signature --}}
        <div class="grid grid-cols-2 gap-12 p-6 mt-4 border-t">
            <div>
                <div class="mb-1 h-8 border-b-2 border-black"></div>
                <p class="text-xs text-center text-gray-600">Prepared by</p>
                <p class="text-xs text-center text-gray-400">{{ $preparedBy }}</p>
            </div>
            <div>
                <div class="mb-1 h-8 border-b-2 border-black"></div>
                <p class="text-xs text-center text-gray-600">Noted by</p>
                <p class="text-xs text-center text-gray-400">{{ $notedBy }}</p>
            </div>
        </div>

    </div>
</body>
</html>
