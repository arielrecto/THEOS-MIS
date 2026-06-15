@php use App\Models\Logo; $logo = Logo::where('is_active', true)->first()?->path ?? null; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolled Classrooms – {{ $student->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            #no-print { display: none; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
        .field-label { font-size: 0.75rem; color: #555; }
        .underline-field { border-bottom: 1px solid #333; min-height: 1.5rem; padding-bottom: 2px; font-weight: 500; }
    </style>
</head>
<body class="p-4 bg-gray-100 sm:p-8">

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

    <div class="mx-auto max-w-4xl bg-white shadow-lg">

        {{-- Header --}}
        <div class="flex justify-between items-center p-6 border-b">
            <div>
                <h1 class="text-3xl font-bold text-blue-900">THEOS HIGHER GROUND ACADEME</h1>
                <p class="text-sm text-gray-500 mt-1">Enrolled Classrooms Report</p>
                <p class="text-xs text-gray-400">Generated: {{ now()->format('F d, Y – h:i A') }}</p>
            </div>
            @if($logo)
                <img src="{{ asset('storage/' . $logo) }}" alt="School Logo" class="w-20 h-20 object-contain">
            @else
                <img src="{{ asset('logo-modified.png') }}" alt="School Logo" class="w-20 h-20 object-contain">
            @endif
        </div>

        {{-- Student Info --}}
        <div class="p-6 border-b bg-blue-50">
            <p class="text-xs font-semibold text-blue-700 uppercase tracking-wide mb-3">Student Information</p>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="field-label">Name</p>
                    <p class="font-semibold text-gray-800">
                        {{ trim(collect([
                            $student->studentProfile?->last_name,
                            $student->studentProfile?->first_name,
                            $student->studentProfile?->middle_name,
                        ])->filter()->join(', ')) ?: $student->name }}
                    </p>
                </div>
                <div>
                    <p class="field-label">LRN</p>
                    <p class="font-semibold text-gray-800">{{ $student->studentProfile?->lrn ?? '—' }}</p>
                </div>
                <div>
                    <p class="field-label">Email</p>
                    <p class="text-gray-700">{{ $student->email }}</p>
                </div>
                <div>
                    <p class="field-label">Total Classrooms</p>
                    <p class="font-bold text-blue-800">{{ $student->asStudentClassrooms->count() }}</p>
                </div>
            </div>
        </div>

        {{-- Classrooms Table --}}
        <div class="p-6">
            <p class="text-xs font-semibold text-blue-700 uppercase tracking-wide mb-4">Enrolled Classrooms</p>
            @if($student->asStudentClassrooms->count())
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="text-left px-3 py-2">#</th>
                            <th class="text-left px-3 py-2">Classroom</th>
                            <th class="text-left px-3 py-2">Subject</th>
                            <th class="text-left px-3 py-2">Teacher</th>
                            <th class="text-left px-3 py-2">Grade Level</th>
                            <th class="text-left px-3 py-2">School Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->asStudentClassrooms as $i => $cs)
                            @php $room = $cs->classroom; @endphp
                            <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} border-b border-gray-200">
                                <td class="px-3 py-2 text-gray-500">{{ $i + 1 }}</td>
                                <td class="px-3 py-2">
                                    <p class="font-semibold text-gray-800">{{ $room->name ?? '—' }}</p>
                                    <p class="text-xs text-gray-400">{{ $room->class_code ?? '' }}</p>
                                </td>
                                <td class="px-3 py-2">{{ $room->subject?->name ?? '—' }}</td>
                                <td class="px-3 py-2">{{ $room->teacher?->name ?? '—' }}</td>
                                <td class="px-3 py-2">{{ $room->strand?->name ?? '—' }}</td>
                                <td class="px-3 py-2 text-gray-500">{{ $room->academicYear?->name ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-gray-400 py-8">No classrooms enrolled.</p>
            @endif
        </div>

        {{-- Signature --}}
        <div class="p-6 border-t grid grid-cols-2 gap-12 mt-4">
            <div>
                <div class="border-b-2 border-black h-8 mb-1"></div>
                <p class="text-xs text-center text-gray-600">Prepared by</p>
                <p class="text-xs text-center text-gray-400">Admin</p>
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
