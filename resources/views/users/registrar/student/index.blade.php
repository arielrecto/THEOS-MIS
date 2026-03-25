<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Student Records')" />
    <x-notification-message />

    <div class="p-4 sm:p-6 bg-white rounded-lg shadow-lg">
        <!-- Filters Section -->
        <div class="mb-4 sm:mb-6">
            <form method="GET" id="filterForm" class="space-y-4">
                <!-- Search Bar -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="font-medium label-text text-sm sm:text-base">Search Student</span>
                    </label>
                    <div class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search by name, LRN, or email..."
                               class="input input-bordered w-full pr-10 text-sm"
                               autocomplete="off">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-ghost btn-sm btn-circle">
                            <i class="fi fi-rr-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Advanced Filters -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <!-- Academic Year Filter -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text text-sm">Academic Year</span>
                        </label>
                        <select name="academic_year"
                                onchange="this.form.submit()"
                                class="select select-bordered w-full text-sm">
                            <option value="">All Academic Years</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}"
                                        {{ request('academic_year') == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Grade Level Filter -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text text-sm">Grade Level</span>
                        </label>
                        <select name="grade_level"
                                onchange="this.form.submit()"
                                class="select select-bordered w-full text-sm">
                            <option value="">All Grade Levels</option>
                            @foreach($gradeLevels as $level)
                                <option value="{{ $level }}"
                                        {{ request('grade_level') == $level ? 'selected' : '' }}>
                                    Grade {{ $level }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Strand Filter -->
                        {{-- <div class="form-control">
                            <label class="label">
                                <span class="font-medium label-text text-sm">Strand</span>
                            </label>
                            <select name="strand"
                                    onchange="this.form.submit()"
                                    class="select select-bordered w-full text-sm">
                                <option value="">All Strands</option>
                                @foreach($strands as $strand)
                                    <option value="{{ $strand->id }}"
                                            {{ request('strand') == $strand->id ? 'selected' : '' }}>
                                        {{ $strand->acronym }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}

                    <!-- Sort By -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text text-sm">Sort By</span>
                        </label>
                        <select name="sort"
                                onchange="this.form.submit()"
                                class="select select-bordered w-full text-sm">
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                            <option value="lrn_asc" {{ request('sort') == 'lrn_asc' ? 'selected' : '' }}>LRN (Low-High)</option>
                            <option value="lrn_desc" {{ request('sort') == 'lrn_desc' ? 'selected' : '' }}>LRN (High-Low)</option>
                            <option value="grade_asc" {{ request('sort') == 'grade_asc' ? 'selected' : '' }}>Grade (Low-High)</option>
                            <option value="grade_desc" {{ request('sort') == 'grade_desc' ? 'selected' : '' }}>Grade (High-Low)</option>
                            <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Recently Added</option>
                        </select>
                    </div>
                </div>

                <!-- Active Filters & Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-3 border-t">
                    <!-- Results Summary -->
                    <div class="text-xs sm:text-sm text-gray-500">
                        Showing <strong class="text-gray-700">{{ $students->firstItem() ?? 0 }}</strong>
                        to <strong class="text-gray-700">{{ $students->lastItem() ?? 0 }}</strong>
                        of <strong class="text-gray-700">{{ $students->total() }}</strong> students
                    </div>

                    <!-- Active Filter Badges & Clear Button -->
                    <div class="flex flex-wrap items-center gap-2">
                        @if(request()->hasAny(['search', 'academic_year', 'grade_level', 'strand']))
                            <div class="flex flex-wrap gap-1">
                                @if(request('search'))
                                    <span class="badge badge-sm badge-ghost gap-1">
                                        <i class="fi fi-rr-search text-xs"></i>
                                        "{{ Str::limit(request('search'), 15) }}"
                                        <a href="{{ route('registrar.students.index', array_filter(request()->except('search'))) }}"
                                           class="text-error hover:text-error-focus">×</a>
                                    </span>
                                @endif
                                @if(request('academic_year'))
                                    <span class="badge badge-sm badge-ghost gap-1">
                                        <i class="fi fi-rr-calendar text-xs"></i>
                                        {{ $academicYears->find(request('academic_year'))?->name ?? 'N/A' }}
                                        <a href="{{ route('registrar.students.index', array_filter(request()->except('academic_year'))) }}"
                                           class="text-error hover:text-error-focus">×</a>
                                    </span>
                                @endif
                                @if(request('grade_level'))
                                    <span class="badge badge-sm badge-ghost gap-1">
                                        <i class="fi fi-rr-diploma text-xs"></i>
                                        Grade {{ request('grade_level') }}
                                        <a href="{{ route('registrar.students.index', array_filter(request()->except('grade_level'))) }}"
                                           class="text-error hover:text-error-focus">×</a>
                                    </span>
                                @endif
                                @if(request('strand'))
                                    <span class="badge badge-sm badge-ghost gap-1">
                                        <i class="fi fi-rr-book text-xs"></i>
                                        {{ $strands->find(request('strand'))?->acronym ?? 'N/A' }}
                                        <a href="{{ route('registrar.students.index', array_filter(request()->except('strand'))) }}"
                                           class="text-error hover:text-error-focus">×</a>
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('registrar.students.index') }}"
                               class="btn btn-ghost btn-xs gap-2">
                                <i class="fi fi-rr-refresh"></i>
                                Clear All
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Mobile Cards (visible on small screens) -->
        <div class="space-y-3 md:hidden">
            @forelse($students as $student)
                @php
                    $latestRecord = $student->studentProfile?->academicRecords
                        ->when(request('academic_year'), function($records) {
                            return $records->where('academic_year_id', request('academic_year'));
                        })
                        ->sortByDesc('grade_level')
                        ->first();
                @endphp
                <article class="flex items-start gap-3 bg-base-100 p-4 rounded-lg shadow-sm border hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0">
                        @if($student->profilePicture)
                            <img src="{{ asset($student->profilePicture->file_dir) }}"
                                 alt="{{ $student->name }}"
                                 class="w-12 h-12 rounded-full object-cover bg-gray-100">
                        @else
                            <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center">
                                <i class="fi fi-rr-user text-xl text-accent"></i>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-900 truncate">
                                    {{ $student->name ?? 'N/A' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    <i class="fi fi-rr-id-badge mr-1"></i>
                                    LRN: {{ $student->studentProfile?->lrn ?? 'N/A' }}
                                </p>
                                @if($latestRecord)
                                    <div class="flex items-center gap-2 mt-1 text-xs text-gray-600">
                                        <span class="badge badge-sm badge-outline">
                                            Grade {{ $latestRecord->grade_level }}
                                        </span>
                                        @if($latestRecord->strand_id)
                                            <span class="badge badge-sm badge-accent badge-outline">
                                                {{ $strands->find($latestRecord->strand_id)?->acronym }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fi fi-rr-calendar mr-1"></i>
                                        {{ $latestRecord->academicYear?->name ?? 'N/A' }}
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('registrar.students.show', $student->id) }}"
                               class="btn btn-ghost btn-xs text-accent flex-shrink-0">
                                <i class="fi fi-rr-eye"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <i class="fi fi-rr-search text-4xl text-gray-400 mb-3"></i>
                    <p class="text-sm text-gray-600 font-medium mb-1">No students found</p>
                    <p class="text-xs text-gray-500">Try adjusting your filters or search terms</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table (visible md and up) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="table w-full table-zebra">
                <thead>
                    <tr>
                        <th class="text-white bg-accent">Student</th>
                        <th class="text-white bg-accent">LRN</th>
                        <th class="text-white bg-accent">Grade Level</th>
                        <th class="text-white bg-accent">Strand</th>
                        <th class="text-white bg-accent">Academic Year</th>
                        <th class="text-center text-white bg-accent">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php
                            $latestRecord = $student->studentProfile?->academicRecords
                                ->when(request('academic_year'), function($records) {
                                    return $records->where('academic_year_id', request('academic_year'));
                                })
                                ->sortByDesc('grade_level')
                                ->first();
                        @endphp
                        <tr class="hover">
                            <td>
                                <div class="flex items-center gap-3">
                                    @if($student->profilePicture)
                                        <img src="{{ asset($student->profilePicture->file_dir) }}"
                                             alt="{{ $student->name }}"
                                             class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-accent/10 flex items-center justify-center">
                                            <i class="fi fi-rr-user text-accent"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-sm">{{ $student->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-sm">{{ $student->studentProfile?->lrn ?? 'N/A' }}</td>
                            <td class="text-sm">
                                @if($latestRecord)
                                    <span class="badge badge-ghost badge-sm">Grade {{ $latestRecord->grade_level }}</span>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="text-sm">
                                @if($latestRecord && $latestRecord->strand_id)
                                    <span class="badge badge-accent badge-sm">
                                        {{ $strands->find($latestRecord->strand_id)?->acronym ?? 'N/A' }}
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="text-sm">{{ $latestRecord?->academicYear?->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <a href="{{ route('registrar.students.show', $student->id) }}"
                                   class="btn btn-sm btn-ghost text-accent">
                                    <i class="mr-1 fi fi-rr-eye"></i>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fi fi-rr-search text-5xl mb-3"></i>
                                    <p class="text-base font-medium mb-1">No students found</p>
                                    <p class="text-sm">Try adjusting your search or filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($students->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $students->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</x-dashboard.registrar.base>
