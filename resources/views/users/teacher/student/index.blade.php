<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ...existing head (if any in base) ... -->
</head>
<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="_('Students')" />
    <x-notification-message />

    <div class="p-4 md:p-6 max-w-full">
        <!-- Classroom Filter -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
                <label class="text-sm md:text-base font-medium text-gray-700 block">Filter by Classroom:</label>

                <select id="classroom-filter"
                        onchange="if(this.value) window.location.href=this.value"
                        class="select select-bordered w-full md:w-80 text-sm md:text-base">
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

            <div class="text-sm md:text-base text-gray-500 mt-2 md:mt-0">
                Total Students: {{ $students->total() }}
            </div>
        </div>

        <!-- Desktop Table (visible on md and up) -->
        <div class="overflow-x-auto hidden md:block">
            <table class="table w-full table-zebra text-sm md:text-base">
                <thead>
                    <tr>
                        <th class="w-12">#</th>
                        <th class="max-w-xs">Student</th>
                        <th class="max-w-sm">Email</th>
                        <th>Enrolled Classrooms</th>
                        <th class="whitespace-nowrap">Join Date</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="align-top text-sm md:text-base">{{ $loop->iteration }}</td>
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div class="avatar">
                                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full overflow-hidden">
                                            <img class="object-cover w-full h-full"
                                                src="{{ $student->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}"
                                                alt="Student Profile">
                                        </div>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold truncate text-sm md:text-base">{{ $student->name }}</div>
                                        <div class="text-xs md:text-sm opacity-50 truncate">ID: {{ $student->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="truncate max-w-xs text-xs md:text-sm">{{ $student->email }}</td>
                            <td>
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($student->asStudentClassrooms as $studentClassroom)
                                        <span class="badge badge-accent badge-sm text-xs md:text-sm break-words">
                                            {{ $studentClassroom->classroom->subject->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="whitespace-nowrap text-sm md:text-base">{{ $student->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="flex flex-wrap gap-2 justify-end">
                                    <a href="{{ route('teacher.student.show', ['student' => $student->id, 'classroom_id' => request()->classroom_id]) }}"
                                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-accent text-white text-sm md:text-sm hover:opacity-95">
                                        <i class="fi fi-rr-eye"></i>
                                        <span class="hidden md:inline">View</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-sm md:text-base">
                                {{ __('No students found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards (visible below md) -->
        <div class="md:hidden space-y-3">
            @forelse($students as $student)
                <article class="bg-white border rounded-lg p-3 sm:p-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full overflow-hidden">
                                <img class="w-full h-full object-cover"
                                    src="{{ $student->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) }}"
                                    alt="Avatar">
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3">
                                <div class="truncate">
                                    <div class="font-medium text-sm sm:text-base truncate">{{ $student->name }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500 truncate">ID: {{ $student->id }}</div>
                                </div>
                                <div class="text-xs sm:text-sm text-gray-500">{{ $student->created_at->format('M d, Y') }}</div>
                            </div>

                            <div class="mt-2 text-sm sm:text-base text-gray-600 break-words">{{ $student->email }}</div>

                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($student->asStudentClassrooms as $studentClassroom)
                                    <span class="text-xs sm:text-sm break-words">
                                        {{ $studentClassroom->classroom->subject->name }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('teacher.student.show', ['student' => $student->id, 'classroom_id' => request()->classroom_id]) }}"
                                        class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-md bg-accent text-white text-sm w-full touch-manipulation">
                                        <i class="fi fi-rr-eye"></i>
                                        <span>View</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center py-8 text-sm">
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
