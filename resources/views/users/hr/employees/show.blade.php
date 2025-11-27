<x-dashboard.hr.base>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="mb-6">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600 mb-4 flex-wrap">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent truncate">Dashboard</a>
                <i class="fi fi-rr-angle-right flex-shrink-0"></i>
                <a href="{{ route('hr.employees.index') }}" class="hover:text-accent truncate">Employees</a>
                <i class="fi fi-rr-angle-right flex-shrink-0"></i>
                <span class="truncate max-w-xs">{{ $employee->first_name }} {{ $employee->last_name }}</span>
            </div>

            <!-- Title and Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="text-lg sm:text-2xl lg:text-3xl font-bold text-gray-800 leading-tight">Employee Profile</h1>
                    <div class="mt-2 flex items-center gap-2 flex-wrap">
                        <span class="text-xs sm:text-sm text-gray-600">Status:</span>
                        @if($employee->status == 'active')
                            <span class="badge badge-success text-xs sm:text-sm gap-1">
                                <i class="fi fi-rr-check"></i>
                                <span>Active</span>
                            </span>
                        @else
                            <span class="badge badge-error text-xs sm:text-sm gap-1">
                                <i class="fi fi-rr-ban"></i>
                                <span>{{ ucfirst($employee->status) }}</span>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('hr.employees.print', $employee) }}" class="btn btn-ghost btn-sm gap-2 text-xs sm:text-sm">
                        <i class="fi fi-rr-print"></i>
                        <span class="hidden sm:inline">Print</span>
                    </a>
                    <a href="{{ route('hr.employees.edit', $employee) }}" class="btn btn-accent btn-sm gap-2 text-xs sm:text-sm">
                        <i class="fi fi-rr-edit"></i>
                        <span class="hidden sm:inline">Edit Profile</span>
                        <span class="sm:hidden">Edit</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Grid: 1 column on mobile, 3 on lg -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Basic Information Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <!-- Avatar and Name -->
                    <div class="flex flex-col items-center text-center">
                        <div class="avatar mb-4 flex-shrink-0">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden ring ring-offset-2 ring-accent">
                                @if($employee->photo)
                                    <img src="{{ Storage::url($employee->photo) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <div class="bg-accent/10 w-full h-full flex items-center justify-center">
                                        <i class="fi fi-rr-user text-accent text-2xl sm:text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <h2 class="text-base sm:text-lg lg:text-xl font-bold text-gray-800 break-words">
                            {{ $employee->first_name }} {{ $employee->last_name }}
                        </h2>

                        @if($employee->position)
                            <p class="text-xs sm:text-sm lg:text-base text-gray-600 mt-1 break-words">{{ $employee->position->name }}</p>
                            @if($employee->position->department)
                                <p class="text-xs text-gray-500 mt-1">{{ $employee->position->department->name }}</p>
                            @else
                                <p class="text-xs text-error mt-1">Department Not Assigned</p>
                            @endif
                        @else
                            <p class="text-xs text-error mt-1">Position Not Assigned</p>
                        @endif
                    </div>

                    <div class="divider my-4"></div>

                    <!-- Contact Information -->
                    <div class="space-y-3 text-xs sm:text-sm lg:text-base">
                        <div>
                            <label class="font-medium text-gray-600 text-xs sm:text-sm">Email Address</label>
                            <p class="mt-1 break-all text-xs sm:text-sm">{{ $employee->user->email }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600 text-xs sm:text-sm">Phone Number</label>
                            <p class="mt-1 text-xs sm:text-sm">{{ $employee->phone ?? 'Not provided' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600 text-xs sm:text-sm">Date of Birth</label>
                            <p class="mt-1 text-xs sm:text-sm">{{ $employee->date_of_birth?->format('F d, Y') ?? 'Not provided' }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600 text-xs sm:text-sm">Address</label>
                            <p class="mt-1 text-xs sm:text-sm break-words">{{ $employee->address ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Details Card -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg lg:text-xl font-semibold text-gray-800 mb-4">Employment Details</h3>

                    <!-- Grid: 1 col on mobile, 2 cols on sm, 2 cols on lg -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 text-xs sm:text-sm lg:text-base">
                        <div>
                            <label class="font-medium text-gray-600 text-xs sm:text-sm">Employee ID</label>
                            <p class="mt-1 text-xs sm:text-sm">{{ str_pad($employee->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600 text-xs sm:text-sm">Date Hired</label>
                            <p class="mt-1 text-xs sm:text-sm">{{ $employee->created_at->format('F d, Y') }}</p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600 text-xs sm:text-sm">Department</label>
                            <p class="mt-1 text-xs sm:text-sm break-words">
                                @if($employee->position?->department)
                                    {{ $employee->position->department->name }}
                                @else
                                    <span class="text-error">Not Assigned</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600 text-xs sm:text-sm">Position</label>
                            <p class="mt-1 text-xs sm:text-sm break-words">
                                @if($employee->position)
                                    {{ $employee->position->name }}
                                @else
                                    <span class="text-error">Not Assigned</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600 text-xs sm:text-sm">Employment Type</label>
                            <p class="mt-1 text-xs sm:text-sm">
                                @if($employee->position)
                                    {{ ucfirst($employee->position->type) }}
                                @else
                                    <span class="text-error">Not Assigned</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="font-medium text-gray-600 text-xs sm:text-sm">Salary</label>
                            <p class="mt-1 text-xs sm:text-sm font-semibold">
                                @if($employee->salary)
                                    ₱{{ number_format($employee->salary, 2) }}
                                @else
                                    <span class="text-error">Not Set</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if(!$employee->position)
                        <div class="mt-6 alert alert-warning text-xs sm:text-sm gap-2">
                            <i class="fi fi-rr-exclamation flex-shrink-0"></i>
                            <span>This employee needs to be assigned to a position. Click the Edit Profile button to update.</span>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons Section -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h3 class="text-sm sm:text-base font-semibold text-gray-800 mb-3">Quick Actions</h3>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('hr.employees.show', $employee) }}" class="btn btn-ghost btn-sm text-xs sm:text-sm gap-2">
                            <i class="fi fi-rr-eye"></i>
                            <span class="hidden sm:inline">View</span>
                        </a>

                        <a href="{{ route('hr.employees.edit', $employee) }}" class="btn btn-accent btn-sm text-xs sm:text-sm gap-2">
                            <i class="fi fi-rr-edit"></i>
                            <span class="hidden sm:inline">Edit</span>
                        </a>

                        <form action="{{ route('hr.employees.toggle-teacher', $employee) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="btn btn-sm text-xs sm:text-sm gap-2 {{ $employee->user->hasRole('teacher') ? 'btn-primary' : 'btn-ghost' }}"
                                    title="{{ $employee->user->hasRole('teacher') ? 'Remove Teacher Role' : 'Add Teacher Role' }}">
                                <i class="fi fi-rr-graduation-cap"></i>
                                <span class="hidden sm:inline">Teacher</span>
                            </button>
                        </form>

                        <form action="{{ route('hr.employees.toggle-registrar', $employee) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="btn btn-sm text-xs sm:text-sm gap-2 {{ $employee->user->hasRole('registrar') ? 'btn-info' : 'btn-ghost' }}"
                                    title="{{ $employee->user->hasRole('registrar') ? 'Remove Registrar Role' : 'Add Registrar Role' }}">
                                <i class="fi fi-rr-diploma"></i>
                                <span class="hidden sm:inline">Registrar</span>
                            </button>
                        </form>

                        <form action="{{ route('hr.employees.toggle-archive', $employee) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="btn btn-sm text-xs sm:text-sm gap-2 {{ $employee->status === 'archived' ? 'btn-info' : 'btn-ghost' }}"
                                    title="{{ $employee->status === 'archived' ? 'Unarchive Employee' : 'Archive Employee' }}">
                                <i class="fi fi-rr-folder-download"></i>
                                <span class="hidden sm:inline">Archive</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
