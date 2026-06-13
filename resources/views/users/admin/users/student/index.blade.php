<x-dashboard.admin.base>
    <x-dashboard.page-title :back_url="route('admin.users.index')" :title="'Students'" />

    <div class="panel flex flex-col gap-4">

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.users.students.index') }}"
              class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-end">

            <div class="form-control flex-1">
                <label class="label py-1">
                    <span class="label-text text-xs font-medium text-gray-600">Search</span>
                </label>
                <div class="relative">
                    <i class="fi fi-rr-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Name, email or LRN…"
                           class="input input-bordered input-sm w-full pl-9">
                </div>
            </div>

            <div class="form-control sm:w-48">
                <label class="label py-1">
                    <span class="label-text text-xs font-medium text-gray-600">Grade Level</span>
                </label>
                <select name="grade_level" class="select select-bordered select-sm w-full text-xs">
                    <option value="">All Grades</option>
                    @foreach($gradeLevels as $level)
                        <option value="{{ $level }}" {{ request('grade_level') === $level ? 'selected' : '' }}>
                            {{ $level }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn text-white btn-accent btn-sm gap-2 flex-1 sm:flex-none">
                    <i class="fi fi-rr-filter"></i>
                    Filter
                </button>
                @if(request()->hasAny(['search', 'grade_level']))
                    <a href="{{ route('admin.users.students.index') }}"
                       class="btn btn-ghost btn-sm gap-1">
                        <i class="fi fi-rr-cross-small"></i>
                        Clear
                    </a>
                @endif
            </div>
        </form>

        {{-- Result count --}}
        <p class="text-xs text-gray-500">
            Showing <span class="font-semibold text-gray-700">{{ $students->firstItem() ?? 0 }}</span>
            &ndash; <span class="font-semibold text-gray-700">{{ $students->lastItem() ?? 0 }}</span>
            of <span class="font-semibold text-gray-700">{{ $students->total() }}</span> students
        </p>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto rounded-lg border border-base-200">
            <table class="table table-zebra w-full text-sm">
                <thead>
                    <tr class="bg-base-200 text-gray-600 uppercase text-xs tracking-wide">
                        <th class="w-8">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Grade Level</th>
                        <th class="text-center">Classrooms</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php
                            $latestRecord = $student->studentProfile?->academicRecords->first();
                            $gradeLevel = $latestRecord?->grade_level ?? null;
                        @endphp
                        <tr class="hover">
                            <td class="text-gray-400 text-xs">{{ $students->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="bg-accent/10 text-accent rounded-full w-8 h-8 text-xs font-bold flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 leading-tight">{{ $student->name }}</p>
                                        @if($student->studentProfile?->lrn)
                                            <p class="text-xs text-gray-400">LRN: {{ $student->studentProfile->lrn }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-gray-600">{{ $student->email }}</td>
                            <td>
                                @if($gradeLevel)
                                    <span class="badge badge-accent badge-sm text-white">{{ $gradeLevel }}</span>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge badge-ghost badge-sm">
                                    {{ $student->asStudentClassrooms()->count() }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center gap-1 justify-end">
                                    <a href="{{ route('admin.users.students.show', $student->id) }}"
                                       class="btn btn-ghost btn-xs" title="View">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.students.edit', $student->id) }}"
                                       class="btn btn-ghost btn-xs" title="Edit">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.students.destroy', $student->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this student?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-ghost btn-xs text-error" title="Delete">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-400">
                                <i class="fi fi-rr-users block text-3xl mb-2"></i>
                                <p>No students found</p>
                                @if(request()->hasAny(['search', 'grade_level']))
                                    <a href="{{ route('admin.users.students.index') }}"
                                       class="btn btn-ghost btn-xs mt-2">Clear filters</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="block sm:hidden space-y-3">
            @forelse($students as $student)
                @php
                    $latestRecord = $student->studentProfile?->academicRecords->first();
                    $gradeLevel = $latestRecord?->grade_level ?? null;
                @endphp
                <div class="bg-base-100 rounded-lg border border-base-200 shadow-sm p-4">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="bg-accent/10 text-accent rounded-full w-10 h-10 text-sm font-bold flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 text-sm truncate">{{ $student->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $student->email }}</p>
                                @if($student->studentProfile?->lrn)
                                    <p class="text-xs text-gray-400">LRN: {{ $student->studentProfile->lrn }}</p>
                                @endif
                            </div>
                        </div>
                        @if($gradeLevel)
                            <span class="badge badge-accent badge-sm shrink-0">{{ $gradeLevel }}</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                        <i class="fi fi-rr-chalkboard-user text-accent"></i>
                        <span>{{ $student->asStudentClassrooms()->count() }} classroom(s)</span>
                    </div>

                    <div class="flex gap-2 border-t border-base-200 pt-3">
                        <a href="{{ route('admin.users.students.show', $student->id) }}"
                           class="btn btn-ghost btn-sm flex-1 gap-1 text-xs">
                            <i class="fi fi-rr-eye"></i> View
                        </a>
                        <a href="{{ route('admin.users.students.edit', $student->id) }}"
                           class="btn btn-ghost btn-sm flex-1 gap-1 text-xs">
                            <i class="fi fi-rr-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.users.students.destroy', $student->id) }}"
                              method="POST"
                              class="flex-1"
                              onsubmit="return confirm('Delete this student?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-ghost btn-sm text-error w-full gap-1 text-xs">
                                <i class="fi fi-rr-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-base-100 rounded-lg shadow-sm p-8 text-center text-gray-400 border border-base-200">
                    <i class="fi fi-rr-users block text-3xl mb-2"></i>
                    <p class="text-sm">No students found</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($students->hasPages())
            <div class="mt-2">
                {{ $students->links() }}
            </div>
        @endif

    </div>
</x-dashboard.admin.base>
