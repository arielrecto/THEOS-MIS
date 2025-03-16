<x-dashboard.teacher.base>

    <x-dashboard.page-title :back_url="route('teacher.classrooms.show', ['classroom' => $classroom_id])" :title="_('tasks')" :create_url="route('teacher.tasks.create', ['classroom_id' => $classroom_id])" />
    <x-notification-message />
    <div class="panel min-h-96">


        <div class="overflow-x-auto">
            <h1 class="text-lg py-5 text-accent font-bold">Tasks</h1>
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="bg-accent text-white">
                        <th></th>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Max Score</th>
                        <th>Total Assign Student</th>
                        <th>Action</th>
                        {{-- <th>Job</th>
                            <th>Favorite Color</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->

                    @forelse ($tasks as $task)
                        <tr>
                            <th></th>
                            <th>{{ $task->name }}</th>
                            <th>{{ $task->start_date }}</th>
                            <th>{{ $task->end_date }}</th>
                            <th>{{ $task->max_score }}</th>
                            <th>{{ count($task->assignStudents) }}</th>

                            <td class="flex items-center gap-2">
                                <a href="{{ route('teacher.tasks.show', ['task' => $task->id]) }}"
                                    class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <form action="{{ route('teacher.tasks.destroy', ['task' => $task->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-error ">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </td>
                        @empty
                        <tr>
                            <th>No Tasks</th>

                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>
</x-dashboard.teacher.base>
