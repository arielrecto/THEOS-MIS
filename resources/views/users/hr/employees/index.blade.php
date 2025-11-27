<x-dashboard.hr.base>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="text-lg sm:text-2xl lg:text-3xl font-bold text-gray-800 truncate">Employees</h1>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1 truncate">Manage and monitor all employees</p>
                </div>

                <div class="flex-shrink-0">
                    <a href="{{ route('hr.employees.create') }}" class="btn btn-accent gap-2 whitespace-nowrap">
                        <i class="fi fi-rr-user-add"></i>
                        <span class="hidden sm:inline">Add Employee</span>
                        <span class="sm:hidden">Add</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4 border-b">
                <form class="flex flex-col md:flex-row md:items-end gap-4">
                    <div class="form-control flex-1 min-w-0">
                        <label class="label">
                            <span class="label-text text-xs sm:text-sm">Search</span>
                        </label>
                        <input type="text"
                               name="search"
                               class="input input-bordered input-sm w-full text-xs sm:text-sm"
                               placeholder="Search employees..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="form-control w-full md:w-48">
                        <label class="label">
                            <span class="label-text text-xs sm:text-sm">Department</span>
                        </label>
                        <select name="department" class="select select-bordered select-sm w-full text-xs sm:text-sm">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                        {{ request('department') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control w-full md:w-48">
                        <label class="label">
                            <span class="label-text text-xs sm:text-sm">Position</span>
                        </label>
                        <select name="position" class="select select-bordered select-sm w-full text-xs sm:text-sm">
                            <option value="">All Positions</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}"
                                        {{ request('position') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="btn btn-sm">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Employee List: mobile cards + desktop table -->
        <div class="space-y-4">
            <!-- Mobile Cards -->
            <div class="md:hidden">
                @forelse($employees as $employee)
                    <article class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0">
                                @if($employee->photo)
                                    <img src="{{ Storage::url($employee->photo) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <div class="bg-accent/10 w-full h-full flex items-center justify-center">
                                        <i class="fi fi-rr-user text-accent text-xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <a href="{{ route('hr.employees.show', $employee) }}" class="font-medium text-sm text-gray-900 block truncate">
                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                </a>
                                <div class="text-xs text-gray-500 truncate">{{ $employee->user->email }}</div>

                                <div class="mt-2 text-xs text-gray-600 flex flex-col gap-1">
                                    <div>
                                        <span class="font-semibold text-gray-700">Position:</span>
                                        <span class="ml-1">
                                            @if($employee->position) {{ $employee->position->name }} @else <span class="text-gray-400">Not Assigned</span> @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-700">Department:</span>
                                        <span class="ml-1">
                                            @if($employee->position?->department) {{ $employee->position->department->name }} @else <span class="text-gray-400">Not Assigned</span> @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-700">Contact:</span>
                                        <span class="ml-1">{{ $employee->phone ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('hr.employees.show', $employee) }}" class="btn btn-ghost btn-xs">View</a>
                                <a href="{{ route('hr.employees.edit', $employee) }}" class="btn btn-ghost btn-xs">Edit</a>
                            </div>

                            <div class="flex items-center gap-1">
                                <form action="{{ route('hr.employees.toggle-teacher', $employee) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-xs {{ $employee->user->hasRole('teacher') ? 'btn-primary' : 'btn-ghost' }}"
                                            title="{{ $employee->user->hasRole('teacher') ? 'Remove Teacher Role' : 'Add Teacher Role' }}">
                                        <i class="fi fi-rr-graduation-cap"></i>
                                    </button>
                                </form>

                                <form action="{{ route('hr.employees.toggle-registrar', $employee) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-xs {{ $employee->user->hasRole('registrar') ? 'btn-info' : 'btn-ghost' }}"
                                            title="{{ $employee->user->hasRole('registrar') ? 'Remove Registrar Role' : 'Add Registrar Role' }}">
                                        <i class="fi fi-rr-diploma"></i>
                                    </button>
                                </form>

                                <form action="{{ route('hr.employees.toggle-archive', $employee) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-xs {{ $employee->status === 'archived' ? 'btn-info' : 'btn-ghost' }}"
                                            title="{{ $employee->status === 'archived' ? 'Unarchive' : 'Archive' }}">
                                        <i class="fi fi-rr-folder-download"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <i class="fi fi-rr-users text-3xl mb-2 text-gray-400"></i>
                        <p class="text-sm text-gray-600">No employees found</p>
                    </div>
                @endforelse

                <!-- Mobile pagination -->
                <div class="mt-4 flex justify-center">
                    {{ $employees->links() }}
                </div>
            </div>

            <!-- Desktop / Tablet Table -->
            <div class="hidden md:block bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th class="text-sm">Position</th>
                                <th class="text-sm">Department</th>
                                <th class="text-sm">Contact</th>
                                <th class="text-sm text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="avatar flex-shrink-0">
                                                <div class="w-12 h-12 rounded-full overflow-hidden">
                                                    @if($employee->photo)
                                                        <img src="{{ Storage::url($employee->photo) }}" alt="Avatar" class="object-cover w-full h-full">
                                                    @else
                                                        <div class="bg-accent/10 w-full h-full flex items-center justify-center">
                                                            <i class="fi fi-rr-user text-accent text-xl"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="min-w-0">
                                                <div class="font-medium truncate">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                                <div class="text-xs opacity-50 truncate">{{ $employee->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="align-top">
                                        <div class="truncate">
                                            @if($employee->position)
                                                {{ $employee->position->name }}
                                            @else
                                                <span class="text-gray-400">Not Assigned</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="align-top">
                                        <div class="truncate">
                                            @if($employee->position?->department)
                                                {{ $employee->position->department->name }}
                                            @else
                                                <span class="text-gray-400">Not Assigned</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="align-top truncate">{{ $employee->phone ?? '-' }}</td>

                                    <td class="align-top text-right">
                                        <div class="flex items-center justify-end gap-2 whitespace-nowrap">
                                            <a href="{{ route('hr.employees.show', $employee) }}" class="btn btn-ghost btn-sm">View</a>
                                            <a href="{{ route('hr.employees.edit', $employee) }}" class="btn btn-ghost btn-sm">Edit</a>

                                            <form action="{{ route('hr.employees.toggle-teacher', $employee) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-sm {{ $employee->user->hasRole('teacher') ? 'btn-primary' : 'btn-ghost' }}"
                                                        title="{{ $employee->user->hasRole('teacher') ? 'Remove Teacher Role' : 'Add Teacher Role' }}">
                                                    <i class="fi fi-rr-graduation-cap"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('hr.employees.toggle-registrar', $employee) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-sm {{ $employee->user->hasRole('registrar') ? 'btn-info' : 'btn-ghost' }}"
                                                        title="{{ $employee->user->hasRole('registrar') ? 'Remove Registrar Role' : 'Add Registrar Role' }}">
                                                    <i class="fi fi-rr-diploma"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('hr.employees.toggle-archive', $employee) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        class="btn btn-sm {{ $employee->status === 'archived' ? 'btn-info' : 'btn-ghost' }}"
                                                        title="{{ $employee->status === 'archived' ? 'Unarchive Employee' : 'Archive Employee' }}">
                                                    <i class="fi fi-rr-folder-download"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No employees found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
