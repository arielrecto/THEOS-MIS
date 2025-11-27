<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Student Records')" />
    <x-notification-message />

    <div class="p-4 sm:p-6 bg-white rounded-lg shadow-lg">
        <!-- Filters Section -->
        <div class="mb-4 sm:mb-6">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <!-- Academic Year Filter -->
                <div class="form-control w-full sm:w-auto">
                    <label class="label">
                        <span class="font-medium label-text text-sm sm:text-base">Academic Year</span>
                    </label>
                    <select name="academic_year"
                            onchange="this.form.submit()"
                            class="select select-bordered w-full sm:min-w-[200px] text-sm sm:text-sm">
                        <option value="">All Academic Years</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}"
                                    {{ request('academic_year') == $year->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Clear Filters -->
                @if(request('academic_year'))
                    <div class="form-control w-full sm:w-auto">
                        <label class="label">
                            <span class="font-medium opacity-0 label-text text-sm">Clear</span>
                        </label>
                        <a href="{{ route('registrar.students.index') }}"
                           class="btn btn-ghost btn-sm w-full sm:w-auto text-sm">
                            <i class="mr-2 fi fi-rr-refresh"></i>
                            Clear Filter
                        </a>
                    </div>
                @endif

                <div class="flex-1"></div>

                <div class="w-full sm:w-auto">
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Showing <strong class="text-gray-700">{{ $students->count() }}</strong> of <strong>{{ $students->total() }}</strong>
                    </p>
                </div>
            </form>
        </div>

        <!-- Mobile Cards (visible on small screens) -->
        <div class="space-y-4 md:hidden">
            @forelse($students as $student)
                <article class="flex items-start gap-3 bg-base-100 p-3 rounded-lg shadow-sm">
                    {{-- <div class="flex-shrink-0">
                        <img src="{{ $student->profile->image ?? asset('images/avatar-placeholder.png') }}"
                             alt="{{ $student->name ?? 'Student' }}"
                             class="w-12 h-12 rounded-full object-cover bg-gray-100">
                    </div> --}}

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm sm:text-base font-medium text-gray-900 truncate">{{ $student?->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 truncate">LRN: {{ $student?->studentProfile?->lrn ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-1 truncate">
                                    Grade {{ $student?->currentAcademicRecord?->grade_level ?? 'N/A' }}
                                    • {{ $student?->currentAcademicRecord?->academicYear->name ?? 'N/A' }}
                                </p>
                            </div>

                            <div class="text-right flex-shrink-0 ml-2">
                                <a href="{{ route('registrar.students.show', $student->id) }}"
                                   class="btn btn-ghost btn-xs text-accent whitespace-nowrap">
                                    <i class="mr-1 fi fi-rr-user"></i>
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="bg-gray-50 rounded-lg p-6 text-center">
                    <i class="fi fi-rr-users text-4xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600">No students found</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table (visible md and up) -->
        <div class="hidden md:block overflow-x-auto mt-2">
            <table class="table w-full table-zebra">
                <thead>
                    <tr>
                        <th class="text-white bg-accent">Student Name</th>
                        <th class="text-white bg-accent">LRN</th>
                        <th class="text-white bg-accent">Current Grade</th>
                        <th class="text-white bg-accent">Academic Year</th>
                        <th class="text-center text-white bg-accent">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr class="hover">
                            <td>
                                <div class="flex items-center gap-3 min-w-0">
                                    <img src="{{ $student->profile->image ?? asset('images/avatar-placeholder.png') }}"
                                         alt="{{ $student->name ?? 'Student' }}"
                                         class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                                    <div class="min-w-0">
                                        <p class="font-medium text-sm truncate">{{ $student?->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-sm">{{ $student?->studentProfile?->lrn ?? 'N/A' }}</td>
                            <td class="text-sm">Grade {{ $student?->currentAcademicRecord?->grade_level ?? 'N/A' }}</td>
                            <td class="text-sm">{{ $student?->currentAcademicRecord?->academicYear->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <a href="{{ route('registrar.students.show', $student->id) }}"
                                   class="btn btn-sm btn-ghost text-accent">
                                    <i class="mr-2 fi fi-rr-user"></i>
                                    View Record
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fi fi-rr-users text-4xl mb-2"></i>
                                    <p class="text-sm">No students found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <div class="flex justify-center">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</x-dashboard.registrar.base>
