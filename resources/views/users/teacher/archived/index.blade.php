<x-dashboard.teacher.base>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div class="min-w-0">
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800 truncate">Archived Classrooms</h2>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">View and manage your archived classrooms</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('teacher.classrooms.index') }}" class="btn btn-ghost btn-sm sm:btn-md gap-2">
                        <i class="fi fi-rr-arrow-left"></i>
                        <span class="hidden sm:inline">Back to Classrooms</span>
                    </a>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="p-2 sm:p-3 bg-gray-100 rounded-lg">
                        <i class="fi fi-rr-archive text-xl sm:text-2xl text-gray-600"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm text-gray-600">Total Archived</p>
                        <p class="text-xl sm:text-2xl font-semibold truncate">{{ $archivedClassrooms->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- Mobile list (visible on small screens) -->
            <div class="space-y-4 md:hidden">
                @forelse($archivedClassrooms as $classroom)
                    <article class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="flex items-start gap-3 p-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $classroom->teacher->profile->image ?? asset('images/avatar-placeholder.png') }}"
                                    alt="{{ $classroom->teacher->name ?? 'Teacher' }}"
                                    class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover bg-gray-100">
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm sm:text-base font-medium text-gray-800 truncate">
                                            {{ $classroom->name }}</p>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-0.5 truncate">
                                            {{ $classroom->section ?? ($classroom->subject->name ?? 'N/A') }}</p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $classroom->updated_at->format('M d, Y') }}</p>
                                    </div>

                                    <div class="text-right flex-shrink-0">
                                        <p class="text-xs text-gray-500">
                                            {{ $classroom?->classroomStudents()?->count() ?? 0 }}</p>
                                    </div>
                                </div>

                                <div class="mt-3 flex items-center gap-2">
                                    <a href="{{ route('teacher.classrooms.unarchive', $classroom) }}"
                                        onclick="event.preventDefault(); document.getElementById('unarchive-form-{{ $classroom->id }}').submit();"
                                        class="btn btn-ghost btn-xs">
                                        <i class="fi fi-rr-undo mr-1"></i>
                                        Unarchive
                                    </a>

                                    <form id="unarchive-form-{{ $classroom->id }}"
                                        action="{{ route('teacher.classrooms.unarchive', $classroom) }}" method="POST"
                                        class="hidden">
                                        @csrf
                                        @method('PUT')
                                    </form>

                                    <button onclick="deleteClassroom('{{ $classroom->id }}')"
                                        class="btn btn-ghost btn-xs text-error">
                                        <i class="fi fi-rr-trash mr-1"></i>
                                        Delete
                                    </button>

                                    <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                                        class="ml-auto text-xs text-accent font-medium">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                        <i class="fi fi-rr-inbox text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm sm:text-base text-gray-600">No archived classrooms</p>
                        <p class="text-xs text-gray-500">Your archived classrooms will appear here</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop table (visible on md and up) -->
            <div class="hidden md:block bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th class="text-left">Classroom</th>
                                <th class="text-left">Subject</th>
                                <th class="text-left">Grade Level</th>
                                {{-- <th class="text-left">Strand</th> --}}
                                <th class="text-center">Students</th>
                                <th class="text-left">Archived Date</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($archivedClassrooms as $classroom)
                                <tr>
                                    <td>
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-medium text-sm truncate">{{ $classroom->name }}</span>
                                            <span
                                                class="text-xs text-gray-500 truncate">{{ $classroom->section }}</span>
                                        </div>
                                    </td>
                                    <td class="text-sm">{{ $classroom->subject->name ?? 'N/A' }}</td>
                                    {{-- <td class="text-sm">{{ $classroom->gradeLevel->name ?? 'N/A' }}</td> --}}
                                    <td class="text-sm">{{ $classroom->strand->name ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-sm text-xs">
                                            {{ $classroom?->classroomStudents()?->count() ?? 0 }} students
                                        </span>
                                    </td>
                                    <td class="text-sm">{{ $classroom->updated_at->format('M d, Y') }}</td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('teacher.classrooms.unarchive', $classroom) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to unarchive this classroom?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-ghost btn-sm" title="Unarchive">
                                                    <i class="fi fi-rr-undo"></i>
                                                </button>
                                            </form>

                                            <button onclick="deleteClassroom('{{ $classroom->id }}')"
                                                class="btn btn-ghost btn-sm text-error" title="Delete Permanently">
                                                <i class="fi fi-rr-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fi fi-rr-inbox text-4xl mb-2"></i>
                                            <p class="text-lg">No archived classrooms</p>
                                            <p class="text-sm">Your archived classrooms will appear here</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination (desktop) -->
                <div class="p-4 border-t">
                    {{ $archivedClassrooms->links() }}
                </div>
            </div>

            <!-- Pagination for mobile (if needed) -->
            <div class="mt-4 md:hidden">
                @if ($archivedClassrooms->hasPages())
                    <div class="flex justify-center">
                        {{ $archivedClassrooms->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <dialog id="delete_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Delete Classroom Permanently</h3>
            <p class="py-4 flex items-start gap-3">
                <i class="fi fi-rr-exclamation text-warning text-xl"></i>
                <span class="text-sm">Are you sure you want to permanently delete this classroom? This action cannot be
                    undone.</span>
            </p>

            <div id="delete_warning" class="alert alert-warning mt-2">
                <i class="fi fi-rr-info"></i>
                <span class="text-sm">The classroom must have no enrolled students or grades to be deleted.</span>
            </div>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Cancel</button>
                </form>
                <form id="delete_form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error">
                        Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </dialog>

    @push('scripts')
        <script>
            function deleteClassroom(classroomId) {
                const deleteForm = document.getElementById('delete_form');
                deleteForm.action = `/teacher/classrooms/${classroomId}/force-delete`;
                document.getElementById('delete_modal').showModal();
            }
        </script>
    @endpush
</x-dashboard.teacher.base>
