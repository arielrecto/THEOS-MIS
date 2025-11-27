<x-dashboard.hr.base>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="mb-6">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600 mb-4 flex-wrap">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent truncate">Dashboard</a>
                <i class="fi fi-rr-angle-right flex-shrink-0"></i>
                <a href="{{ route('hr.positions.index') }}" class="hover:text-accent truncate">Positions</a>
                <i class="fi fi-rr-angle-right flex-shrink-0"></i>
                <span class="truncate">{{ $position->name }}</span>
            </div>

            <!-- Title and Actions -->
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="text-lg sm:text-2xl lg:text-3xl font-bold text-gray-800 truncate">{{ $position->name }}</h1>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1 truncate">{{ $position->department->name }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                    <a href="{{ route('hr.positions.edit', $position) }}"
                       class="btn btn-accent btn-sm gap-2 text-xs sm:text-sm whitespace-nowrap">
                        <i class="fi fi-rr-edit"></i>
                        <span class="hidden sm:inline">Edit Position</span>
                        <span class="sm:hidden">Edit</span>
                    </a>
                    <a href="{{ route('hr.applicants.index', ['position' => $position->id]) }}"
                       class="btn btn-ghost btn-sm gap-2 text-xs sm:text-sm whitespace-nowrap">
                        <i class="fi fi-rr-shuffle"></i>
                        <span class="hidden sm:inline">Hiring Process</span>
                        <span class="sm:hidden">Hiring</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Position Details Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Position Details</h2>

                    <div class="divide-y space-y-4">
                        <div>
                            <label class="text-xs sm:text-sm font-medium text-gray-600">Status</label>
                            <div class="mt-2 flex items-center gap-2 flex-wrap">
                                <div class="badge text-xs sm:text-sm {{
                                    $position->status === 'active' ? 'badge-success' :
                                    ($position->status === 'draft' ? 'badge-warning' : 'badge-error')
                                }}">
                                    {{ ucfirst($position->status) }}
                                </div>
                                @if($position->is_hiring)
                                    <div class="badge badge-accent text-xs sm:text-sm">Hiring</div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="text-xs sm:text-sm font-medium text-gray-600">Employment Type</label>
                            <p class="mt-2 text-xs sm:text-sm text-gray-700">{{ ucfirst($position->type) }}</p>
                        </div>

                        <div>
                            <label class="text-xs sm:text-sm font-medium text-gray-600">Salary Range</label>
                            <p class="mt-2 text-xs sm:text-sm text-gray-700 break-words">
                                ₱{{ number_format($position->min_salary) }} - ₱{{ number_format($position->max_salary) }}
                            </p>
                        </div>

                        <div>
                            <label class="text-xs sm:text-sm font-medium text-gray-600">Description</label>
                            <p class="mt-2 text-xs sm:text-sm text-gray-700 whitespace-pre-line break-words">{{ $position->description }}</p>
                        </div>

                        <div>
                            <label class="text-xs sm:text-sm font-medium text-gray-600">Created</label>
                            <p class="mt-2 text-xs sm:text-sm text-gray-700">{{ $position->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Position Statistics</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-accent/5 rounded-lg p-4">
                            <p class="text-xs sm:text-sm font-medium text-gray-600">Current Employees</p>
                            <p class="text-2xl sm:text-3xl font-bold text-accent mt-2">{{ $position->employees_count }}</p>
                        </div>
                        <div class="bg-accent/5 rounded-lg p-4">
                            <p class="text-xs sm:text-sm font-medium text-gray-600">Active Applications</p>
                            <p class="text-2xl sm:text-3xl font-bold text-accent mt-2">{{ $position->applicants()->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Current Employees -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4 sm:p-6 border-b">
                        <h2 class="text-base sm:text-lg font-semibold text-gray-800">Current Employees</h2>
                    </div>
                    <div class="p-4 sm:p-6">
                        @if($position->employees->count() > 0)
                            <div class="divide-y space-y-4">
                                @foreach($position->employees as $employee)
                                    <div class="flex items-center justify-between gap-3 pt-4">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="avatar flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full overflow-hidden">
                                                    <img src="{{ asset('/storage/' . $employee->photo) }}" alt="Avatar" class="object-cover w-full h-full">
                                                </div>
                                            </div>
                                            <div class="min-w-0">
                                                <h3 class="font-medium text-xs sm:text-sm text-gray-800 truncate">{{ $employee->last_name . ', ' . $employee->first_name }}</h3>
                                                <p class="text-xs text-gray-600 truncate">Since {{ date('M Y', strtotime($employee->created_at)) }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('hr.employees.show', $employee) }}"
                                           class="btn btn-ghost btn-xs sm:btn-sm text-xs whitespace-nowrap">
                                            View
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500 text-xs sm:text-sm">
                                No employees currently in this position
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Job Applications -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4 sm:p-6 border-b">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="min-w-0">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-800">Recent Applications</h2>
                                <p class="text-xs sm:text-sm text-gray-600 mt-1">Manage applications for this position</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                @if($position->is_hiring)
                                    <span class="badge badge-accent text-xs">Accepting</span>
                                @endif
                                <a href="{{ route('hr.applicants.index', ['position' => $position->id]) }}"
                                   class="btn btn-sm text-xs">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        @if($position->applicants->count() > 0)
                            <div class="divide-y space-y-4">
                                @foreach($position->applicants as $applicant)
                                    <div class="pt-4">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                            <div class="min-w-0">
                                                <h3 class="font-medium text-xs sm:text-sm text-gray-800 truncate">{{ $applicant->name }}</h3>
                                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 mt-1 text-xs text-gray-600 flex-wrap">
                                                    <span class="truncate">{{ $applicant->email }}</span>
                                                    <span class="truncate">{{ $applicant->phone }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 sm:gap-3">
                                                <span class="badge text-xs {{
                                                    $applicant->status === 'pending' ? 'badge-warning' :
                                                    ($applicant->status === 'approved' ? 'badge-success' : 'badge-error')
                                                }}">
                                                    {{ ucfirst($applicant->status) }}
                                                </span>
                                                <div class="dropdown dropdown-end">
                                                    <button class="btn btn-ghost btn-xs sm:btn-sm text-xs">
                                                        <i class="fi fi-rr-menu-dots-vertical"></i>
                                                    </button>
                                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-48 sm:w-52 text-xs sm:text-sm">
                                                        <li>
                                                            <a href="#">
                                                                View Application
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                Download Resume
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500 text-xs sm:text-sm">
                                No applications received yet
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Monthly Applications -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Monthly Applications</h2>
                    <div class="space-y-2 text-xs sm:text-sm">
                        @foreach($monthlyApplications as $month => $total)
                            <div class="flex items-center justify-between py-2 border-b">
                                <span class="text-gray-600">{{ \Carbon\Carbon::parse($month)->format('F Y') }}</span>
                                <span class="font-semibold text-gray-800">{{ $total }} applications</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
