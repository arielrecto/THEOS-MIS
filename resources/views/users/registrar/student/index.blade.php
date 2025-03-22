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
                        <span class="label-text font-medium">Academic Year</span>
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
                            <span class="label-text font-medium opacity-0">Clear</span>
                        </label>
                        <a href="{{ route('registrar.students.index') }}"
                           class="btn btn-ghost btn-sm">
                            <i class="fi fi-rr-refresh mr-2"></i>
                            Clear Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Students Table -->
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th class="bg-accent text-white">Student Name</th>
                        <th class="bg-accent text-white">LRN</th>
                        <th class="bg-accent text-white">Current Grade</th>
                        <th class="bg-accent text-white">Academic Year</th>
                        <th class="bg-accent text-white text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr class="hover">
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->studentProfile->lrn }}</td>
                            <td>Grade {{ $student->currentAcademicRecord?->grade_level ?? 'N/A' }}</td>
                            <td>{{ $student->currentAcademicRecord?->academicYear->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <a href="{{ route('registrar.students.show', $student->id) }}"
                                   class="btn btn-sm btn-ghost text-accent">
                                    <i class="fi fi-rr-user mr-2"></i>
                                    View Record
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fi fi-rr-users text-3xl mb-2"></i>
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
