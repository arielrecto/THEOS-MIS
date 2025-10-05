<x-dashboard.admin.base>

    <x-dashboard.page-title :title="_('Student')"  :back_url="route('admin.users.students.index')"/>
    <x-notification-message />
    <div class="panel min-h-96">

        <div class="flex gap-2 h-full">
            <div class="flex flex-col gap-2 w-1/3 h-full border-r-2 border-gray-100">
                <div class="flex justify-center">
                    <div class="flex flex-col gap-2 items-center">
                        <img src="https://ui-avatars.com/api/?name={{$student->name}}" class="w-32 h-32 rounded-full" />
                        <h1 class="text-lg font-bold tracking-widest capitalize">{{ $student->name }}</h1>
                        <a href="#" class="text-sm text-blue-700 underline">Edit</a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col space-y-5 grow">
                <div class="grid grid-cols-2 grid-flow-row gap-2 h-32">
                    <div class="flex flex-col gap-2 justify-between p-2 rounded-lg bg-accent text-primary">
                        <h1 class="text-lg font-bold">Classrooms</h1>
                        <span
                            class="text-3xl font-bold text-center">{{ $student->asStudentClassrooms()->count() }}</span>
                    </div>


                    {{-- <div class="flex flex-col gap-2 justify-between p-2 rounded-lg bg-accent text-primary">
                        <h1 class="text-lg font-bold">Attendance</h1>
                        <span class="text-3xl font-bold text-center">1</span>
                    </div> --}}
                </div>
                <h1 class="text-lg font-bold">Classroom</h1>
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead class="text-white bg-accent">
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Classroom Code</th>
                                <th>Subject</th>
                                <th>Teacher</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($student->asStudentClassrooms as $classroom)
                                <!-- row 1 -->
                                <tr>
                                    <th></th>
                                    <td>{{ $classroom->name }}</td>
                                    <td>{{ $classroom->class_code }}</td>
                                    <td>{{ $classroom->subject->name ?? "N\A"}}</td>
                                    <td>{{ $classroom->teacher->name ?? "N\A"}}</td>
                                    <td class="flex gap-5 items-center">
                                        {{-- <a href="{{route('admin.subjects.show', ['subject' => $subject->id])}}" class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <a href="{{route('admin.subjects.edit', ['subject' => $subject->id])}}" class="btn btn-xs btn-primary">
                                    <i class="fi fi-rr-edit"></i>
                                </a>

                                <form action="{{route('admin.subjects.destroy', ['subject' => $subject->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-error">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form> --}}
                                    </td>
                                </tr>
                            @empty
                                <!-- row 1 -->
                                <tr>
                                    <th>No Classroom</th>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>

                </div>
                {{-- <div x-data="calendarInit">
                    <div x-ref="calendar">

                    </div>
                </div> --}}

                {{-- <div class="overflow-x-auto">
                    <h1 class="py-5 text-lg font-bold text-accent">Attendances</h1>
                    <table class="table">

                        <thead>
                            <tr class="text-white bg-accent">
                                <th></th>
                                <th>Attendance Code</th>
                                <th>Time</th>
                                <th>Date</th>

                            </tr>
                        </thead>
                        <tbody>


                            @forelse ($student_attendances as $s_attendance)
                                <tr>
                                    <th></th>
                                    <td>{{ $s_attendance->attendance->attendance_code }}</td>
                                    <td>{{ date('H:s A', strtotime($s_attendance->created_at))}}</td>
                                    <td>{{ date('F d, Y', strtotime($s_attendance->created_at))}}</td>
                                    {
                                </tr>
                            @empty
                                <tr>
                                    <th>No Attendance</th>

                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
