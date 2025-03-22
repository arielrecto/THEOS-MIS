<x-dashboard.teacher.base>

    <x-dashboard.page-title :title="_('students')" :back_url="route('teacher.classrooms.show', ['classroom' => $id])" />
    <x-notification-message />
    <div class="panel min-h-96">


        <div class="overflow-x-auto">
            <h1 class="text-lg py-5 text-accent font-bold">Students</h1>
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="bg-accent text-white">
                        <th></th>
                        <th>Name</th>
                        <th>Date Joined</th>
                        <th>Action</th>
                        {{-- <th>Job</th>
                            <th>Favorite Color</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->

                    @forelse ($classroomStudents as $classroomStudent)
                        <tr>
                            <th></th>
                            <td>{{ $classroomStudent->student->name }}</td>
                            <td>{{ date('F d, Y H:s A', strtotime($classroomStudent->created_at))}}</td>
                            <td class="flex items-center gap-2">
                                <a href="{{route('teacher.student.show', ['student' => $classroomStudent->student->id])}}" class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <form action="{{route('teacher.classrooms.student.remove', ['classroom_student' => $classroomStudent->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-error ">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th>No Students</th>

                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>
</x-dashboard.teacher.base>
