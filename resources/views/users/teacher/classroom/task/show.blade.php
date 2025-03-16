<x-dashboard.teacher.base>

    <x-dashboard.page-title :back_url="route('teacher.tasks.index', ['classroom_id' => $task->classroom->id])" :title="_('tasks')" />
    <x-notification-message />
    <div class="panel min-h-96">


        <div class="overflow-x-auto flex flex-col gap-2">
            <h1 class="text-lg py-5 text-accent font-bold capitalize">Tasks - {{ $task->name }}</h1>
            <div class="flex items-center justify-end">

                <p class="text-xs text-gray-500">
                    Date Posted : {{ date('F d, Y h:s A', strtotime($task->created_at)) }}
                </p>
            </div>
            <h1 class="text-lg font-bold text-accent">Duration</h1>
            <div class="flex flex-col gap-5">
                <div class="flex gap-2 items-center text-sm">
                    {{ date('F d, Y h:s A', strtotime($task->start_date)) }} -
                    {{ date('F d, Y h:s A', strtotime($task->end_date)) }}
                </div>

                <div class="min-h-32 bg-gray-100 w-full rounded-lg p-2">
                    {{ $task->description }}
                </div>
                <h1 class="text-lg font-bold text-accent">Attachments</h1>
                <div class="flex flex-wrap gap-2 w-full">
                    @forelse ($task->attachments as $attachment)
                        <a href="{{ $attachment->file }}" target="_blank" data-preview="{{ $attachment->file }}"
                            class=" border rounded-lg">
                            <div class="flex items-center justify-center h-32 w-32 rounded-lg bg-white" x-data="generateThumbnail">
                                <img class="h-16 w-16" :src="getThumbnail(`{{$attachment->extension}}`)"/>
                            </div>
                        </a>
                    @empty
                    @endforelse
                </div>

            </div>

            <h1 class="text-lg font-bold text-accent">Students</h1>
            <table class="table">

                <thead>
                    <tr class="bg-accent text-white">
                        <th></th>
                        <th>Name</th>
                        <th>Task</th>
                        <th>classroom</th>
                        <th>Score</th>
                        <th>Attachment</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>

                    @forelse ($task->assignStudents as $a_student)
                        <tr>
                             <th></th>
                            <th>{{ $a_student->user->name }}</th>
                            <th>{{ $a_student->task->name }}</th>
                            <th>{{ $a_student->task->classroom->name }}</th>
                            <th>{{$a_student->score ?? 0}}</th>
                            <th>{{$a_student->attachments()->count()}}</th>
                            <th>{{$a_student->status}}</th>
                            {{-- <th>{{ $task->end_date }}</th>
                            <th>{{ $task->max_score }}</th>
                            <th>{{ count($task->assignStudents) }}</th>  --}}
                            <td class="flex items-center gap-2">
                                <a href="{{route('teacher.studentTask.show', ['student_task' => $a_student->id])}}" class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <form action="#" method="post">
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

    <script>
        function getYouTubeId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }
    </script>
</x-dashboard.teacher.base>
