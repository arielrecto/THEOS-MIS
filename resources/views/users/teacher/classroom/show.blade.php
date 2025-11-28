<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="__('Classrooms - Show')" :back_url="route('teacher.classrooms.index')" />
    <x-notification-message />

    <div class="flex flex-col gap-6 p-6 w-full bg-white rounded-lg shadow-lg">
        <!-- Banner -->
        <div class="flex justify-center items-center w-full h-40 sm:h-48 rounded-lg shadow-md bg-accent px-4">
            <h1 class="text-2xl sm:text-3xl font-semibold text-white capitalize text-center truncate max-w-full">
                {{ $classroom->subject->name }}
            </h1>
        </div>

        <!-- Meta row: stack on mobile -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h1 class="text-base sm:text-lg font-semibold min-w-0 break-words">
                Class Code:
                <span class="text-accent break-words">{{ $classroom->class_code }}</span>
            </h1>

            <h1 class="text-sm text-gray-600 whitespace-nowrap sm:whitespace-normal">
                Created On:
                <span
                    class="block sm:inline font-medium">{{ date('F d, Y h:i A', strtotime($classroom->created_at)) }}</span>
            </h1>
        </div>

        <!-- Cards grid: responsive columns -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <x-card-v1 :link="route('teacher.classrooms.students', ['classroom' => $classroom->id])" icon="fi fi-rr-student" label="Students" :count="count($classroom->classroomStudents)" />
            {{-- <x-card-v1 :link="route('teacher.classrooms.attendances', ['classroom' => $classroom->id])" icon="fi fi-rr-calendar" label="Attendance" :count="count($classroom->attendances)" /> --}}
            <x-card-v1 :link="route('teacher.announcements.index', ['classroom' => $classroom->id, 'type' => 'classroom'])" icon="fi fi-rr-bell" label="Announcements" :count="count($classroom->announcements)" />
            <x-card-v1 :link="route('teacher.tasks.index', ['classroom_id' => $classroom->id])" icon="fi fi-rr-list-check" label="Tasks" :count="count($classroom->tasks)" />
        </div>
        <x-tab.tab :tabs="['Student']" :active="1" class="md:hidden" />
        <x-tab.tab :tabs="['Calendar', 'Student']" :active="0" class="hidden md:block" />

        @if (request()->get('activeTab') == 0)
            <div class="p-4 hidden md:block bg-gray-50 rounded-lg shadow min-h-72" x-data="calendarInit">
                <h2 class="text-lg font-semibold text-accent">Calendar</h2>
                <div x-ref="calendar"></div>
            </div>
        @endif

        @if (request()->get('activeTab') == 1)
            <div class="w-full">
                <h1 class="py-4 text-lg font-bold text-accent">Students</h1>

                <!-- Table for SM+ -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="table w-full bg-white rounded-lg shadow-md">
                        <thead class="text-white bg-accent">
                            <tr>
                                <th class="whitespace-nowrap">#</th>
                                <th class="whitespace-nowrap">Name</th>
                                <th class="whitespace-nowrap">Date Joined</th>
                                <th class="text-center whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($classroom->classroomStudents as $index => $classroomStudent)
                                <tr class="text-gray-700 border-b">
                                    <td class="align-top">{{ $index + 1 }}</td>
                                    <td class="align-top min-w-0">
                                        <div class="truncate break-words">{{ $classroomStudent->student->name }}</div>
                                    </td>
                                    <td class="align-top whitespace-nowrap">
                                        {{ date('F d, Y h:i A', strtotime($classroomStudent->created_at)) }}
                                    </td>
                                    <td class="align-top">
                                        <div class="flex gap-2 justify-end">
                                            <a href="{{ route('teacher.student.show', ['student' => $classroomStudent->student->id, 'classroom_id' => $classroom->id]) }}"
                                                class="btn btn-xs btn-accent" aria-label="View student"><i
                                                    class="fi fi-rr-eye"></i></a>

                                            <form
                                                action="{{ route('teacher.classrooms.student.remove', ['classroom_student' => $classroomStudent->id]) }}"
                                                method="post" onsubmit="return confirm('Remove student?')">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-xs btn-error" aria-label="Remove student"><i
                                                        class="fi fi-rr-trash"></i></button>
                                            </form>
                                        </div>
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

                <!-- Card list for mobile -->
                <div class="space-y-3 sm:hidden">
                    @forelse ($classroom->classroomStudents as $index => $classroomStudent)
                        <article class="p-3 bg-gray-50 rounded-lg shadow-sm flex items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-3">
                                    <h3 class="font-medium text-gray-800 truncate break-words">
                                        {{ $classroomStudent->student->name }}
                                    </h3>
                                    <div class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                        #{{ $index + 1 }}
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 break-words">
                                    Joined: {{ date('F d, Y', strtotime($classroomStudent->created_at)) }}
                                </p>
                            </div>

                            <div class="flex-shrink-0 flex flex-col items-end gap-2">
                                <a href="{{ route('teacher.student.show', ['student' => $classroomStudent->student->id, 'classroom_id' => $classroom->id]) }}"
                                    class="btn btn-xs btn-accent w-10 h-8 flex items-center justify-center"
                                    aria-label="View">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <form
                                    action="{{ route('teacher.classrooms.student.remove', ['classroom_student' => $classroomStudent->id]) }}"
                                    method="post" onsubmit="return confirm('Remove student?')">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-error w-10 h-8 flex items-center justify-center"
                                        aria-label="Remove">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="py-4 text-center text-gray-500">No Students Enrolled</div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</x-dashboard.teacher.base>
