<x-dashboard.admin.base>

    <x-dashboard.page-title :title="_('Student')"  :back_url="route('admin.users.students.index')"/>
    <x-notification-message />

    <div class="panel">
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Left: profile (stacked on mobile) -->
            <aside class="w-full sm:w-1/3 bg-white rounded-lg border p-4 flex flex-col items-center gap-3">
                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=256"
                    alt="{{ $student->name }}"
                    class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover shadow-sm" />

                <h1 class="text-lg sm:text-xl font-semibold text-gray-800 text-center break-words">{{ $student->name }}</h1>

                <div class="w-full text-center">
                    <a href="#" class="text-sm text-primary underline">Edit Profile</a>
                </div>

                <div class="w-full mt-2 grid grid-cols-2 gap-2">
                    <div class="p-3 rounded-lg bg-accent/10 text-center">
                        <div class="text-xs text-gray-600">Classrooms</div>
                        <div class="text-lg font-bold text-accent">{{ $student->asStudentClassrooms()->count() }}</div>
                    </div>
                    <div class="p-3 rounded-lg bg-accent/10 text-center">
                        <div class="text-xs text-gray-600">Student ID</div>
                        <div class="text-lg font-medium break-words">{{ $student->student_id ?? 'N/A' }}</div>
                    </div>
                </div>
            </aside>

            <!-- Right: details & classrooms -->
            <main class="w-full sm:flex-1 flex flex-col gap-4">
                <section class="bg-white rounded-lg border p-4">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">Student Details</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-700">
                        <div>
                            <div class="text-xs text-gray-500">Full name</div>
                            <div class="font-medium break-words">{{ $student->name }}</div>
                        </div>

                        <div>
                            <div class="text-xs text-gray-500">Email</div>
                            <div class="font-medium break-words">{{ $student->email }}</div>
                        </div>

                        <div>
                            <div class="text-xs text-gray-500">Phone</div>
                            <div class="font-medium break-words">{{ $student->phone ?? 'N/A' }}</div>
                        </div>

                        <div>
                            <div class="text-xs text-gray-500">Enrollment</div>
                            <div class="font-medium break-words">{{ $student->enrollment_year ?? 'N/A' }}</div>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3">Classrooms</h2>

                    <!-- Mobile: stacked cards -->
                    <div class="block sm:hidden space-y-3">
                        @forelse ($student->asStudentClassrooms as $classroom)
                            <div class="bg-white rounded-lg border shadow-sm p-3">
                                <div class="flex items-start gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-2">
                                            <h3 class="text-sm font-semibold text-gray-800 break-words">
                                                {{ $classroom->name }}
                                            </h3>
                                            <span class="text-xs text-gray-500">{{ $classroom->class_code }}</span>
                                        </div>

                                        <p class="text-xs text-gray-600 mt-1 break-words">
                                            Subject: <span class="font-medium">{{ $classroom->subject->name ?? 'N/A' }}</span>
                                        </p>
                                        <p class="text-xs text-gray-600 mt-1 break-words">
                                            Teacher: <span class="font-medium">{{ $classroom->teacher->name ?? 'N/A' }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-3 flex flex-wrap gap-2">
                                    <a href="#"
                                       class="btn btn-ghost btn-sm flex-1 min-w-[96px] text-xs flex items-center justify-center gap-2">
                                        <i class="fi fi-rr-eye"></i> View
                                    </a>

                                    <a href="#"
                                       class="btn btn-ghost btn-sm flex-1 min-w-[96px] text-xs flex items-center justify-center gap-2">
                                        <i class="fi fi-rr-user"></i> Instructor
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-lg shadow-sm p-4 text-center text-gray-500 border">
                                <i class="fi fi-rr-book text-2xl mb-2"></i>
                                <p class="text-sm">No classrooms assigned</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Desktop / Tablet: regular table -->
                    <div class="hidden sm:block overflow-x-auto bg-white rounded-lg border">
                        <table class="table w-full">
                            <thead class="bg-accent text-white">
                                <tr>
                                    <th class="w-6"></th>
                                    <th>Name</th>
                                    <th>Classroom Code</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($student->asStudentClassrooms as $classroom)
                                    <tr>
                                        <td></td>
                                        <td class="align-middle">{{ $classroom->name }}</td>
                                        <td class="align-middle">{{ $classroom->class_code }}</td>
                                        <td class="align-middle">{{ $classroom->subject->name ?? 'N/A' }}</td>
                                        <td class="align-middle">{{ $classroom->teacher->name ?? 'N/A' }}</td>
                                        <td class="align-middle text-right">
                                            <a href="#" class="btn btn-xs btn-accent" title="View">
                                                <i class="fi fi-rr-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-6 text-gray-500">No classrooms</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </div>
    </div>
</x-dashboard.admin.base>
