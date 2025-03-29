<x-dashboard.hr.base>
    <div class="w-full p-6">
        <!-- Breadcrumb & Actions -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent">Dashboard</a>
                <i class="fi fi-rr-angle-right"></i>
                <a href="{{ route('hr.departments.index') }}" class="hover:text-accent">Departments</a>
                <i class="fi fi-rr-angle-right"></i>
                <span>{{ $department->name }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $department->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $department->code }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-ghost btn-sm gap-2" onclick="window.print()">
                        <i class="fi fi-rr-print"></i>
                        Print
                    </button>
                    <a href="{{ route('hr.departments.edit', $department) }}"
                       class="btn btn-accent btn-sm gap-2">
                        <i class="fi fi-rr-edit"></i>
                        Edit Department
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Department Summary -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Department Info Card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Department Overview</h2>

                    <div class="divide-y">
                        <div class="py-3">
                            <label class="text-sm font-medium text-gray-600">Status</label>
                            <div class="mt-1">
                                <div class="badge {{ $department->is_active ? 'badge-success' : 'badge-error' }} gap-1">
                                    <div class="w-2 h-2 rounded-full bg-current"></div>
                                    {{ $department->is_active ? 'Active' : 'Inactive' }}
                                </div>
                            </div>
                        </div>

                        <div class="py-3">
                            <label class="text-sm font-medium text-gray-600">Description</label>
                            <p class="mt-1 text-gray-700">{{ $department->description ?: 'No description provided' }}</p>
                        </div>

                        <div class="py-3">
                            <label class="text-sm font-medium text-gray-600">Created</label>
                            <p class="mt-1 text-gray-700">{{ $department->created_at->format('M d, Y') }}</p>
                        </div>

                        <div class="py-3">
                            <label class="text-sm font-medium text-gray-600">Last Updated</label>
                            <p class="mt-1 text-gray-700">{{ $department->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Department Statistics</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-accent/5 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-600">Total Positions</p>
                            <p class="text-2xl font-bold text-accent">{{ $department->jobPositions->count() }}</p>
                        </div>
                        <div class="bg-accent/5 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-600">Total Employees</p>
                            <p class="text-2xl font-bold text-accent">{{ $department->jobPositions->sum('employees_count') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Positions Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-6 border-b flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Job Positions</h2>
                            <p class="text-sm text-gray-600 mt-1">Manage positions and their assignments</p>
                        </div>
                        <a href="{{ route('hr.positions.create', $department) }}"
                           class="btn btn-accent btn-sm gap-2">
                            <i class="fi fi-rr-plus"></i>
                            Add Position
                        </a>
                    </div>

                    <div class="p-6">
                        @if($department->jobPositions->count() > 0)
                            <div class="space-y-4">
                                @foreach($department->jobPositions as $position)
                                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3">
                                                    <h3 class="font-medium">{{ $position->title }}</h3>
                                                    @if($position->is_critical)
                                                        <span class="badge badge-warning badge-sm">Critical Role</span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-600 mt-1">{{ $position->level }}</p>
                                            </div>
                                            <div class="flex items-center gap-6">
                                                <div class="text-right">
                                                    <div class="text-sm font-medium">{{ $position->employees_count }}</div>
                                                    <div class="text-xs text-gray-500">Employees</div>
                                                </div>
                                                <a href="{{ route('hr.positions.show', $position) }}"
                                                   class="btn btn-ghost btn-sm">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>

                                        @if($position->description)
                                            <p class="mt-3 text-sm text-gray-600">
                                                {{ Str::limit($position->description, 150) }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fi fi-rr-briefcase text-4xl mb-3"></i>
                                    <h3 class="font-medium mb-1">No Positions Yet</h3>
                                    <p class="text-sm text-gray-500 mb-4">Start by adding a position to this department</p>
                                    <a href="{{ route('hr.positions.create', $department) }}"
                                       class="btn btn-accent btn-sm gap-2">
                                        <i class="fi fi-rr-plus"></i>
                                        Add First Position
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
