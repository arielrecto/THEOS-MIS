<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="__('Classrooms - Show')" :back_url="route('teacher.classrooms.index')" />
    <x-notification-message />

    <div class="flex flex-col gap-6 p-6 w-full bg-white rounded-lg shadow-lg">
        <div class="flex justify-center items-center w-full h-40 rounded-lg shadow-md bg-accent">
            <h1 class="text-3xl font-semibold text-white capitalize">
                {{ $classroom->subject->name }}
            </h1>
        </div>

        <div class="flex justify-between items-center">
            <h1 class="text-lg font-semibold">Class Code: <span class="text-accent">{{ $classroom->class_code }}</span>
            </h1>
            <h1 class="text-sm text-gray-600">Created On: {{ date('F d, Y h:i A', strtotime($classroom->created_at)) }}
            </h1>
        </div>


        <div class="grid grid-cols-4 gap-4">
            <x-card-v1 :link="route('teacher.classrooms.students', ['classroom' => $classroom->id])" icon="fi fi-rr-student" label="Students" :count="count($classroom->classroomStudents)"/>
            <x-card-v1 :link="route('teacher.classrooms.attendances', ['classroom' => $classroom->id])" icon="fi fi-rr-calendar" label="Attendance" :count="count($classroom->attendances)"/>
            <x-card-v1 :link="route('teacher.announcements.index', ['classroom' => $classroom->id])" icon="fi fi-rr-bell" label="Announcements" :count="count($classroom->announcements)"/>
        </div>

        <x-tab.tab :tabs="['Attendance', 'Calendar', 'Student']" :active="0" />

        @if (request()->get('activeTab') == 0)
            <div class="flex flex-col gap-4 p-4 bg-gray-50 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-accent">Attendance</h2>
                @if ($attendance)
                    <div class="flex flex-col items-center">
                        {!! QrCode::size(200)->generate($attendance->attendance_code) !!}
                        <p class="mt-2 text-sm text-gray-600">{{ $attendance->attendance_code }}</p>
                        <a href="{{ route('teacher.classrooms.attendances.scanner', ['attendance' => $attendance->id, 'classroom_id' => $classroom->id]) }}"
                            class="mt-2 btn btn-accent">Scan QR Code</a>
                    </div>
                    <div class="text-sm text-gray-600">
                        <p>Date: {{ date('F d, Y', strtotime($attendance->date)) }}</p>
                        <p>Start Time: {{ date('h:i A', strtotime($attendance->start_time)) }}</p>
                        <p>End Time: {{ date('h:i A', strtotime($attendance->end_time)) }}</p>
                    </div>
                @else
                    <div class="flex justify-end">
                        <a href="{{ route('teacher.classrooms.attendances', ['classroom' => $classroom->id]) }}" class="btn btn-accent">Generate QR Code</a>
                    </div>
                    <div class="flex justify-center items-center p-4 h-full text-gray-500 bg-gray-100 rounded-lg">
                        No Attendance QR Code Available
                    </div>
                @endif
            </div>
        @endif

        @if (request()->get('activeTab') == 1)
            <div class="p-4 bg-gray-50 rounded-lg shadow min-h-96" x-data="calendarInit">
                <h2 class="text-lg font-semibold text-accent">Calendar</h2>
                <div x-ref="calendar"></div>
            </div>
        @endif


        @if (request()->get('activeTab') == 2)
            <div class="overflow-x-auto">
                <h1 class="py-4 text-lg font-bold text-accent">Students</h1>
                <table class="table w-full bg-white rounded-lg shadow-md">
                    <thead class="text-white bg-accent">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classroom->classroomStudents as $index => $classroomStudent)
                            <tr class="text-gray-700 border-b">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $classroomStudent->student->name }}</td>
                                <td>{{ date('F d, Y h:i A', strtotime($classroomStudent->created_at)) }}</td>
                                <td class="flex gap-2">
                                    <a href="{{ route('teacher.student.show', ['student' => $classroomStudent->student->id, 'classroom_id' => $classroom->id]) }}"
                                        class="btn btn-xs btn-accent"><i class="fi fi-rr-eye"></i></a>
                                    <form
                                        action="{{ route('teacher.classrooms.student.remove', ['classroom_student' => $classroomStudent->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-xs btn-error"><i class="fi fi-rr-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">No Students Enrolled</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-dashboard.teacher.base>
