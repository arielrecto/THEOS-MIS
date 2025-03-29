<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Employees</h1>
                    <p class="text-gray-600">Manage and monitor all employees</p>
                </div>
                <a href="{{ route('hr.employees.create') }}"
                   class="btn btn-accent gap-2">
                    <i class="fi fi-rr-user-add"></i>
                    Add Employee
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4 border-b">
                <form class="flex flex-wrap items-end gap-4">
                    <div class="form-control flex-1">
                        <label class="label">
                            <span class="label-text">Search</span>
                        </label>
                        <input type="text"
                               name="search"
                               class="input input-bordered"
                               placeholder="Search employees..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Department</span>
                        </label>
                        <select name="department" class="select select-bordered">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                        {{ request('department') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Position</span>
                        </label>
                        <select name="position" class="select select-bordered">
                            <option value="">All Positions</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}"
                                        {{ request('position') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <button type="submit" class="btn">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Employee List -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="w-12 h-12 rounded-full">
                                                @if($employee->photo)
                                                    <img src="{{ Storage::url($employee->photo) }}" alt="Avatar">
                                                @else
                                                    <div class="bg-accent/10 w-full h-full flex items-center justify-center">
                                                        <i class="fi fi-rr-user text-accent text-xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                            <div class="text-sm opacity-50">{{ $employee->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($employee->position)
                                        {{ $employee->position->name }}
                                    @else
                                        <span class="text-gray-400">Not Assigned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($employee->position?->department)
                                        {{ $employee->position->department->name }}
                                    @else
                                        <span class="text-gray-400">Not Assigned</span>
                                    @endif
                                </td>
                                <td>{{ $employee->phone }}</td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('hr.employees.show', $employee) }}"
                                           class="btn btn-ghost btn-sm">
                                            View
                                        </a>
                                        <a href="{{ route('hr.employees.edit', $employee) }}"
                                           class="btn btn-ghost btn-sm">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No employees found
                                </td>
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
</x-dashboard.hr.base>
