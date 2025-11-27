<x-dashboard.hr.base>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-2xl lg:text-3xl font-bold text-gray-800 truncate">Job Positions</h1>
                <p class="text-xs sm:text-sm text-gray-600 mt-1 truncate">Manage and monitor all job positions across departments</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                {{-- <div class="join">
                    <a href="{{ route('hr.positions.index') }}"
                       class="btn join-item btn-sm text-xs sm:text-sm {{ !request('view') || request('view') === 'grid' ? 'btn-active' : '' }}"
                       title="Grid View">
                        <i class="fi fi-rr-apps"></i>
                    </a>
                    <a href="{{ route('hr.positions.index', ['view' => 'list']) }}"
                       class="btn join-item btn-sm text-xs sm:text-sm {{ request('view') === 'list' ? 'btn-active' : '' }}"
                       title="List View">
                        <i class="fi fi-rr-list"></i>
                    </a>
                </div> --}}
                <a href="{{ route('hr.positions.create') }}"
                   class="btn btn-accent btn-sm gap-2 text-xs sm:text-sm whitespace-nowrap">
                    <i class="fi fi-rr-plus"></i>
                    <span class="hidden sm:inline">Add Position</span>
                    <span class="sm:hidden">Add</span>
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4 border-b">
                <form class="flex flex-col md:flex-row md:items-end gap-3 md:gap-4">
                    <div class="form-control flex-1 min-w-0">
                        <label class="label">
                            <span class="label-text text-xs sm:text-sm">Search</span>
                        </label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="input input-bordered input-sm w-full text-xs sm:text-sm"
                               placeholder="Search positions...">
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
                    <div class="form-control w-full md:w-40">
                        <label class="label">
                            <span class="label-text text-xs sm:text-sm">Status</span>
                        </label>
                        <select name="status" class="select select-bordered select-sm w-full text-xs sm:text-sm">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="form-control w-full md:w-auto">
                        <button type="submit" class="btn btn-sm text-xs sm:text-sm">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Job Positions Grid/List -->
        @if(request('view') === 'list')
            <!-- List View (Desktop) -->
            <div class="hidden md:block bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th class="text-sm">Position</th>
                                <th class="text-sm">Department</th>
                                <th class="text-sm">Type</th>
                                <th class="text-sm">Status</th>
                                <th class="text-sm">Hiring</th>
                                <th class="text-sm text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($positions as $position)
                                <tr class="hover">
                                    <td>
                                        <div class="font-medium text-sm truncate">{{ $position->name }}</div>
                                    </td>
                                    <td class="text-sm truncate">{{ $position->department->name }}</td>
                                    <td class="text-sm">{{ ucfirst($position->type) }}</td>
                                    <td>
                                        <span class="badge text-xs {{
                                            $position->status === 'active' ? 'badge-success' :
                                            ($position->status === 'draft' ? 'badge-warning' : 'badge-error')
                                        }}">
                                            {{ ucfirst($position->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($position->is_hiring)
                                            <span class="badge badge-accent text-xs">Hiring</span>
                                        @else
                                            <span class="badge badge-ghost text-xs">Not Hiring</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('hr.positions.toggle-hiring', ['id' => $position->id]) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm text-xs {{ $position->is_hiring ? 'btn-error' : 'btn-accent' }}"
                                                        title="{{ $position->is_hiring ? 'Stop Hiring' : 'Start Hiring' }}">
                                                    {{ $position->is_hiring ? 'Stop' : 'Start' }}
                                                </button>
                                            </form>
                                            <a href="{{ route('hr.positions.show', $position) }}"
                                               class="btn btn-ghost btn-sm text-xs">
                                                View
                                            </a>
                                            <a href="{{ route('hr.positions.edit', $position) }}"
                                               class="btn btn-ghost btn-sm text-xs">
                                                <i class="fi fi-rr-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fi fi-rr-briefcase text-3xl mb-2"></i>
                                            <p class="text-sm">No positions found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Grid View (Mobile + Desktop) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse($positions as $position)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-4 sm:p-6 flex flex-col">
                    <div class="flex items-start justify-between gap-2 mb-4">
                        <div class="min-w-0 flex-1">
                            <h3 class="font-medium text-sm sm:text-base text-gray-900 truncate">{{ $position->name }}</h3>
                            <p class="text-xs sm:text-sm text-gray-600 truncate">{{ $position->department->name }}</p>
                        </div>
                        <div class="flex flex-col items-end gap-1 shrink-0">
                            @if($position->is_hiring)
                                <span class="badge badge-accent text-xs">Hiring</span>
                            @endif
                            <span class="badge text-xs {{
                                $position->status === 'active' ? 'badge-success' :
                                ($position->status === 'draft' ? 'badge-warning' : 'badge-error')
                            }}">
                                {{ ucfirst($position->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 mb-4 flex-grow">
                        <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600">
                            <i class="fi fi-rr-briefcase flex-shrink-0"></i>
                            <span>{{ ucfirst($position->type) }}</span>
                        </div>
                    </div>

                    @if($position->description)
                        <p class="text-xs sm:text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ $position->description }}
                        </p>
                    @endif

                    <div class="pt-4 border-t space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs sm:text-sm text-gray-600 whitespace-nowrap">Hiring:</span>
                            <form action="{{ route('hr.positions.toggle-hiring', ['id' => $position->id]) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="btn btn-xs sm:btn-sm text-xs {{ $position->is_hiring ? 'btn-error' : 'btn-accent' }}">
                                    {{ $position->is_hiring ? 'Stop' : 'Start' }}
                                </button>
                            </form>
                        </div>

                        <div class="flex flex-wrap items-center justify-end gap-2">
                            <a href="{{ route('hr.positions.show', $position) }}"
                               class="btn btn-ghost btn-xs sm:btn-sm text-xs gap-1">
                                <i class="fi fi-rr-eye"></i>
                                <span class="hidden sm:inline">View</span>
                            </a>
                            <a href="{{ route('hr.positions.edit', $position) }}"
                               class="btn btn-ghost btn-xs sm:btn-sm text-xs gap-1">
                                <i class="fi fi-rr-edit"></i>
                                <span class="hidden sm:inline">Edit</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white rounded-lg">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <i class="fi fi-rr-briefcase text-3xl sm:text-4xl mb-2 sm:mb-3"></i>
                            <h3 class="font-medium text-sm sm:text-base mb-1">No Positions Found</h3>
                            <p class="text-xs sm:text-sm text-gray-500 mb-4">Try adjusting your search or filters</p>
                            <a href="{{ route('hr.positions.create') }}"
                               class="btn btn-accent btn-sm text-xs sm:text-sm gap-2">
                                <i class="fi fi-rr-plus"></i>
                                <span class="hidden sm:inline">Add First Position</span>
                                <span class="sm:hidden">Add</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $positions->links() }}
        </div>
    </div>
</x-dashboard.hr.base>
