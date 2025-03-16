<x-dashboard.admin.base>

    <x-dashboard.page-title :title="_('Student')" />
    <x-notification-message />
    <div class="panel min-h-96">

        <div class="flex gap-2 h-full">
            <div class="w-1/3 h-full border-r-2 border-gray-100 flex flex-col gap-2">
                <div class="flex justify-center">
                    <div class="flex flex-col gap-2 items-center">
                        <img src="https://ui-avatars.com/api/?name=ariel+recto" class="h-32 w-32 rounded-full" />
                        <h1 class="font-bold text-lg tracking-widest capitalize">{{ $student->name }}</h1>
                        <a href="#" class="underline text-sm text-blue-700">Edit</a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col grow space-y-5">
                <div class="grid grid-cols-2 grid-flow-row gap-2 h-32">
                    <div class="flex flex-col gap-2 bg-accent rounded-lg text-primary p-2 justify-between">
                        <h1 class="text-lg font-bold">Classrooms</h1>
                        <span
                            class="text-3xl font-bold text-center">{{ $student->asStudentClassrooms()->count() }}</span>
                    </div>


                    {{-- <div class="flex flex-col gap-2 bg-accent rounded-lg text-primary p-2 justify-between">
                        <h1 class="text-lg font-bold">Attendance</h1>
                        <span class="text-3xl font-bold text-center">1</span>
                    </div> --}}
                </div>
                <h1 class="text-lg font-bold">Classroom</h1>
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead class="bg-accent text-white">
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
                                    <td class="flex items-center gap-5">
                                        {{-- <a href="{{route('admin.subjects.show', ['subject' => $subject->id])}}" class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <a href="{{route('admin.subjects.edit', ['subject' => $subject->id])}}" class="btn btn-xs btn-primary">
                                    <i class="fi fi-rr-edit"></i>
                                </a>

                                <form action="{{route('admin.subjects.destroy', ['subject' => $subject->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-error ">
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
                    <h1 class="text-lg py-5 text-accent font-bold">Attendances</h1>
                    <table class="table">

                        <thead>
                            <tr class="bg-accent text-white">
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
