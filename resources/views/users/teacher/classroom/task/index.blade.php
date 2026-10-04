<x-dashboard.teacher.base>

    <x-dashboard.page-title
        :back_url="$classroom ? route('teacher.classrooms.show', ['classroom' => $classroom->id]) : route('teacher.dashboard')"
        :title="$classroom ? $classroom->subject->name . ' Classroom - Tasks' : __('All Tasks')"
        :create_url="$classroom ? route('teacher.tasks.create', ['classroom_id' => $classroom->id]) : null" />
    <x-notification-message />

    <!-- Subject tabs: one dedicated page per classroom -->
    <div class="flex overflow-x-auto gap-2 pb-4">
        <a href="{{ route('teacher.tasks.index') }}"
            class="btn btn-sm whitespace-nowrap {{ $classroom ? 'btn-ghost' : 'btn-accent text-white' }}">
            All Subjects
        </a>
        @foreach ($classrooms as $tab)
            <a href="{{ route('teacher.tasks.index', ['classroom_id' => $tab->id]) }}"
                class="btn btn-sm whitespace-nowrap capitalize {{ $classroom?->id === $tab->id ? 'btn-accent text-white' : 'btn-ghost' }}">
                {{ $tab->subject->name }}
                @if ($tab->strand)
                    <span class="text-xs font-normal opacity-70">({{ $tab->strand->name }})</span>
                @endif
            </a>
        @endforeach
    </div>

    <div class="panel min-h-96">

        <div class="overflow-x-auto">
            <div class="flex flex-col gap-1 py-5 sm:flex-row sm:justify-between sm:items-center">
                <h1 class="text-lg font-bold capitalize text-accent">
                    {{ $classroom ? $classroom->subject->name . ' Tasks' : 'Tasks' }}
                </h1>
                @if ($classroom)
                    <span class="text-sm text-gray-600">
                        Class Code: <span class="text-accent">{{ $classroom->class_code }}</span>
                    </span>
                @endif
            </div>
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="text-white bg-accent">
                        <th></th>
                        <th>Name</th>
                        @unless ($classroom)
                            <th>Subject</th>
                        @endunless
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Max Score</th>
                        <th>Total Assign Student</th>
                        <th>Total Submit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <th></th>
                            <th>{{ $task->name }}</th>
                            @unless ($classroom)
                                <th>
                                    <a href="{{ route('teacher.tasks.index', ['classroom_id' => $task->classroom_id]) }}"
                                        class="capitalize link link-accent">
                                        {{ $task->classroom?->subject?->name }}
                                    </a>
                                </th>
                            @endunless
                            <th>{{ $task->start_date }}</th>
                            <th>{{ $task->end_date }}</th>
                            <th>{{ $task->max_score }}</th>
                            <th>{{ $task->assign_students_count }}</th>
                            <th>{{ $task->submitted_count }}</th>

                            <td class="flex gap-2 items-center">
                                <div class="tooltip tooltip-left" data-tip="View">
                                    <a href="{{ route('teacher.tasks.show', ['task' => $task->id]) }}"
                                        class="text-white btn btn-xs btn-accent">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                </div>

                                <div class="tooltip tooltip-left" data-tip="Delete">
                                    <form action="{{ route('teacher.tasks.destroy', ['task' => $task->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="text-white btn btn-xs btn-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="{{ $classroom ? 8 : 9 }}" class="text-center text-gray-500">
                                {{ $classroom ? 'No tasks for ' . $classroom->subject->name . ' yet.' : 'No Tasks' }}
                            </th>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $tasks->links() }}
        </div>
    </div>
</x-dashboard.teacher.base>
