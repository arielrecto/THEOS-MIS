@php
    use App\Enums\GeneralStatus;
@endphp

<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="_('Grades')" />
    <x-notification-message />

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <!-- Filters -->
        <div class="mb-6">
            <div class="flex items-center space-x-4">
                <select onchange="window.location.href=this.value" class="select select-bordered w-full md:w-64">
                    <option value="{{ route('teacher.grades.index') }}" {{ !request()->classroom_id ? 'selected' : '' }}>
                        All Classrooms
                    </option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ route('teacher.grades.index', ['classroom_id' => $classroom->id]) }}"
                            {{ request()->classroom_id == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->subject->name }} - {{ $classroom->strand->acronym }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Grades List -->
        @foreach ($classrooms as $classroom)
            <div class="mb-8">
                <!-- Classroom Header -->
                <div class="flex items-center justify-between mb-4 bg-gray-50 p-4 rounded-lg">
                    <div>
                        <h3 class="text-sm lg:text-lg font-bold text-accent">
                            {{ $classroom->subject->name }} - {{ $classroom->strand->acronym }}
                        </h3>
                        <p class="text-xs lg:text-sm text-gray-600">
                            {{ $classroom->academicYear->name }} | {{ $classroom->schedule }}
                        </p>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $classroom->classroomStudents->count() }} students
                    </div>
                </div>

                <!-- Desktop Table (md+) -->
                <div class="overflow-x-auto hidden md:block">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th class="bg-accent text-white">Student</th>
                                <th class="bg-accent text-white">Grade</th>
                                @foreach ($classroom->tasks as $task)
                                    <th class="bg-accent text-white">{{ $task->name }}
                                        <span class="text-xs block opacity-75">Max: {{ $task->max_score }}</span>
                                    </th>
                                @endforeach
                                <th class="bg-accent text-white text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classroom->classroomStudents as $c_student)
                                <tr class="hover">
                                    <td class="font-medium capitalize ">{{ $c_student->student->name }}</td>
                                    <td class="font-bold text-accent">
                                        {{ $c_student->student->overAllAverageTaskByClassroom($classroom->id) }}%
                                    </td>
                                    @foreach ($classroom->tasks as $task)
                                        <td>
                                            @php
                                                $s_task = $c_student->student->tasks
                                                    ->where('task_id', $task->id)
                                                    ->first();
                                                $maxScore = max($task->max_score ?? 1, 1);
                                            @endphp
                                            @if ($s_task)
                                                <div class="flex items-center space-x-2">
                                                    <span
                                                        class="text-sm {{ $s_task->score ? 'text-accent' : 'text-warning' }}">
                                                        {{ $s_task->score ?? GeneralStatus::NOTGRADED->value }}
                                                    </span>
                                                    <div class="w-full bg-gray-200 rounded h-1">
                                                        <div class="bg-accent h-1 rounded"
                                                            style="width: {{ (($s_task->score ?? 0) / $maxScore) * 100 }}%">
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400">--</span>
                                            @endif
                                        </td>
                                    @endforeach

                                    <td>
                                        <!-- Add Process Grade Button -->
                                        <div class="mb-4 flex justify-end">
                                            <button class="btn btn-accent"
                                                onclick="document.getElementById('grade_modal_{{ $c_student->student->id }}').showModal()">
                                                <i class="fi fi-rr-file-check mr-2"></i>
                                                Process Grades
                                            </button>
                                        </div>

                                        <dialog id="grade_modal_{{ $c_student->student->id }}" class="modal">
                                            <div class="modal-box">
                                                <form method="dialog">
                                                    <button
                                                        class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                                                        onclick="document.getElementById('grade_modal_{{ $c_student->student->id }}').close()">✕</button>
                                                </form>
                                                <h3 class="font-bold text-lg mb-4">Process Grades</h3>

                                                <form method="POST"
                                                    action="{{ route('teacher.grades.store.individual') }}"
                                                    class="space-y-4">
                                                    @csrf

                                                    <input type="hidden" name="student_id"
                                                        value="{{ $c_student->student->id }}">
                                                    <input type="hidden" name="classroom_id"
                                                        value="{{ $classroom->id }}">

                                                    <!-- Quarter Selection -->
                                                    <div class="form-control">
                                                        <label class="label">
                                                            <span class="label-text">Select Quarter</span>
                                                        </label>
                                                        <select name="quarter" class="select select-bordered w-full"
                                                            required>
                                                            <option value="">Select Quarter</option>
                                                            <option value="Q1">1st Quarter</option>
                                                            <option value="Q2">2nd Quarter</option>
                                                            <option value="Q3">3rd Quarter</option>
                                                            <option value="Q4">4th Quarter</option>
                                                        </select>
                                                    </div>

                                                    <input type="text" name="grade"
                                                        value="{{ $c_student->student->overAllAverageTaskByClassroom($classroom->id) }}"
                                                        class="input input-bordered w-full">

                                                    <!-- Modal Actions -->
                                                    <div class="modal-action">
                                                        <button type="button" class="btn"
                                                            onclick="document.getElementById('grade_modal_{{ $c_student->student->id }}').close()">Cancel</button>
                                                        <button type="submit" class="btn btn-accent">
                                                            <i class="fi fi-rr-disk mr-2"></i>
                                                            Submit Grades
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <form method="dialog" class="modal-backdrop">
                                                <button
                                                    onclick="document.getElementById('grade_modal_{{ $c_student->student->id }}').close()">close</button>
                                            </form>
                                        </dialog>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden space-y-4">
                    @foreach ($classroom->classroomStudents as $c_student)
                        <div class="card bg-base-100 shadow-sm p-4">
                            <div class="flex items-center justify-between">
                                <div class="min-w-0">
                                    <div class="font-medium truncate">{{ $c_student->student->name }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ $c_student->student->id }}</div>
                                </div>

                                <div class="text-right">
                                    <div class="font-bold text-accent text-lg">
                                        {{ $c_student->student->overAllAverageTaskByClassroom($classroom->id) }}%</div>
                                    <div class="text-xs text-gray-500">Average</div>
                                </div>
                            </div>

                            @if ($classroom->tasks->count())
                                <div class="mt-3 space-y-2">
                                    @foreach ($classroom->tasks as $task)
                                        @php
                                            $s_task = $c_student->student->tasks->where('task_id', $task->id)->first();
                                            $maxScore = max($task->max_score ?? 1, 1);
                                            $pct = $s_task ? (($s_task->score ?? 0) / $maxScore) * 100 : 0;
                                        @endphp
                                        <div>
                                            <div class="flex justify-between items-center text-xs text-gray-600">
                                                <div class="truncate">{{ $task->name }}</div>
                                                <div class="ml-2">
                                                    {{ $s_task->score ?? GeneralStatus::NOTGRADED->value }}</div>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded h-2 mt-1">
                                                <div class="bg-accent h-2 rounded" style="width: {{ $pct }}%">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-3 flex justify-end">
                                <button class="btn btn-xs btn-accent"
                                    onclick="document.getElementById('grade_modal_{{ $c_student->student->id }}').showModal()">
                                    <i class="fi fi-rr-file-check mr-1"></i> Process
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-dashboard.teacher.base>
