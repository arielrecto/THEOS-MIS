@php
    use App\Enums\GeneralStatus;
@endphp

<x-dashboard.teacher.base>

    <x-dashboard.page-title :back_url="route('teacher.classrooms.show', ['classroom' => $classroom_id])" :title="_('Grades')" />
    <x-notification-message />
    <div class="panel min-h-96">
        <div class="overflow-x-auto">
            <h1 class="text-lg py-5 text-accent font-bold">Grades</h1>
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="bg-accent text-white">

                        <th>Student</th>
                        <th>Overall</th>
                        @foreach ($tasks as $task)
                            <th>{{ $task->name }}</th>
                        @endforeach


                        {{-- <th>Job</th>
                            <th>Favorite Color</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->

                    @foreach ($students as $c_student)
                        <tr>
                            <td>{{ $c_student->student->name }}</td>
                            <th>{{$c_student->student->overallGrade()}} %</th>
                            @foreach ($tasks as $task)
                                <td>
                                    @php
                                        $s_task = $c_student->student->tasks->where('task_id', $task->id)->first();
                                    @endphp
                                    @if ($s_task)
                                        <p class="text-sm text-accent capitalize"> {{ $s_task->score ?? GeneralStatus::NOTGRADED->value }} /
                                            {{ $task->max_score }}</p>
                                    @else
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>
</x-dashboard.teacher.base>
