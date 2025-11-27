<x-dashboard.hr.base>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-2xl lg:text-3xl font-bold text-gray-800 truncate">
                    Departments
                </h1>
                <p class="text-xs sm:text-sm text-gray-600 mt-1 truncate">
                    Manage school departments and their details
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <div class="join">
                    <button class="btn join-item btn-sm" title="List View" aria-label="List view">
                        <i class="fi fi-rr-list"></i>
                    </button>
                    <button class="btn join-item btn-sm" title="Card View" aria-label="Card view">
                        <i class="fi fi-rr-apps"></i>
                    </button>
                </div>

                <a href="{{ route('hr.departments.create') }}" class="btn btn-accent btn-sm gap-2 whitespace-nowrap">
                    <i class="fi fi-rr-plus"></i>
                    <span class="hidden sm:inline">Add Department</span>
                    <span class="sm:hidden">Add</span>
                </a>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full">
                    <div class="form-control flex-1 min-w-0">
                        <div class="input-group w-full">
                            <input type="text" placeholder="Search departments..."
                                   class="input input-bordered input-sm w-full sm:w-72 text-xs sm:text-sm"
                                   aria-label="Search departments">
                            <button class="btn btn-sm" aria-label="Search">
                                <i class="fi fi-rr-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="w-full sm:w-auto">
                        <select class="select select-bordered select-sm text-xs sm:text-sm w-full sm:w-40" aria-label="Filter status">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-xs sm:text-sm text-gray-500 truncate">
                        Showing
                        <span class="font-semibold text-gray-700">{{ $departments->count() }}</span>
                        of <span class="font-semibold">{{ $departments->total() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments (card list on mobile, table on md+) -->
        <div class="space-y-4">
            <!-- Mobile Cards -->
            <div class="md:hidden">
                @forelse($departments as $department)
                    <article class="bg-white rounded-lg shadow-sm p-4 flex flex-col gap-3">
                        <div class="flex items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('hr.departments.show', ['department' => $department->id]) }}"
                                   class="font-medium text-sm sm:text-base text-gray-900 block break-words">
                                    {{ $department->name }}
                                </a>

                                <div class="mt-1 text-xs text-gray-500 flex flex-col sm:flex-row sm:items-center gap-1">
                                    <span class="truncate">Code: <span class="font-medium text-gray-700">{{ $department->code }}</span></span>
                                    <span class="truncate">Head: <span class="font-medium">{{ $department->head ?: 'No head assigned' }}</span></span>
                                </div>

                                <div class="mt-2">
                                    <span class="badge badge-ghost text-xs">{{ $department->employees_count }} members</span>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <button
                                    onclick="toggleDepartmentStatus({{ $department->id }})"
                                    class="badge {{ $department->is_active ? 'badge-success' : 'badge-error' }} text-xs whitespace-nowrap"
                                    aria-pressed="{{ $department->is_active ? 'true' : 'false' }}">
                                    {{ $department->is_active ? 'Active' : 'Inactive' }}
                                </button>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('hr.departments.edit', ['department' => $department->id]) }}"
                                       class="btn btn-ghost btn-xs" aria-label="Edit department">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>

                                    <form action="{{ route('hr.departments.destroy', ['department' => $department->id]) }}"
                                          method="post" onsubmit="return confirm('Delete department?')">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-ghost btn-xs text-error" aria-label="Delete department">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <i class="fi fi-rr-building text-3xl mb-2 text-gray-400"></i>
                        <p class="text-sm text-gray-600">No departments found</p>
                    </div>
                @endforelse

                <!-- Mobile pagination -->
                <div class="mt-4 flex justify-center">
                    {{ $departments->links() }}
                </div>
            </div>

            <!-- Desktop / Tablet Table -->
            <div class="hidden md:block bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th class="w-12">
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-sm">
                                    </label>
                                </th>
                                <th class="text-sm md:text-base">Name</th>
                                <th class="text-sm md:text-base">Head</th>
                                <th class="text-sm md:text-base">Employees</th>
                                <th class="text-sm md:text-base">Status</th>
                                <th class="w-28 text-sm md:text-base">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $department)
                                <tr class="hover">
                                    <td>
                                        <label>
                                            <input type="checkbox" class="checkbox checkbox-sm">
                                        </label>
                                    </td>
                                    <td class="align-top">
                                        <div class="min-w-0">
                                            <a href="{{ route('hr.departments.show', ['department' => $department->id]) }}"
                                               class="font-medium text-sm md:text-base truncate block">{{ $department->name }}</a>
                                            <div class="text-xs md:text-sm opacity-50 truncate">{{ $department->code }}</div>
                                        </div>
                                    </td>
                                    <td class="align-top">
                                        @if($department->head)
                                            <div class="font-medium text-sm md:text-base capitalize truncate">{{ $department->head }}</div>
                                        @else
                                            <span class="text-sm text-gray-500">No head assigned</span>
                                        @endif
                                    </td>
                                    <td class="align-top">
                                        <div class="badge badge-ghost text-xs md:text-sm">{{ $department->employees_count }} members</div>
                                    </td>
                                    <td class="align-top">
                                        <button
                                            onclick="toggleDepartmentStatus({{ $department->id }})"
                                            class="badge {{ $department->is_active ? 'badge-success' : 'badge-error' }} gap-1 cursor-pointer hover:opacity-80 text-xs md:text-sm"
                                            id="status-badge-{{ $department->id }}"
                                            aria-pressed="{{ $department->is_active ? 'true' : 'false' }}"
                                        >
                                            <div class="w-2 h-2 rounded-full bg-current"></div>
                                            <span id="status-text-{{ $department->id }}" class="truncate">
                                                {{ $department->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </button>
                                    </td>
                                    <td class="align-top">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('hr.departments.edit', ['department' => $department->id]) }}" class="btn btn-ghost btn-xs" aria-label="Edit">
                                                <i class="fi fi-rr-edit"></i>
                                                <span class="hidden lg:inline ml-1">Edit</span>
                                            </a>

                                            <form action="{{ route('hr.departments.destroy', ['department' => $department->id]) }}" method="post" onsubmit="return confirm('Delete department?')">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-ghost btn-xs text-error" aria-label="Delete">
                                                    <i class="fi fi-rr-trash"></i>
                                                    <span class="hidden lg:inline ml-1">Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fi fi-rr-building text-3xl mb-2"></i>
                                            <p class="text-sm">No departments found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Desktop pagination -->
                <div class="p-4 border-t">
                    {{ $departments->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        async function toggleDepartmentStatus(id) {
            try {
                const response = await fetch(`/hr/departments/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    const badge = document.getElementById(`status-badge-${id}`);
                    const text = document.getElementById(`status-text-${id}`);

                    if (data.is_active) {
                        badge.classList.remove('badge-error');
                        badge.classList.add('badge-success');
                        text.textContent = 'Active';
                    } else {
                        badge.classList.remove('badge-success');
                        badge.classList.add('badge-error');
                        text.textContent = 'Inactive';
                    }

                    // optional toast
                    const toast = document.createElement('div');
                    toast.className = 'toast toast-end';
                    toast.innerHTML = `
                        <div class="alert alert-success">
                            <i class="fi fi-rr-check"></i>
                            <span>${data.message}</span>
                        </div>
                    `;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                }
            } catch (error) {
                console.error('Error:', error);
                const toast = document.createElement('div');
                toast.className = 'toast toast-end';
                toast.innerHTML = `
                    <div class="alert alert-error">
                        <i class="fi fi-rr-cross"></i>
                        <span>Failed to update department status</span>
                    </div>
                `;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        }
    </script>
    @endpush
</x-dashboard.hr.base>
