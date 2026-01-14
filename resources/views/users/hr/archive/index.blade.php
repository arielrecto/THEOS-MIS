<x-dashboard.hr.base>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Archived Employees</h1>
                <p class="text-sm text-gray-600 mt-1">View and manage archived employee records</p>
            </div>
            <a href="{{ route('hr.employees.index') }}" class="btn btn-ghost gap-2 w-full sm:w-auto">
                <i class="fi fi-rr-arrow-left"></i>
                <span>Back to Employees</span>
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if (session('message'))
            <div class="alert alert-success mb-6">
                <i class="fi fi-rr-check-circle"></i>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error mb-6">
                <i class="fi fi-rr-cross-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <form method="GET" action="{{ route('hr.employees.archived') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="form-control">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..."
                        class="input input-bordered w-full">
                </div>

                <!-- Department Filter -->
                <div class="form-control">
                    <select name="department" class="select select-bordered w-full">
                        <option value="">All Departments</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}"
                                {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Position Filter -->
                <div class="form-control">
                    <select name="position" class="select select-bordered w-full">
                        <option value="">All Positions</option>
                        @foreach ($positions as $pos)
                            <option value="{{ $pos->id }}" {{ request('position') == $pos->id ? 'selected' : '' }}>
                                {{ $pos->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary flex-1">
                        <i class="fi fi-rr-search"></i>
                        Filter
                    </button>
                    <a href="{{ route('hr.employees.archived') }}" class="btn btn-ghost">
                        <i class="fi fi-rr-refresh"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Archived Employees List -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            @if ($employees->count() > 0)
                <!-- Mobile View -->
                <div class="md:hidden divide-y">
                    @foreach ($employees as $employee)
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex items-start gap-3 mb-3">
                                <!-- Photo -->
                                <div class="avatar flex-shrink-0">
                                    <div class="w-16 h-16 rounded-full">
                                        @if ($employee->photo)
                                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                                alt="{{ $employee->first_name }}"
                                                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($employee->first_name . ' ' . $employee->last_name) }}&background=random'">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->first_name . ' ' . $employee->last_name) }}&background=random"
                                                alt="{{ $employee->first_name }}">
                                        @endif
                                    </div>
                                </div>

                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 truncate">
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 truncate">
                                        {{ $employee->position?->name ?? 'No Position' }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">
                                        {{ $employee->position?->department?->name ?? 'No Department' }}
                                    </p>
                                    <div class="mt-2">
                                        <span class="badge badge-error badge-sm">Archived</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('hr.employees.show', $employee) }}"
                                    class="btn btn-sm btn-ghost flex-1">
                                    <i class="fi fi-rr-eye"></i>
                                    View
                                </a>
                                <form action="{{ route('hr.employees.restore', $employee) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to restore this employee?');"
                                    class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success w-full">
                                        <i class="fi fi-rr-refresh"></i>
                                        Restore
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Desktop View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th class="bg-gray-50">Employee</th>
                                <th class="bg-gray-50">Position</th>
                                <th class="bg-gray-50">Department</th>
                                <th class="bg-gray-50">Contact</th>
                                <th class="bg-gray-50">Archived Date</th>
                                <th class="bg-gray-50 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr class="hover:bg-gray-50">
                                    <!-- Employee Info -->
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="w-10 h-10 rounded-full">
                                                    @if ($employee->photo)
                                                        <img src="{{ asset('storage/' . $employee->photo) }}"
                                                            alt="{{ $employee->first_name }}"
                                                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($employee->first_name . ' ' . $employee->last_name) }}&background=random'">
                                                    @else
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->first_name . ' ' . $employee->last_name) }}&background=random"
                                                            alt="{{ $employee->first_name }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">
                                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $employee->user?->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Position -->
                                    <td>
                                        <span class="text-gray-700">
                                            {{ $employee->position?->name ?? '—' }}
                                        </span>
                                    </td>

                                    <!-- Department -->
                                    <td>
                                        <span class="text-gray-700">
                                            {{ $employee->position?->department?->name ?? '—' }}
                                        </span>
                                    </td>

                                    <!-- Contact -->
                                    <td>
                                        <div class="text-sm text-gray-700">
                                            {{ $employee->phone }}
                                        </div>
                                    </td>

                                    <!-- Archived Date -->
                                    <td>
                                        <span class="text-sm text-gray-500">
                                            {{ $employee->updated_at->format('M d, Y') }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('hr.employees.show', $employee) }}"
                                                class="btn btn-sm btn-ghost" title="View Details">
                                                <i class="fi fi-rr-eye"></i>
                                            </a>
                                            <form action="{{ route('hr.employees.restore', $employee) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to restore this employee?');"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    title="Restore Employee">
                                                    <i class="fi fi-rr-refresh"></i>
                                                    Restore
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t">
                    {{ $employees->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fi fi-rr-box-open text-4xl text-gray-400 mb-4 block"></i>
                    <p class="text-gray-500 mb-4">No archived employees found</p>
                    @if (request()->hasAny(['search', 'department', 'position']))
                        <a href="{{ route('hr.archive.index') }}" class="btn btn-ghost">
                            Clear Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Statistics Card -->
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fi fi-rr-archive text-2xl text-gray-600"></i>
                    <div>
                        <h3 class="font-semibold text-gray-900">Total Archived Employees</h3>
                        <p class="text-sm text-gray-600">Records currently in archive</p>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-800">
                    {{ $employees->total() }}
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
