<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="_('Classrooms')" :create_url="route('teacher.classrooms.create')"/>
    <x-notification-message />

    <div class="p-6">
        <!-- Filters Section -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <label class="text-sm font-medium text-gray-700">Academic Year:</label>
                    <select onchange="window.location.href=this.value"
                            class="select select-bordered w-64">
                        <option value="{{ route('teacher.classrooms.index') }}"
                                {{ !request()->academic_year ? 'selected' : '' }}>
                            All Academic Years
                        </option>
                        @foreach($academicYears as $year)
                            <option value="{{ route('teacher.classrooms.index', ['academic_year' => $year->id]) }}"
                                    {{ request()->academic_year == $year->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="text-sm text-gray-500">
                    {{ $classrooms->total() }} Classrooms
                </div>
            </div>
        </div>

        <!-- Class Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($classrooms as $classroom)
                <div class="group relative rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <!-- Class Header Banner -->
                    <div class="relative h-32 bg-gradient-to-r from-accent to-accent/80">
                        <div class="absolute inset-0 p-4 text-white">
                            <h2 class="text-xl font-bold truncate">{{ $classroom->subject->name }}</h2>
                            <p class="text-sm opacity-90">{{ $classroom->name }} - {{ $classroom->strand->acronym }}</p>
                            <p class="text-sm mt-2">{{ $classroom->academicYear->name }}</p>
                        </div>

                        <!-- Teacher Avatar -->
                        <div class="absolute -bottom-6 right-4">
                            <div class="w-12 h-12 rounded-full ring-4 ring-white overflow-hidden bg-white">
                                <img src="{{ $classroom->teacher->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($classroom->teacher->name) }}"
                                     alt="{{ $classroom->teacher->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- Class Content -->
                    <div class="p-4 pt-8 bg-white">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">{{ $classroom->teacher->name }}</p>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500">
                                    {{ $classroom->classroomStudents->count() }} students
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Overlay Link -->
                    <a href="{{ route('teacher.classrooms.show', ['classroom' => $classroom->id]) }}"
                       class="absolute inset-0 z-10">
                        <span class="sr-only">View classroom</span>
                    </a>

                    <!-- Quick Action Buttons -->
                    <div class="absolute top-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity z-20">
                        <a href="{{ route('teacher.classrooms.edit', ['classroom' => $classroom->id]) }}"
                           class="p-2 bg-white rounded-full shadow-lg hover:bg-gray-100 transition-colors">
                            <i class="fi fi-rr-edit text-gray-600"></i>
                            <span class="sr-only">Edit classroom</span>
                        </a>
                        <form action="{{ route('teacher.classrooms.destroy', ['classroom' => $classroom->id]) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this classroom?')"
                                    class="p-2 bg-white rounded-full shadow-lg hover:bg-gray-100 transition-colors">
                                <i class="fi fi-rr-trash text-gray-600"></i>
                                <span class="sr-only">Delete classroom</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center p-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <img src="{{ asset('images/empty-classroom.svg') }}"
                         alt="No classrooms"
                         class="w-32 h-32 mb-4 opacity-50">
                    <h3 class="text-lg font-medium text-gray-900">No Classrooms Yet</h3>
                    <p class="text-sm text-gray-500 mb-4">Get started by creating your first classroom</p>
                    <a href="{{ route('teacher.classrooms.create') }}"
                       class="btn btn-accent">
                        <i class="fi fi-rr-plus mr-2"></i>
                        Create Classroom
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $classrooms->appends(['academic_year' => request()->academic_year])->links() }}
        </div>
    </div>
</x-dashboard.teacher.base>
