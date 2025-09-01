<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent">Dashboard</a>
                <i class="fi fi-rr-angle-right"></i>
                <a href="{{ route('hr.positions.index') }}" class="hover:text-accent">Positions</a>
                <i class="fi fi-rr-angle-right"></i>
                <span>{{ $position->name }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $position->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $position->department->name }}</p>
                </div>
                <div class="flex items-center gap-2">
                    {{-- <button class="btn btn-ghost btn-sm gap-2" onclick="window.print()">
                        <i class="fi fi-rr-print"></i>
                        Print
                    </button> --}}
                    <a href="{{ route('hr.positions.edit', $position) }}"
                       class="btn btn-accent btn-sm gap-2">
                        <i class="fi fi-rr-edit"></i>
                        Edit Position
                    </a>
                    <a href="{{ route('hr.applicants.index', ['position' => $position->id]) }}"
                       class="btn btn-ghost btn-sm gap-2">
                        <i class="fi fi-rr-shuffle"></i>
                        Hiring Process
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Position Details -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Position Details</h2>

                    <div class="divide-y">
                        <div class="py-3">
                            <label class="text-sm font-medium text-gray-600">Status</label>
                            <div class="mt-1 flex items-center gap-3">
                                <div class="badge {{
                                    $position->status === 'active' ? 'badge-success' :
                                    ($position->status === 'draft' ? 'badge-warning' : 'badge-error')
                                }}">
                                    {{ ucfirst($position->status) }}
                                </div>
                                @if($position->is_hiring)
                                    <div class="badge badge-accent">Hiring</div>
                                @endif
                            </div>
                        </div>

                        <div class="py-3">
                            <label class="text-sm font-medium text-gray-600">Employment Type</label>
                            <p class="mt-1 text-gray-700">{{ ucfirst($position->type) }}</p>
                        </div>

                        <div class="py-3">
                            <label class="text-sm font-medium text-gray-600">Salary Range</label>
                            <p class="mt-1 text-gray-700">₱{{ number_format($position->min_salary) }} - ₱{{ number_format($position->max_salary) }}</p>
                        </div>

                        <div class="py-3">
                            <label class="text-sm font-medium text-gray-600">Description</label>
                            <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $position->description }}</p>
                        </div>

                        <div class="py-3">
                            <label class="text-sm font-medium text-gray-600">Created</label>
                            <p class="mt-1 text-gray-700">{{ $position->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Position Statistics</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-accent/5 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-600">Current Employees</p>
                            <p class="text-2xl font-bold text-accent">{{ $position->employees_count }}</p>
                        </div>
                        <div class="bg-accent/5 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-600">Active Applications</p>
                            <p class="text-2xl font-bold text-accent">{{ $position->applicants()->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <!-- Current Employees -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-800">Current Employees</h2>
                    </div>
                    <div class="p-6">
                        @if($position->employees->count() > 0)
                            <div class="divide-y">
                                @foreach($position->employees as $employee)
                                    <div class="py-4 flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="avatar">
                                                <div class="w-10 h-10 rounded-full">
                                                    <img src="{{  asset('/storage/' . $employee->photo)}}" alt="Avatar">
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="font-medium capitalize">{{ $employee->last_name . ', ' . $employee->first_name }}</h3>
                                                <p class="text-sm text-gray-600">Since {{ date('M Y', strtotime($employee->created_at))  }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('hr.employees.show', $employee) }}"
                                           class="btn btn-ghost btn-sm">
                                            View Profile
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500">
                                No employees currently in this position
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Job Applications -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6 border-b flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Recent Applications</h2>
                            <p class="text-sm text-gray-600 mt-1">Manage applications for this position</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($position->is_hiring)
                                <span class="badge badge-accent">Currently Accepting Applications</span>
                            @endif
                            <a href="{{ route('hr.applicants.index', ['position' => $position->id]) }}"
                               class="btn btn-sm">
                                View All Applications
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($position->applicants->count() > 0)
                            <div class="divide-y">
                                @foreach($position->applicants as $applicant)
                                    <div class="py-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="font-medium">{{ $applicant->name }}</h3>
                                                <div class="flex items-center gap-4 mt-1">
                                                    <span class="text-sm text-gray-600">{{ $applicant->email }}</span>
                                                    <span class="text-sm text-gray-600">{{ $applicant->phone }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="badge {{
                                                    $applicant->status === 'pending' ? 'badge-warning' :
                                                    ($applicant->status === 'approved' ? 'badge-success' : 'badge-error')
                                                }}">
                                                    {{ ucfirst($applicant->status) }}
                                                </span>
                                                <div class="dropdown dropdown-end">
                                                    <button class="btn btn-ghost btn-sm">
                                                        <i class="fi fi-rr-menu-dots-vertical"></i>
                                                    </button>
                                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
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
                            <div class="text-center py-6 text-gray-500">
                                No applications received yet
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Monthly Applications -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Monthly Applications</h2>
                    @foreach($monthlyApplications as $month => $total)
                        <div>
                            <span>{{ \Carbon\Carbon::parse($month)->format('F Y') }}</span>
                            <span>{{ $total }} applications</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
