<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent">Dashboard</a>
                <i class="fi fi-rr-angle-right"></i>
                <a href="{{ route('hr.employees.index') }}" class="hover:text-accent">Employees</a>
                <i class="fi fi-rr-angle-right"></i>
                <span>{{ $employee->first_name }} {{ $employee->last_name }}</span>
            </div>

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800">Employee Profile</h1>
                <div class="flex items-center gap-2">
                    <button class="btn btn-ghost btn-sm gap-2" onclick="window.print()">
                        <i class="fi fi-rr-print"></i>
                        Print
                    </button>
                    <a href="{{ route('hr.employees.edit', $employee) }}"
                       class="btn btn-accent btn-sm gap-2">
                        <i class="fi fi-rr-edit"></i>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Basic Information -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex flex-col items-center text-center">
                        <div class="avatar mb-4">
                            <div class="w-24 h-24 rounded-full">
                                @if($employee->photo)
                                    <img src="{{ Storage::url($employee->photo) }}" alt="Avatar">
                                @else
                                    <div class="bg-accent/10 w-full h-full flex items-center justify-center">
                                        <i class="fi fi-rr-user text-accent text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <h2 class="text-xl font-bold">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
                        @if($employee->position)
                            <p class="text-gray-600">{{ $employee->position->name }}</p>
                            @if($employee->position->department)
                                <p class="text-sm text-gray-500">{{ $employee->position->department->name }}</p>
                            @else
                                <p class="text-sm text-error">Department Not Assigned</p>
                            @endif
                        @else
                            <p class="text-sm text-error">Position Not Assigned</p>
                        @endif
                    </div>

                    <div class="divider"></div>

                    <div class="space-y-4">
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

            <div class="lg:col-span-2 space-y-6">
                <!-- Employment Details -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Employment Details</h3>

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
                            <label class="text-sm font-medium text-gray-600">Department</label>
                            <p class="mt-1">
                                @if($employee->position?->department)
                                    {{ $employee->position->department->name }}
                                @else
                                    <span class="text-error">Not Assigned</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Position</label>
                            <p class="mt-1">
                                @if($employee->position)
                                    {{ $employee->position->name }}
                                @else
                                    <span class="text-error">Not Assigned</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Employment Type</label>
                            <p class="mt-1">
                                @if($employee->position)
                                    {{ ucfirst($employee->position->type) }}
                                @else
                                    <span class="text-error">Not Assigned</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Salary</label>
                            <p class="mt-1">
                                @if($employee->salary)
                                    ₱{{ number_format($employee->salary, 2) }}
                                @else
                                    <span class="text-error">Not Set</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if(!$employee->position)
                        <div class="mt-6 alert alert-warning">
                            <i class="fi fi-rr-exclamation"></i>
                            <span>This employee needs to be assigned to a position. Click the Edit Profile button to update.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
