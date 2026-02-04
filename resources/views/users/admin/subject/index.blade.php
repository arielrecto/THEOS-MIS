<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('Subjects')" :create_url="route('admin.subjects.create')" />
    <div class="container max-w-7xl p-4 sm:p-6 mx-auto">
        <div class="panel flex flex-col gap-4 min-h-96">
            <!-- Desktop Table -->
            <div class="overflow-x-auto hidden md:block bg-white rounded-lg shadow-sm">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Subject Code</th>
                            <th>Assigned Grade Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subjects as $subject)
                            <tr>
                                <th></th>
                                <td class="max-w-xs truncate">{{ $subject->name }}</td>
                                <td class="hidden lg:table-cell">{{ $subject->subject_code }}</td>
                                <td>
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($subject->gradeLevels as $gradeLevel)
                                            <span class="badge badge-sm">{{ $gradeLevel->strand->name }}</span>
                                        @empty
                                            <span class="text-gray-400 text-sm">No Grade Level assigned</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="flex items-center gap-3">
                                    <a href="{{ route('admin.subjects.show', ['subject' => $subject->id]) }}"
                                        class="btn btn-xs btn-accent" aria-label="View">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.subjects.edit', ['subject' => $subject->id]) }}"
                                        class="btn btn-xs btn-primary" aria-label="Edit">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.subjects.destroy', ['subject' => $subject->id]) }}"
                                        method="post"
                                        onsubmit="return confirm('Are you sure you want to delete this subject?')">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-xs btn-error" aria-label="Delete">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <i class="fi fi-rr-book text-3xl mb-2"></i>
                                        <p>No subjects found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-3">
                @forelse ($subjects as $subject)
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <div class="min-w-0">
                                        <div class="font-semibold text-sm text-wrap">{{ $subject->name }}</div>
                                        <div class="text-xs text-gray-500 truncate">{{ $subject->subject_code }}</div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <!-- actions dropdown for mobile -->
                                        <div class="dropdown dropdown-end">
                                            <button tabindex="0" class="btn btn-ghost btn-sm" aria-label="Actions">
                                                <i class="fi fi-rr-menu-dots"></i>
                                            </button>
                                            <ul tabindex="0"
                                                class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-40">
                                                <li>
                                                    <a href="{{ route('admin.subjects.show', ['subject' => $subject->id]) }}"
                                                        class="flex items-center gap-2">
                                                        <i class="fi fi-rr-eye"></i> View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.subjects.edit', ['subject' => $subject->id]) }}"
                                                        class="flex items-center gap-2">
                                                        <i class="fi fi-rr-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.subjects.destroy', ['subject' => $subject->id]) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Delete this subject?')">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            class="w-full text-left flex items-center gap-2 text-error">
                                                            <i class="fi fi-rr-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($subject->gradeLevels as $gradeLevel)
                                            <span
                                                class="badge badge-sm badge-outline text-xs">{{ $gradeLevel->strand->name }}</span>
                                        @empty
                                            <span class="text-gray-400 text-xs">No Grade Level assigned</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class="fi fi-rr-book text-3xl mb-2"></i>
                        <p>No subjects found</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $subjects->links() }}
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
