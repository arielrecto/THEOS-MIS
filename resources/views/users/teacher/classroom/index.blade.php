<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="_('Classrooms')" :create_url="route('teacher.classrooms.create')" />
    <x-notification-message />

    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <!-- Filters Section -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center space-x-3 w-full sm:w-auto">
                    <label class="text-sm sm:text-base font-medium text-gray-700 sr-only" for="filter-academic-year">Academic Year</label>
                    <select id="filter-academic-year"
                            onchange="window.location.href=this.value"
                            class="select select-bordered w-full sm:w-64 text-sm sm:text-sm">
                        <option value="{{ route('teacher.classrooms.index') }}"
                            {{ !request()->academic_year ? 'selected' : '' }}>
                            All Academic Years
                        </option>
                        @foreach ($academicYears as $year)
                            <option value="{{ route('teacher.classrooms.index', ['academic_year' => $year->id]) }}"
                                {{ request()->academic_year == $year->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-sm sm:text-base text-gray-500 text-right">
                    {{ $classrooms->total() }} Classrooms
                </div>
            </div>
        </div>

        <!-- Class Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($classrooms as $classroom)
                <div
                    class="group relative rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 bg-white">
                    <!-- Class Header Banner -->
                    <div class="relative h-36 sm:h-32 md:h-36 bg-gradient-to-r from-accent to-accent/80">
                        <div class="absolute inset-0 p-4 sm:p-5 text-white flex flex-col justify-end">
                            <h2 class="text-lg sm:text-xl md:text-2xl font-bold truncate leading-tight">{{ $classroom->subject->name }}</h2>
                            <p class="text-xs sm:text-sm opacity-90 truncate">{{ $classroom->name }} - {{ $classroom->strand->acronym }}</p>
                            <p class="text-xs sm:text-sm mt-1">{{ $classroom->academicYear->name }}</p>
                        </div>

                        <!-- Teacher Avatar -->
                        <div class="absolute -bottom-6 right-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full ring-4 ring-white overflow-hidden bg-white">
                                <img src="{{ $classroom->teacher->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($classroom->teacher->name) }}"
                                    alt="{{ $classroom->teacher->name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- Class Content -->
                    <div class="p-4 pt-10 sm:pt-8 bg-white">
                        <div class="flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm sm:text-base text-gray-600 truncate">{{ $classroom->teacher->name }}</p>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="text-xs sm:text-sm text-gray-500">
                                    {{ $classroom->classroomStudents->count() }} {{ Str::plural('student', $classroom->classroomStudents->count()) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Overlay Link (keeps clickable area but action buttons remain accessible via z-index) -->
                    <a href="{{ route('teacher.classrooms.show', ['classroom' => $classroom->id]) }}"
                        class="absolute inset-0 z-10" aria-label="View classroom {{ $classroom->subject->name }}">
                        <span class="sr-only">View classroom</span>
                    </a>

                    <!-- Quick Action Buttons -->
                    <div
                        class="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity z-20">
                        <form action="{{ route('teacher.classrooms.archive', ['classroom' => $classroom->id]) }}"
                            method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to archive this classroom?')"
                                class="p-2 bg-white rounded-full shadow-lg hover:bg-gray-100 transition-colors" aria-label="Archive">
                                <i class="fi fi-rr-archive text-gray-600" aria-hidden="true"></i>
                            </button>
                        </form>

                        <a href="{{ route('teacher.classrooms.edit', ['classroom' => $classroom->id]) }}"
                            class="p-2 bg-white rounded-full shadow-lg hover:bg-gray-100 transition-colors" aria-label="Edit">
                            <i class="fi fi-rr-edit text-gray-600" aria-hidden="true"></i>
                        </a>

                        <form action="{{ route('teacher.classrooms.destroy', ['classroom' => $classroom->id]) }}"
                            method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this classroom?')"
                                class="p-2 bg-white rounded-full shadow-lg hover:bg-gray-100 transition-colors" aria-label="Delete">
                                <i class="fi fi-rr-trash text-gray-600" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full flex flex-col items-center justify-center p-8 sm:p-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <img src="{{ asset('images/empty-classroom.svg') }}" alt="No classrooms"
                        class="w-28 h-28 sm:w-32 sm:h-32 mb-4 opacity-50">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900">No Classrooms Yet</h3>
                    <p class="text-sm sm:text-base text-gray-500 mb-4 text-center">Get started by creating your first classroom.</p>
                    <a href="{{ route('teacher.classrooms.create') }}" class="btn btn-accent w-full sm:w-auto">
                        <i class="fi fi-rr-plus mr-2"></i>
                        Create Classroom
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $classrooms->appends(['academic_year' => request()->academic_year])->links() }}
        </div>
    </div>
</x-dashboard.teacher.base>
