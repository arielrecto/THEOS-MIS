<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Data - {{ $employee->first_name }} {{ $employee->last_name }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            @page {
                margin: 2cm;
            }

            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <!-- Action Buttons -->
        <div class="flex justify-end gap-2 mb-4 no-print">
            <a href="{{ route('hr.employees.index') }}" class="btn btn-ghost">
                <i class="fi fi-rr-arrow-left"></i>
                Back
            </a>
            <button onclick="window.print()" class="btn btn-accent">
                <i class="fi fi-rr-print"></i>
                Print
            </button>
        </div>

        <!-- Header -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('logo.jpg') }}" alt="School Logo" class="w-16 h-16 object-contain">
                    <div>
                        <h1 class="text-2xl font-bold">Employee Information</h1>
                        <p class="text-gray-600">Theos Higher Ground Academe</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500">Generated: {{ now()->format('F d, Y') }}</p>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-start gap-6">
                <div class="flex-shrink-0">
                    <div class="w-32 h-32 rounded-lg overflow-hidden">
                        @if ($employee->photo)
                        <img src="{{ Storage::url($employee->photo) }}" alt="Employee Photo" class="w-full h-full object-cover">
                        @else
                        <div class="bg-accent/10 w-full h-full flex items-center justify-center">
                            <i class="fi fi-rr-user text-accent text-3xl"></i>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="flex-grow">
                    <h2 class="text-2xl font-bold mb-4">{{ $employee->first_name }} {{ $employee->last_name }}</h2>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Employee ID</label>
                            <p class="mt-1">{{ str_pad($employee->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Date Hired</label>
                            <p class="mt-1">{{ $employee->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Email Address</label>
                            <p class="mt-1">{{ $employee->user->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Phone Number</label>
                            <p class="mt-1">{{ $employee->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Date of Birth</label>
                            <p class="mt-1">{{ $employee->date_of_birth?->format('F d, Y') ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Address</label>
                            <p class="mt-1">{{ $employee->address ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employment Details -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Employment Details</h3>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-600">Department</label>
                    <p class="mt-1">
                        @if ($employee->position?->department)
                        {{ $employee->position->department->name }}
                        @else
                        <span class="text-error">Not Assigned</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Position</label>
                    <p class="mt-1">
                        @if ($employee->position)
                        {{ $employee->position->name }}
                        @else
                        <span class="text-error">Not Assigned</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Employment Type</label>
                    <p class="mt-1">
                        @if ($employee->position)
                        {{ ucfirst($employee->position->type) }}
                        @else
                        <span class="text-error">Not Assigned</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Salary</label>
                    <p class="mt-1">
                        @if ($employee->salary)
                        ₱{{ number_format($employee->salary, 2) }}
                        @else
                        <span class="text-error">Not Set</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
