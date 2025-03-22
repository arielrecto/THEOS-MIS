<x-dashboard.student.base>
    <x-notification-message />

    <div class="container mx-auto px-4">
        <x-tab.tab :tabs="['Classrooms', 'My Classrooms']" :active="0" />

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow p-4 mt-6 mb-4">
            <form method="GET" class="flex flex-wrap gap-4">
                <input type="hidden" name="activeTab" value="{{ request()->get('activeTab', 0) }}">

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

                <!-- Grade Level Filter -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Grade Level</span>
                    </label>
                    <select name="grade_level"
                            onchange="this.form.submit()"
                            class="select select-bordered min-w-[200px]">
                        <option value="">All Grade Levels</option>
                        <optgroup label="Elementary">
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ request('grade_level') == $i ? 'selected' : '' }}>
                                    Grade {{ $i }}
                                </option>
                            @endfor
                        </optgroup>
                        <optgroup label="Junior High School">
                            @for ($i = 7; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ request('grade_level') == $i ? 'selected' : '' }}>
                                    Grade {{ $i }}
                                </option>
                            @endfor
                        </optgroup>
                        <optgroup label="Senior High School">
                            @for ($i = 11; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('grade_level') == $i ? 'selected' : '' }}>
                                    Grade {{ $i }}
                                </option>
                            @endfor
                        </optgroup>
                    </select>
                </div>

                <!-- Clear Filters -->
                @if(request('academic_year') || request('grade_level'))
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium opacity-0">Clear</span>
                        </label>
                        <a href="{{ route('student.classrooms.index', ['activeTab' => request()->get('activeTab', 0)]) }}"
                           class="btn btn-ghost btn-sm">
                            <i class="fi fi-rr-refresh mr-2"></i>
                            Clear Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>

        @if (request()->get('activeTab') == 1)
            <!-- My Classrooms Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-6">
                @forelse ($myClassrooms as $myClassroom)
                    <div class="group relative rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Header Banner -->
                        <div class="relative h-32 bg-gradient-to-r from-accent to-accent/80">
                            <div class="absolute inset-0 p-6">
                                <h2 class="text-xl font-bold text-white truncate">{{ $myClassroom->subject->name }}</h2>
                                <p class="text-sm text-white/90">{{ $myClassroom->name }} - {{ $myClassroom->strand->acronym }}</p>
                                <p class="text-sm text-white/80 mt-1">{{ $myClassroom->academicYear->name }}</p>
                            </div>
                            <!-- Teacher Avatar -->
                            <div class="absolute -bottom-6 right-4">
                                <div class="w-12 h-12 rounded-full ring-4 ring-white overflow-hidden bg-white">
                                    <img src="{{ $myClassroom->teacher->profile->image }}"
                                         alt="{{ $myClassroom->teacher->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="bg-white p-6 pt-8">
                            <p class="text-sm text-gray-600">{{ $myClassroom->teacher->name }}</p>
                        </div>

                        <!-- Overlay Link -->
                        <a href="{{ route('student.classrooms.show', ['classroom' => $myClassroom->id]) }}"
                           class="absolute inset-0">
                            <span class="sr-only">View classroom</span>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center p-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <div class="w-16 h-16 mb-4 text-gray-400">
                            <i class="fi fi-rr-book-alt text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No Enrolled Classrooms</h3>
                        <p class="text-sm text-gray-500 text-center mt-1">Join a classroom to get started</p>
                    </div>
                @endforelse
            </div>
        @endif

        @if (request()->get('activeTab') == 0)
            <!-- Available Classrooms Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-6">
                @forelse ($classrooms as $classroom)
                    <div class="group relative rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Header Banner -->
                        <div class="relative h-32 bg-gradient-to-r from-accent to-accent/80">
                            <div class="absolute inset-0 p-6">
                                <h2 class="text-xl font-bold text-white truncate">{{ $classroom->subject->name }}</h2>
                                <p class="text-sm text-white/90">{{ $classroom->name }} - {{ $classroom->strand->acronym }}</p>
                                <p class="text-sm text-white/80 mt-1">{{ $classroom->academicYear->name }}</p>
                            </div>
                            <!-- Teacher Avatar -->
                            <div class="absolute -bottom-6 right-4">
                                <div class="w-12 h-12 rounded-full ring-4 ring-white overflow-hidden bg-white">
                                    <img src="{{ $classroom->teacher->profile->image }}"
                                         alt="{{ $classroom->teacher->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="bg-white p-6 pt-8">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-600">{{ $classroom->teacher->name }}</p>
                                @if (!$classroom->classroomStudents()->where('student_id', Auth::user()->id)->exists())
                                    <button class="btn btn-sm btn-accent" onclick="enroll_{{ $classroom->id }}.showModal()">
                                        <i class="fi fi-rr-plus mr-2"></i>Join
                                    </button>
                                @else
                                    <span class="badge badge-accent">Enrolled</span>
                                @endif
                            </div>
                        </div>

                        <!-- Join Modal -->
                        <dialog id="enroll_{{ $classroom->id }}" class="modal">
                            <div class="modal-box">
                                <form method="dialog">
                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                </form>
                                <h3 class="font-bold text-lg mb-4">Join Classroom</h3>
                                <form action="{{ route('student.classrooms.join', ['classroom' => $classroom->id]) }}"
                                      method="post"
                                      class="space-y-4">
                                    @csrf
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Enter Class Code</span>
                                        </label>
                                        <input type="text"
                                               name="class_code"
                                               class="input input-bordered w-full"
                                               placeholder="Enter the code provided by your teacher"
                                               required>
                                    </div>
                                    <div class="modal-action">
                                        <button type="submit" class="btn btn-accent">Join Class</button>
                                    </div>
                                </form>
                            </div>
                            <form method="dialog" class="modal-backdrop">
                                <button>close</button>
                            </form>
                        </dialog>

                        <!-- Overlay Link -->
                        @if ($classroom->classroomStudents()->where('student_id', Auth::user()->id)->exists())
                            <a href="{{ route('student.classrooms.show', ['classroom' => $classroom->id]) }}"
                               class="absolute inset-0">
                                <span class="sr-only">View classroom</span>
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center p-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <div class="w-16 h-16 mb-4 text-gray-400">
                            <i class="fi fi-rr-search text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No Classrooms Available</h3>
                        <p class="text-sm text-gray-500 text-center mt-1">Check back later for new classes</p>
                    </div>
                @endforelse
            </div>
        @endif

        <!-- Pagination -->
        <div class="mt-6">
            @if (request()->get('activeTab') == 1)
                {!! $myClassrooms->links() !!}
            @else
                {!! $classrooms->links() !!}
            @endif
        </div>
    </div>
</x-dashboard.student.base>
