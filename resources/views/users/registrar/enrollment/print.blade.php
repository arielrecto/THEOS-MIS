<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollees List - {{ $enrollment->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @page {
            margin: 1cm;
            size: A4;
        }

        body {
            font-family: Arial, sans-serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .header {
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .summary-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-error {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                font-size: 12px;
            }

            .break-after {
                page-break-after: always;
            }
        }
    </style>
</head>

<body class="p-6 bg-white">
    <div class="mb-6 no-print">
        <button onclick="window.print()" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
            <i class="mr-2 fas fa-print"></i>Print List
        </button>
        <button onclick="window.history.back()"
            class="px-4 py-2 ml-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
            <i class="mr-2 fas fa-arrow-left"></i>Back
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">List of Enrollees</h1>
                <p class="text-gray-600">Generated on {{ now()->format('F j, Y h:i A') }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="text-lg font-semibold">{{ $enrollment->name }}</div>
                <div class="text-sm text-gray-600">
                    {{ \Carbon\Carbon::parse($enrollment->start_date)->format('M j, Y') }} -
                    {{ \Carbon\Carbon::parse($enrollment->end_date)->format('M j, Y') }}
                </div>
                <div class="text-sm text-gray-500">
                    Academic Year: {{ $enrollment->academicYear->name ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
        <div class="p-4 bg-green-50 rounded-lg">
            <h3 class="text-sm font-medium text-gray-600">Total Enrollees</h3>
            <p class="text-2xl font-bold text-green-700">{{ $enrollment->enrollees->count() }}</p>
        </div>
        <div class="p-4 bg-blue-50 rounded-lg">
            <h3 class="text-sm font-medium text-gray-600">Grade Levels</h3>
            <p class="text-2xl font-bold text-blue-700">{{ $enrollment->enrollees->groupBy('grade_level')->count() }}
            </p>
        </div>
        <div class="p-4 bg-yellow-50 rounded-lg">
            <h3 class="text-sm font-medium text-gray-600">Status</h3>
            <p class="text-xl font-bold text-yellow-700">
                @if ($enrollment->status === 'active')
                    <span class="px-2 py-1 text-xs text-white bg-green-500 rounded">Active</span>
                @else
                    <span class="px-2 py-1 text-xs text-white bg-gray-500 rounded">Inactive</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Enrollees List -->
    <div class="mb-6">
        <h2 class="mb-3 text-lg font-semibold">Enrollees List</h2>
        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Student Name</th>
                        <th class="px-4 py-3 text-left">Grade Level</th>
                        <th class="px-4 py-3 text-left">Track/Strand</th>
                        <th class="px-4 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse($enrollment->enrollees as $index => $enrollee)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium">
                                    {{ $enrollee->last_name }}, {{ $enrollee->first_name }}
                                    {{ $enrollee->middle_name ? $enrollee->middle_name[0] . '.' : '' }}
                                    {{ $enrollee->extension_name ?: '' }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                {{ $enrollee->grade_level }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $enrollee->preferred_track }}
                                {{ $enrollee->preferred_strand ? ' - ' . $enrollee->preferred_strand : '' }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusClass =
                                        [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'enrolled' => 'bg-blue-100 text-blue-800',
                                        ][$enrollee->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                    {{ ucfirst($enrollee->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                No enrollees found for this enrollment period.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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

    <!-- Summary -->
    <div class="p-4 mt-8 text-xs text-gray-500 border-t border-gray-200">
        <p>This is a computer-generated document. No signature is required.</p>
        <p class="mt-1">Generated by {{ config('app.name') }} on {{ now()->format('F j, Y \a\t h:i A') }}</p>
    </div>

    <script>
        // Auto-print when the page loads if print parameter is present
        window.onload = function() {
            if (window.location.search.includes('print=true')) {
                window.print();
            }
        };
    </script>
</body>

</html>
