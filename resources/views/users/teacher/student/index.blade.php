<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="_('Students')" />
    <x-notification-message />


    <div class="p-6">
        <!-- Classroom Filter -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <label class="text-sm font-medium text-gray-700">Filter by Classroom:</label>
                <select id="classroom-filter" onchange="window.location.href=this.value" class="select select-bordered">
                    <option value="{{ route('teacher.student.index') }}"
                        {{ !request()->classroom_id ? 'selected' : '' }}>
                        All Classrooms
                    </option>
                    @foreach (Auth::user()->teacherClassrooms as $classroom)
                        <option value="{{ route('teacher.student.index', ['classroom_id' => $classroom->id]) }}"
                            {{ request()->classroom_id == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->subject->name }} - {{ $classroom->strand->acronym }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="text-sm text-gray-500">
                Total Students: {{ $students->total() }}
            </div>
        </div>


        <!-- Students Table -->
        <div class="overflow-x-auto">
            <table class="table w-full table-zebra">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Student') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Enrolled Classrooms') }}</th>
                        <th>{{ __('Join Date') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div class="avatar">
                                        <div class="w-10 h-10 rounded-full">
                                            <img src="{{ $student->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}"
                                                alt="Student Profile">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $student->name }}</div>
                                        <div class="text-sm opacity-50">ID: {{ $student->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($student->asStudentClassrooms as $studentClassroom)
                                        <span class="badge badge-accent badge-sm">
                                            {{ $studentClassroom->classroom->subject->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td>{{ $student->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="flex space-x-2">
                                    <a href="{{ route('teacher.student.show', ['student' => $student->id, 'classroom_id' => request()->classroom_id]) }}"
                                        class="btn btn-sm btn-accent">
                                        <i class="fi fi-rr-eye mr-2"></i>
                                        {{ __('View') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                {{ __('No students found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>

</x-dashboard.teacher.base>
