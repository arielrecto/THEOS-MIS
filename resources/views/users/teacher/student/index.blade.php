<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="_('Students')" />
    <x-notification-message />

    <div class="p-6">
        <!-- Classroom Filter -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full md:w-auto">
                <label class="text-sm font-medium text-gray-700 hidden sm:block">Filter by Classroom:</label>
                <select id="classroom-filter" onchange="if(this.value) window.location.href=this.value"
                    class="select select-bordered w-full md:w-80">
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

            <div class="text-sm text-gray-500 mt-2 md:mt-0">
                Total Students: {{ $students->total() }}
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="overflow-x-auto hidden md:block">
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
                            <td class="truncate max-w-xs">{{ $student->email }}</td>
                            <td>
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($student->asStudentClassrooms as $studentClassroom)
                                        <span class="badge badge-accent badge-sm text-xs">
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

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-3">
            @forelse($students as $student)
                <div class="card bg-base-100 shadow-sm p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full overflow-hidden">
                                <img class="w-full h-full object-cover"
                                    src="{{ $student->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}"
                                    alt="Avatar">
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <div class="truncate">
                                    <div class="font-medium truncate">{{ $student->name }}</div>
                                    <div class="text-xs text-gray-500 truncate">ID: {{ $student->id }}</div>
                                </div>
                                <div class="text-xs text-gray-500 ml-3">{{ $student->created_at->format('M d, Y') }}
                                </div>
                            </div>

                            <div class="mt-2 text-sm text-gray-600 truncate">{{ $student->email }}</div>

                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($student->asStudentClassrooms as $studentClassroom)
                                    <span class="badge badge-accent badge-xs text-xs">
                                        {{ $studentClassroom->classroom->subject->name }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="mt-3 flex justify-end">
                                <a href="{{ route('teacher.student.show', ['student' => $student->id, 'classroom_id' => request()->classroom_id]) }}"
                                    class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye mr-1"></i> {{ __('View') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    {{ __('No students found') }}
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>

</x-dashboard.teacher.base>
