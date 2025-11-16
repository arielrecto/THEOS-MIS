<x-dashboard.teacher.base>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Archived Classrooms</h2>
                    <p class="text-gray-600 text-sm mt-1">View and manage your archived classrooms</p>
                </div>
                <a href="{{ route('teacher.classrooms.index') }}"
                   class="btn btn-ghost btn-sm gap-2">
                    <i class="fi fi-rr-arrow-left"></i>
                    Back to Classrooms
                </a>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <i class="fi fi-rr-archive text-2xl text-gray-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Archived</p>
                        <p class="text-2xl font-semibold">{{ $archivedClassrooms->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- Archived Classrooms List -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Classroom</th>
                                <th>Subject</th>
                                <th>Grade Level</th>
                                <th>Strand</th>
                                <th>Students</th>
                                <th>Archived Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($archivedClassrooms as $classroom)
                                <tr>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $classroom->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $classroom->section }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $classroom->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $classroom->gradeLevel->name ?? 'N/A' }}</td>
                                    <td>{{ $classroom->strand->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-sm">
                                            {{ $classroom?->classroomStudents()?->count() ?? 0 }} students
                                        </span>
                                    </td>
                                    <td>{{ $classroom->updated_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <!-- Unarchive Button -->
                                            <form action="{{ route('teacher.classrooms.unarchive', $classroom) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to unarchive this classroom?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="btn btn-ghost btn-sm"
                                                        title="Unarchive">
                                                    <i class="fi fi-rr-undo"></i>
                                                </button>
                                            </form>

                                            <!-- Delete Button -->
                                            <button onclick="deleteClassroom('{{ $classroom->id }}')"
                                                    class="btn btn-ghost btn-sm text-error"
                                                    title="Delete Permanently">
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

                <!-- Pagination -->
                <div class="p-4 border-t">
                    {{ $archivedClassrooms->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <dialog id="delete_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Delete Classroom Permanently</h3>
            <p class="py-4">
                <i class="fi fi-rr-exclamation text-warning text-xl"></i>
                <span class="ml-2">Are you sure you want to permanently delete this classroom? This action cannot be undone.</span>
            </p>

            <div id="delete_warning" class="alert alert-warning mt-4">
                <i class="fi fi-rr-info"></i>
                <span>The classroom must have no enrolled students or grades to be deleted.</span>
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
