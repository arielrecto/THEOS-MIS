<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Student Grades')" />
    <x-notification-message />

    <div class="p-4 sm:p-6 bg-white rounded-lg shadow-lg">
        <!-- Search Bar -->
        <div class="mb-6">
            <form method="GET" class="w-full">
                <!-- Preserve existing filter values -->
                <input type="hidden" name="academic_year" value="{{ request('academic_year') }}">
                <input type="hidden" name="grade_level" value="{{ request('grade_level') }}">
                <input type="hidden" name="strand" value="{{ request('strand') }}">
                
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium text-xs sm:text-sm">Search Student</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by student name or LRN..." 
                               class="input input-bordered input-sm sm:input-md w-full pr-20" />
                        
                        <div class="absolute right-1 top-1/2 -translate-y-1/2 flex gap-1">
                            @if(request('search'))
                                <a href="{{ route('registrar.grades.index', request()->except('search')) }}" 
                                   class="btn btn-ghost btn-xs sm:btn-sm btn-circle">
                                    <i class="fi fi-rr-cross-small"></i>
                                </a>
                            @endif
                            <button type="submit" class="btn btn-accent btn-xs sm:btn-sm">
                                <i class="fi fi-rr-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Filters Section -->
        <div class="mb-6">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Preserve search value -->
                <input type="hidden" name="search" value="{{ request('search') }}">
                
                <!-- Academic Year Filter -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium text-xs sm:text-sm">Academic Year</span>
                    </label>
                    <select name="academic_year" onchange="this.form.submit()"
                        class="select select-bordered select-sm sm:select-md w-full">
                        <option value="">{{ __('All Academic Years') }}</option>
                        @foreach ($academicYears as $year)
                            <option value="{{ $year->id }}"
                                {{ request('academic_year') == $year->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Grade Level Filter (Static Kinder - Grade 10) -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium text-xs sm:text-sm">Grade Level</span>
                    </label>
                    <select name="grade_level" onchange="this.form.submit()"
                        class="select select-bordered select-sm sm:select-md w-full">
                        <option value="">{{ __('All Grade Levels') }}</option>
                        <option value="Kinder" {{ request('grade_level') == 'Kinder' ? 'selected' : '' }}>Kinder</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="Grade {{ $i }}" {{ request('grade_level') == "Grade {$i}" ? 'selected' : '' }}>
                                Grade {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Strand Filter (For Senior High) -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium text-xs sm:text-sm">Strand (SHS)</span>
                    </label>
                    <select name="strand" onchange="this.form.submit()"
                        class="select select-bordered select-sm sm:select-md w-full">
                        <option value="">{{ __('All Strands') }}</option>
                        @foreach ($strands as $strand)
                            <option value="{{ $strand->id }}"
                                {{ request('strand') == $strand->id ? 'selected' : '' }}>
                                {{ $strand->acronym ?? $strand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="form-control w-full flex items-end">
                    @if (request()->hasAny(['academic_year', 'grade_level', 'strand', 'search']))
                        <a href="{{ route('registrar.grades.index') }}"
                           class="btn btn-ghost btn-sm sm:btn-md w-full">
                            <i class="fi fi-rr-refresh mr-2"></i>
                            Clear All
                        </a>
                    @else
                        <div class="opacity-0 btn btn-sm sm:btn-md w-full">Placeholder</div>
                    @endif
                </div>
            </form>
        </div>

        <!-- Active Filters Display -->
        @if (request()->hasAny(['academic_year', 'grade_level', 'strand', 'search']))
            <div class="mb-4 flex flex-wrap gap-2">
                <span class="text-xs sm:text-sm font-medium text-gray-600">Active Filters:</span>
                
                @if (request('search'))
                    <span class="badge badge-info badge-sm sm:badge-md gap-2">
                        Search: "{{ request('search') }}"
                        <a href="{{ route('registrar.grades.index', request()->except('search')) }}"
                           class="hover:text-error">✕</a>
                    </span>
                @endif
                
                @if (request('academic_year'))
                    <span class="badge badge-accent badge-sm sm:badge-md gap-2">
                        {{ $academicYears->find(request('academic_year'))->name ?? 'N/A' }}
                        <a href="{{ route('registrar.grades.index', request()->except('academic_year')) }}"
                           class="hover:text-error">✕</a>
                    </span>
                @endif

                @if (request('grade_level'))
                    <span class="badge badge-primary badge-sm sm:badge-md gap-2">
                        {{ request('grade_level') }}
                        <a href="{{ route('registrar.grades.index', request()->except('grade_level')) }}"
                           class="hover:text-error">✕</a>
                    </span>
                @endif

                @if (request('strand'))
                    <span class="badge badge-secondary badge-sm sm:badge-md gap-2">
                        {{ $strands->find(request('strand'))->acronym ?? $strands->find(request('strand'))->name ?? 'N/A' }}
                        <a href="{{ route('registrar.grades.index', request()->except('strand')) }}"
                           class="hover:text-error">✕</a>
                    </span>
                @endif
            </div>
        @endif

        <!-- View Toggle & Results Count -->
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="text-xs sm:text-sm text-gray-600">
                Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} 
                of {{ $students->total() }} student(s)
                @if(request('search'))
                    <span class="font-medium">for "{{ request('search') }}"</span>
                @endif
            </div>
            
            <!-- View Toggle Buttons -->
            <div class="join">
                <button onclick="toggleView('grid')" 
                        id="gridViewBtn"
                        class="join-item btn btn-sm sm:btn-md btn-active">
                    <i class="fi fi-rr-apps mr-1"></i>
                    Grid
                </button>
                <button onclick="toggleView('table')" 
                        id="tableViewBtn"
                        class="join-item btn btn-sm sm:btn-md">
                    <i class="fi fi-rr-list mr-1"></i>
                    Table
                </button>
            </div>
        </div>

        <!-- Grid View (Default) -->
        <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse($students as $student)
                <div class="card bg-base-100 shadow-xl flex flex-col hover:shadow-2xl transition-shadow">
                    <div class="card-body flex-1 p-4 sm:p-6">
                        <div class="flex items-center gap-3 sm:gap-4 mb-4">
                            <div class="avatar placeholder flex-shrink-0">
                                <div class="bg-accent text-white rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center text-lg sm:text-xl">
                                    {{ substr($student?->name ?? 'N/A', 0, 1) }}
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h2 class="card-title truncate text-sm sm:text-base">{{ $student?->name ?? 'N/A' }}</h2>
                                <p class="text-xs sm:text-sm text-gray-600 truncate">
                                    LRN: {{ $student?->studentProfile?->lrn ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Academic Records -->
                        <div class="space-y-2 sm:space-y-3">
                            @forelse($student?->studentProfile?->academicRecords()->with(['academicYear', 'grades', 'section.strand'])->get() as $record)
                                <div class="bg-base-200 p-3 sm:p-4 rounded-lg">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 gap-2">
                                        <div class="flex-1">
                                            @if($record->section && $record->section->strand)
                                                <h3 class="font-medium text-xs sm:text-sm">
                                                    {{ $record->section->strand->name }}
                                                    @if($record->section->strand->acronym)
                                                        ({{ $record->section->strand->acronym }})
                                                    @endif
                                                </h3>
                                            @else
                                                <h3 class="font-medium text-xs sm:text-sm">{{ $record->grade_level }}</h3>
                                            @endif
                                            <p class="text-xs text-gray-600">{{ $record?->academicYear?->name ?? 'N/A' }}</p>
                                            @if($record->section)
                                                <p class="text-xs text-gray-500">Section: {{ $record->section->name }}</p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <span class="font-bold text-accent text-base sm:text-lg">
                                                {{ number_format($record->average, 1) }}%
                                            </span>
                                            <div class="text-xs text-gray-500">Average</div>
                                        </div>
                                    </div>

                                    <!-- View Grades Button -->
                                    <div class="mt-3 flex gap-2">
                                        <button class="btn btn-xs sm:btn-sm btn-ghost flex-1"
                                            onclick="document.getElementById('grades_modal_{{ $record->id }}').showModal()">
                                            <i class="fi fi-rr-eye mr-1"></i>
                                            View Grades
                                        </button>
                                        <a href="{{ route('registrar.students.print', ['student' => $student->id, 'record' => $record->id]) }}"
                                           target="_blank"
                                           class="btn btn-xs sm:btn-sm btn-ghost">
                                            <i class="fi fi-rr-print"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Grades Modal -->
                                <dialog id="grades_modal_{{ $record->id }}" class="modal">
                                    <div class="modal-box w-11/12 max-w-3xl p-4 sm:p-6">
                                        <form method="dialog">
                                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                        </form>
                                        
                                        <div class="mb-4">
                                            @if($record->section && $record->section->strand)
                                                <h3 class="font-bold text-base sm:text-lg">
                                                    {{ $record->section->strand->name }}
                                                    @if($record->section->strand->acronym)
                                                        ({{ $record->section->strand->acronym }})
                                                    @endif
                                                </h3>
                                            @else
                                                <h3 class="font-bold text-base sm:text-lg">{{ $record->grade_level }}</h3>
                                            @endif
                                            <p class="text-xs sm:text-sm text-gray-600">{{ $record->academicYear->name }}</p>
                                            @if($record->section)
                                                <p class="text-xs sm:text-sm text-gray-500">Section: {{ $record->section->name }}</p>
                                            @endif
                                        </div>

                                        <div class="overflow-x-auto">
                                            <table class="table table-zebra w-full text-xs sm:text-sm">
                                                <thead>
                                                    <tr>
                                                        <th class="text-xs sm:text-sm">Subject</th>
                                                        <th class="text-right text-xs sm:text-sm">Grade</th>
                                                        <th class="text-right text-xs sm:text-sm">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($record->grades as $grade)
                                                        <tr>
                                                            <td class="text-xs sm:text-sm">{{ $grade->subject }}</td>
                                                            <td class="text-right font-medium text-xs sm:text-sm">
                                                                {{ number_format($grade->grade, 1) }}
                                                            </td>
                                                            <td class="text-right">
                                                                <span class="badge badge-xs sm:badge-sm {{ $grade->grade >= 75 ? 'badge-success' : 'badge-error' }}">
                                                                    {{ $grade->remarks }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-base-200">
                                                        <td class="font-medium text-xs sm:text-sm">General Average</td>
                                                        <td class="text-right font-bold text-accent text-sm sm:text-base" colspan="2">
                                                            {{ number_format($record->average, 1) }}%
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="mt-4 flex justify-end gap-2">
                                            <a href="{{ route('registrar.students.print', ['student' => $student->id, 'record' => $record->id]) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-accent">
                                                <i class="fi fi-rr-print mr-2"></i>
                                                Print Report
                                            </a>
                                        </div>
                                    </div>
                                    <form method="dialog" class="modal-backdrop">
                                        <button>close</button>
                                    </form>
                                </dialog>
                            @empty
                                <div class="text-center text-gray-500 py-4 text-xs sm:text-sm">
                                    <i class="fi fi-rr-document text-2xl mb-2"></i>
                                    <p>No academic records found</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- View Full Profile -->
                        <div class="mt-4 pt-4 border-t">
                            <a href="{{ route('registrar.students.show', $student->id) }}" 
                               class="btn btn-xs sm:btn-sm btn-outline btn-accent w-full">
                                <i class="fi fi-rr-user mr-2"></i>
                                View Full Profile
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center p-8 sm:p-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mb-4 text-gray-400">
                        <i class="fi fi-rr-users text-3xl sm:text-4xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-900">No Students Found</h3>
                    <p class="text-xs sm:text-sm text-gray-500 text-center mt-1">
                        @if(request('search'))
                            No results found for "{{ request('search') }}"
                        @else
                            Try adjusting your filters or clear all filters to see all students
                        @endif
                    </p>
                    @if (request()->hasAny(['academic_year', 'grade_level', 'strand', 'search']))
                        <a href="{{ route('registrar.grades.index') }}" 
                           class="btn btn-sm btn-accent mt-4">
                            <i class="fi fi-rr-refresh mr-2"></i>
                            Clear All Filters
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Table View (Hidden by default) -->
        <div id="tableView" class="hidden overflow-x-auto">
            <table class="table table-zebra w-full text-xs sm:text-sm">
                <thead>
                    <tr>
                        <th class="text-xs sm:text-sm">Student Name</th>
                        <th class="text-xs sm:text-sm">LRN</th>
                        <th class="text-xs sm:text-sm">Grade Level</th>
                        <th class="text-xs sm:text-sm">Section</th>
                        <th class="text-xs sm:text-sm">Academic Year</th>
                        <th class="text-right text-xs sm:text-sm">Average</th>
                        <th class="text-center text-xs sm:text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php
                            $records = $student?->studentProfile?->academicRecords()->with(['academicYear', 'grades', 'section.strand'])->get();
                        @endphp
                        @forelse($records as $record)
                            <tr class="hover">
                                <td class="font-medium text-xs sm:text-sm">{{ $student->name }}</td>
                                <td class="text-xs sm:text-sm">{{ $student?->studentProfile?->lrn ?? 'N/A' }}</td>
                                <td class="text-xs sm:text-sm">
                                    @if($record->section && $record->section->strand)
                                        {{ $record->section->strand->name }}
                                        @if($record->section->strand->acronym)
                                            ({{ $record->section->strand->acronym }})
                                        @endif
                                    @else
                                        {{ $record->grade_level }}
                                    @endif
                                </td>
                                <td class="text-xs sm:text-sm">{{ $record->section->name ?? 'N/A' }}</td>
                                <td class="text-xs sm:text-sm">{{ $record->academicYear->name ?? 'N/A' }}</td>
                                <td class="text-right">
                                    <span class="font-bold text-accent text-sm sm:text-base">
                                        {{ number_format($record->average, 1) }}%
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="flex gap-1 justify-center">
                                        <button class="btn btn-xs sm:btn-sm btn-ghost"
                                            onclick="document.getElementById('grades_modal_{{ $record->id }}').showModal()">
                                            <i class="fi fi-rr-eye"></i>
                                        </button>
                                        <a href="{{ route('registrar.students.print', ['student' => $student->id, 'record' => $record->id]) }}"
                                           target="_blank"
                                           class="btn btn-xs sm:btn-sm btn-ghost">
                                            <i class="fi fi-rr-print"></i>
                                        </a>
                                        <a href="{{ route('registrar.students.show', $student->id) }}"
                                           class="btn btn-xs sm:btn-sm btn-ghost">
                                            <i class="fi fi-rr-user"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-4 text-xs sm:text-sm">
                                    No academic records
                                </td>
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <i class="fi fi-rr-users text-3xl sm:text-4xl text-gray-400 mb-3"></i>
                                    <h3 class="text-base sm:text-lg font-medium text-gray-900">No Students Found</h3>
                                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                        @if(request('search'))
                                            No results found for "{{ request('search') }}"
                                        @else
                                            Try adjusting your filters
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($students->hasPages())
            <div class="mt-6">
                {{ $students->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function toggleView(view) {
            const gridView = document.getElementById('gridView');
            const tableView = document.getElementById('tableView');
            const gridBtn = document.getElementById('gridViewBtn');
            const tableBtn = document.getElementById('tableViewBtn');

            if (view === 'grid') {
                gridView.classList.remove('hidden');
                tableView.classList.add('hidden');
                gridBtn.classList.add('btn-active');
                tableBtn.classList.remove('btn-active');
                localStorage.setItem('gradesView', 'grid');
            } else {
                gridView.classList.add('hidden');
                tableView.classList.remove('hidden');
                tableBtn.classList.add('btn-active');
                gridBtn.classList.remove('btn-active');
                localStorage.setItem('gradesView', 'table');
            }
        }

        // Restore last selected view
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('gradesView');
            if (savedView === 'table') {
                toggleView('table');
            }
        });
    </script>
    @endpush
</x-dashboard.registrar.base>
