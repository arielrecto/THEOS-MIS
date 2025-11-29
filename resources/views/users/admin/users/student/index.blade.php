<x-dashboard.admin.base>
    <x-dashboard.page-title :back_url="route('admin.users.index')" :title="_('students')"  />
    <div class="panel flex flex-col gap-2">
        <!-- Desktop / Tablet: regular table -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>name</th>
                        <th>email</th>
                        <th>Classrooms</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <th></th>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->asStudentClassrooms()->count() }}</td>
                            <td class="flex items-center gap-2">
                                <a href="{{route('admin.users.students.show', ['student' => $student->id])}}" class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>
                                <a href="{{route('admin.users.students.edit', ['student' => $student->id])}}" class="btn btn-xs btn-primary">
                                    <i class="fi fi-rr-edit"></i>
                                </a>
                                <form action="{{route('admin.users.students.destroy', ['student' => $student->id])}}" method="post" onsubmit="return confirm('Delete student?')">
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
                            <td colspan="5" class="text-center py-6 text-gray-500">No students</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile: stacked (card) view - "stack view" for table rows -->
        <div class="block sm:hidden space-y-3">
            @forelse ($students as $student)
                <div class="bg-white rounded-lg border shadow-sm p-3">
                    <div class="flex items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-sm font-semibold text-gray-800 leading-tight break-words">
                                    {{ $student->name }}
                                </h3>
                                <div class="text-xs text-gray-500">
                                    <span class="inline-block px-2 py-0.5 rounded bg-gray-100">{{ $student->asStudentClassrooms()->count() }} classes</span>
                                </div>
                            </div>

                            <p class="text-xs text-gray-600 mt-1 break-words">{{ $student->email }}</p>
                        </div>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                        <a href="{{route('admin.users.students.show', ['student' => $student->id])}}"
                           class="btn btn-ghost btn-sm flex-1 min-w-[100px] text-xs flex items-center justify-center gap-2">
                            <i class="fi fi-rr-eye"></i> View
                        </a>

                        <a href="{{route('admin.users.students.edit', ['student' => $student->id])}}"
                           class="btn btn-ghost btn-sm flex-1 min-w-[100px] text-xs flex items-center justify-center gap-2">
                            <i class="fi fi-rr-edit"></i> Edit
                        </a>

                        <form action="{{route('admin.users.students.destroy', ['student' => $student->id])}}"
                              method="post"
                              class="flex-1 min-w-[100px]"
                              onsubmit="return confirm('Are you sure you want to delete this student?')">
                            @csrf
                            @method('delete')
                            <button class="btn btn-ghost btn-sm text-error w-full text-xs flex items-center justify-center gap-2">
                                <i class="fi fi-rr-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm p-4 text-center text-gray-500 border">
                    <i class="fi fi-rr-users text-2xl mb-2"></i>
                    <p class="text-sm">No students</p>
                </div>
            @endforelse
        </div>
    </div>
</x-dashboard.admin.base>
