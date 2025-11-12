<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Student Records')" />
    <x-notification-message />

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <!-- Filters Section -->
        <div class="mb-6">
            <form method="GET" class="flex flex-wrap gap-4">
                <!-- Academic Year Filter -->
                <div class="form-control">
                    <label class="label">
                        <span class="font-medium label-text">Academic Year</span>
                    </label>
                    <select name="academic_year"
                            onchange="this.form.submit()"
                            class="select select-bordered min-w-[200px]">
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
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium opacity-0 label-text">Clear</span>
                        </label>
                        <a href="{{ route('registrar.students.index') }}"
                           class="btn btn-ghost btn-sm">
                            <i class="mr-2 fi fi-rr-refresh"></i>
                            Clear Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Students Table -->
        <div class="overflow-x-auto">
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
                            <td>{{ $student?->name ?? 'N/A' }}</td>
                            <td>{{ $student?->studentProfile?->lrn ?? 'N/A' }}</td>
                            <td>Grade {{ $student?->currentAcademicRecord?->grade_level ?? 'N/A' }}</td>
                            <td>{{ $student?->currentAcademicRecord?->academicYear->name ?? 'N/A' }}</td>
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
                            <td colspan="5" class="py-4 text-center">
                                <div class="flex flex-col justify-center items-center text-gray-500">
                                    <i class="mb-2 text-3xl fi fi-rr-users"></i>
                                    <p>No students found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $students->links() }}
        </div>
    </div>
</x-dashboard.registrar.base>
