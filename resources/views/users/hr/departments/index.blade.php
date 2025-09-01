<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Departments</h1>
                <p class="text-gray-600">Manage school departments and their details</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="join">
                    <button class="btn join-item btn-sm" title="List View">
                        <i class="fi fi-rr-list"></i>
                    </button>
                    <button class="btn join-item btn-sm" title="Card View">
                        <i class="fi fi-rr-apps"></i>
                    </button>
                </div>
                <a href="{{route('hr.departments.create')}}" class="btn btn-accent btn-sm gap-2">
                    <i class="fi fi-rr-plus"></i>
                    Add Department
                </a>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4 flex items-center justify-between border-b">
                <div class="flex items-center gap-3">
                    <div class="form-control">
                        <div class="input-group">
                            <input type="text" placeholder="Search departments..." class="input input-bordered input-sm w-72">
                            <button class="btn btn-sm">
                                <i class="fi fi-rr-search"></i>
                            </button>
                        </div>
                    </div>
                    <select class="select select-bordered select-sm text-xs">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Departments Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-12">
                                <label>
                                    <input type="checkbox" class="checkbox checkbox-sm">
                                </label>
                            </th>
                            <th>Name</th>
                            <th>Head</th>
                            <th>Employees</th>
                            <th>Status</th>
                            <th class="w-20">Actions</th>
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
                                <td>
                                    <div>
                                        <a href="{{route('hr.departments.show', ['department' => $department->id])}}" class="font-medium">{{ $department->name }}</a>
                                        <div class="text-sm opacity-50">{{ $department->code }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($department->head)
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="w-8 h-8 rounded-full">
                                                    <img src="{{ $department->head->avatar_url }}" alt="Avatar">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-medium">{{ $department->head->name }}</div>
                                                <div class="text-sm opacity-50">Since {{ $department->head->appointed_at->format('M Y') }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">No head assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="badge badge-ghost">{{ $department->employees_count }} members</div>
                                </td>
                                <td>
                                    <button
                                        onclick="toggleDepartmentStatus({{ $department->id }})"
                                        class="badge {{ $department->is_active ? 'badge-success' : 'badge-error' }} gap-1 cursor-pointer hover:opacity-80"
                                        id="status-badge-{{ $department->id }}"
                                    >
                                        <div class="w-2 h-2 rounded-full bg-current"></div>
                                        <span id="status-text-{{ $department->id }}">
                                            {{ $department->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </button>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a href="{{route('hr.departments.edit', ['department' => $department->id])}}" class="btn btn-ghost btn-xs"
                                                >
                                            <i class="fi fi-rr-edit"></i>
                                        </a>

                                        <form action="{{route('hr.departments.destroy', ['department' => $department->id])}}" method="post">

                                            @csrf

                                            @method('delete')

                                            <button class="btn btn-ghost btn-xs text-error"
                                            >
                                        <i class="fi fi-rr-trash"></i>
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
                                        <p>No departments found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t">
                {{ $departments->links() }}
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

                    // Show toast notification
                    const toast = document.createElement('div');
                    toast.className = 'toast toast-end';
                    toast.innerHTML = `
                        <div class="alert alert-success">
                            <i class="fi fi-rr-check"></i>
                            <span>${data.message}</span>
                        </div>
                    `;


                    window.location.reload();
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                }
            } catch (error) {
                console.error('Error:', error);
                // Show error toast
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
