<x-dashboard.teacher.base>

    <x-dashboard.page-title :title="_('students')" :back_url="route('teacher.classrooms.show', ['classroom' => $id])" />
    <x-notification-message />



    <div class="panel min-h-96">
        <!-- Header with Add Students Button -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h1 class="text-lg text-accent font-bold">Students</h1>
            <div class="flex gap-3">
                <button onclick="add_students_modal.showModal()" class="btn btn-primary gap-2">
                    <i class="fi fi-rr-user-add"></i>
                    <span>Add Students</span>
                </button>

                <a href="{{ route('teacher.classrooms.students.import', $id) }}" class="btn btn-accent gap-2">
                    <i class="fi fi-rr-upload"></i>
                    Bulk Import
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="bg-accent text-white">
                        <th>#</th>
                        <th>LRN</th>
                        <th>Name</th>
                        <th>Strand</th>
                        <th>Date Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($classroomStudents as $index => $classroomStudent)
                        <tr class="hover:bg-gray-50">
                            <th>{{ $index + 1 }}</th>
                            <td>{{ $classroomStudent->student->studentProfile->lrn ?? 'N/A' }}</td>
                            <td>
                                <div class="font-semibold">{{ $classroomStudent->student->name }}</div>
                                <div class="text-sm text-gray-500">{{ $classroomStudent->student->email }}</div>
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $classroom->strand->acronym ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ date('F d, Y', strtotime($classroomStudent->created_at)) }}</td>
                            <td class="flex items-center gap-2">
                                <a href="{{ route('teacher.student.show', ['student' => $classroomStudent->student->id]) }}"
                                    class="btn btn-xs btn-accent" title="View Student">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <form
                                    action="{{ route('teacher.classrooms.student.remove', ['classroom_student' => $classroomStudent->id]) }}"
                                    method="post"
                                    onsubmit="return confirm('Are you sure you want to remove this student from the classroom?');">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-error" title="Remove Student">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fi fi-rr-users-slash text-4xl text-gray-400"></i>
                                    <p class="text-gray-500">No students in this classroom yet</p>
                                    <button onclick="add_students_modal.showModal()"
                                        class="btn btn-sm btn-primary gap-2">
                                        <i class="fi fi-rr-user-add"></i>
                                        Add Students
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($classroomStudents->count() > 0)
            <div class="mt-4">
                {{ $classroomStudents->links() }}
            </div>
        @endif
    </div>

    <!-- Add Students Modal -->
    <dialog id="add_students_modal" class="modal">
        <div class="modal-box max-w-4xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="font-bold text-lg mb-4">Add Students to Classroom</h3>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-start gap-3">
                    <i class="fi fi-rr-info-circle text-blue-600 mt-0.5"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">{{ $classroom->name }}</p>
                        <p>Grade Level: <span class="font-medium">{{ $classroom->strand->name }}
                                ({{ $classroom->strand->acronym }})</span></p>
                        <p>Academic Year: <span class="font-medium">{{ $classroom->academicYear->name }}</span></p>
                        <p class="mt-2 text-xs">Only showing enrolled students in this strand and academic year who are
                            not yet in this classroom.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('teacher.classrooms.student.add-multiple', ['classroom' => $id]) }}" method="POST">
                @csrf

                <!-- Search Filter -->
                <div class="form-control mb-4">
                    <input type="text" id="student_search" placeholder="Search students by name or LRN..."
                        class="input input-bordered w-full" onkeyup="filterStudents()">
                </div>

                <!-- Select All -->
                <div class="form-control mb-4">
                    <label class="label cursor-pointer justify-start gap-3 bg-gray-50 rounded-lg p-3">
                        <input type="checkbox" id="select_all" class="checkbox checkbox-primary"
                            onchange="toggleSelectAll()">
                        <span class="label-text font-semibold">Select All Students</span>
                    </label>
                </div>

                <!-- Students List -->
                <div class="border rounded-lg max-h-96 overflow-y-auto">
                    @if ($availableStudents->count() > 0)
                        <div class="divide-y" id="students_list">
                            @foreach ($availableStudents as $student)
                                <label class="flex items-center gap-3 p-4 hover:bg-gray-50 cursor-pointer student-item"
                                    data-name="{{ strtolower($student->user->name) }}" data-lrn="{{ $student->lrn }}">
                                    <input type="checkbox" name="student_ids[]" value="{{ $student->user_id }}"
                                        class="checkbox checkbox-primary student-checkbox">

                                    <div class="flex-1 min-w-0">
                                        <div class="font-semibold text-gray-900">
                                            {{ $student->user->name }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            LRN: {{ $student->lrn }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $student->user->email }}
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end gap-1">
                                        <span class="badge badge-info badge-sm">
                                            {{ $classroom->strand->acronym }}
                                        </span>
                                        <span class="badge badge-ghost badge-sm">
                                            {{ $classroom->academicYear->name }}
                                        </span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center">
                            <i class="fi fi-rr-users-slash text-4xl text-gray-400 mb-3 block"></i>
                            <p class="text-gray-600 mb-2">No available students found</p>
                            <p class="text-sm text-gray-500">
                                All enrolled students in {{ $classroom->strand->acronym }}
                                ({{ $classroom->academicYear->name }}) are already in this classroom.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Selected Count -->
                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">
                        Selected: <span id="selected_count" class="font-bold text-primary">0</span> student(s)
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="modal-action">
                    <button type="button" onclick="add_students_modal.close()" class="btn btn-ghost">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary gap-2" id="submit_btn" disabled>
                        <i class="fi fi-rr-user-add"></i>
                        Add Selected Students
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    @push('scripts')
        <script>
            // Update selected count and enable/disable submit button
            function updateSelectedCount() {
                const checkboxes = document.querySelectorAll('.student-checkbox:checked');
                const count = checkboxes.length;
                document.getElementById('selected_count').textContent = count;
                document.getElementById('submit_btn').disabled = count === 0;
            }

            // Toggle select all
            function toggleSelectAll() {
                const selectAllCheckbox = document.getElementById('select_all');
                const checkboxes = document.querySelectorAll('.student-checkbox');
                const visibleCheckboxes = Array.from(checkboxes).filter(cb => {
                    const item = cb.closest('.student-item');
                    return item.style.display !== 'none';
                });

                visibleCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateSelectedCount();
            }

            // Filter students by search
            function filterStudents() {
                const searchTerm = document.getElementById('student_search').value.toLowerCase();
                const studentItems = document.querySelectorAll('.student-item');

                studentItems.forEach(item => {
                    const name = item.dataset.name;
                    const lrn = item.dataset.lrn.toLowerCase();

                    if (name.includes(searchTerm) || lrn.includes(searchTerm)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Update select all checkbox state
                updateSelectAllState();
            }

            // Update select all checkbox state
            function updateSelectAllState() {
                const visibleCheckboxes = Array.from(document.querySelectorAll('.student-checkbox')).filter(cb => {
                    const item = cb.closest('.student-item');
                    return item.style.display !== 'none';
                });

                const checkedVisible = visibleCheckboxes.filter(cb => cb.checked).length;
                const selectAllCheckbox = document.getElementById('select_all');

                if (visibleCheckboxes.length === 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                } else if (checkedVisible === visibleCheckboxes.length) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else if (checkedVisible > 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                }
            }

            // Add event listeners to checkboxes
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.student-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateSelectedCount();
                        updateSelectAllState();
                    });
                });
            });
        </script>
    @endpush

</x-dashboard.teacher.base>
