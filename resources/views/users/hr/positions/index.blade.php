<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Job Positions</h1>
                <p class="text-gray-600">Manage and monitor all job positions across departments</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="join">
                    <a href="{{ route('hr.positions.index') }}"
                       class="btn join-item btn-sm {{ !request('view') || request('view') === 'grid' ? 'btn-active' : '' }}">
                        <i class="fi fi-rr-apps"></i>
                    </a>
                    <a href="{{ route('hr.positions.index', ['view' => 'list']) }}"
                       class="btn join-item btn-sm {{ request('view') === 'list' ? 'btn-active' : '' }}">
                        <i class="fi fi-rr-list"></i>
                    </a>
                </div>
                <a href="{{ route('hr.positions.create') }}"
                   class="btn btn-accent btn-sm gap-2">
                    <i class="fi fi-rr-plus"></i>
                    Add Position
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
                               value="{{ request('search') }}"
                               class="input input-bordered input-sm"
                               placeholder="Search positions...">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Department</span>
                        </label>
                        <select name="department" class="select text-sm select-bordered select-sm">
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
                            <span class="label-text">Status</span>
                        </label>
                        <select name="status" class="select select-bordered text-sm select-sm">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <button type="submit" class="btn btn-sm">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Job Positions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($positions as $position)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-medium text-lg text-gray-900">{{ $position->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $position->department->name }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($position->is_hiring)
                                    <span class="badge badge-accent">Hiring</span>
                                @endif
                                <span class="badge {{
                                    $position->status === 'active' ? 'badge-success' :
                                    ($position->status === 'draft' ? 'badge-warning' : 'badge-error')
                                }}">
                                    {{ ucfirst($position->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 space-y-2">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fi fi-rr-briefcase"></i>
                                <span>{{ ucfirst($position->type) }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fi fi-rr-coins"></i>
                                <span>₱{{ number_format($position->min_salary) }} - ₱{{ number_format($position->max_salary) }}</span>
                            </div>
                        </div>

                        @if($position->description)
                            <p class="mt-4 text-sm text-gray-600">
                                {{ Str::limit($position->description, 100) }}
                            </p>
                        @endif

                        <div class="mt-6 pt-4 border-t flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-600">Hiring Status:</span>
                                <form action="{{ route('hr.positions.toggle-hiring', $position) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm {{ $position->is_hiring ? 'btn-error' : 'btn-accent' }}">
                                        {{ $position->is_hiring ? 'Stop Hiring' : 'Start Hiring' }}
                                    </button>
                                </form>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('hr.positions.show', $position) }}"
                                   class="btn btn-ghost btn-sm">
                                    View Details
                                </a>
                                <a href="{{ route('hr.positions.edit', $position) }}"
                                   class="btn btn-ghost btn-sm">
                                    <i class="fi fi-rr-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white rounded-lg">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <i class="fi fi-rr-briefcase text-4xl mb-3"></i>
                            <h3 class="font-medium mb-1">No Positions Found</h3>
                            <p class="text-sm text-gray-500 mb-4">Try adjusting your search or filters</p>
                            <a href="{{ route('hr.positions.create') }}"
                               class="btn btn-accent btn-sm gap-2">
                                <i class="fi fi-rr-plus"></i>
                                Add First Position
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $positions->links() }}
        </div>
    </div>
</x-dashboard.hr.base>
