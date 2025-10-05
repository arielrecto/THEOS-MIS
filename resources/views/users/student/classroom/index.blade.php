<x-dashboard.student.base>
    <x-notification-message />

    <div class="container px-4 mx-auto">
        <x-tab.tab :tabs="['Classrooms', 'My Classrooms']" :active="0" />

        <!-- Filters Section -->
        <div class="p-4 mt-6 mb-4 bg-white rounded-lg shadow">
            <form method="GET" class="flex flex-wrap gap-4">
                <input type="hidden" name="activeTab" value="{{ request()->get('activeTab', 0) }}">

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

                <!-- Grade Level Filter -->
                <div class="form-control">
                    <label class="label">
                        <span class="font-medium label-text">Grade Level</span>
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
                        {{-- <optgroup label="Junior High School">
                            @for ($i = 7; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ request('grade_level') == $i ? 'selected' : '' }}>
                                    Grade {{ $i }}
                                </option>
                            @endfor
                        </optgroup> --}}
                        {{-- <optgroup label="Senior High School">
                            @for ($i = 11; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('grade_level') == $i ? 'selected' : '' }}>
                                    Grade {{ $i }}
                                </option>
                            @endfor
                        </optgroup> --}}
                    </select>
                </div>

                <!-- Clear Filters -->
                @if(request('academic_year') || request('grade_level'))
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium opacity-0 label-text">Clear</span>
                        </label>
                        <a href="{{ route('student.classrooms.index', ['activeTab' => request()->get('activeTab', 0)]) }}"
                           class="btn btn-ghost btn-sm">
                            <i class="mr-2 fi fi-rr-refresh"></i>
                            Clear Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>

        @if (request()->get('activeTab') == 1)
            <!-- My Classrooms Grid -->
            <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($myClassrooms as $myClassroom)
                    <div class="overflow-hidden relative rounded-lg transition-shadow duration-300 group hover:shadow-xl">
                        <!-- Header Banner -->
                        <div class="relative h-32 bg-gradient-to-r from-accent to-accent/80">
                            <div class="absolute inset-0 p-6">
                                <h2 class="text-xl font-bold text-white truncate">{{ $myClassroom->subject->name }}</h2>
                                <p class="text-sm text-white/90">{{ $myClassroom->name }} - {{ $myClassroom->strand->acronym }}</p>
                                <p class="mt-1 text-sm text-white/80">{{ $myClassroom->academicYear->name }}</p>
                            </div>
                            <!-- Teacher Avatar -->
                            <div class="absolute right-4 -bottom-6">
                                <div class="overflow-hidden w-12 h-12 bg-white rounded-full ring-4 ring-white">
                                    <img src="{{ $myClassroom->teacher->profile->image }}"
                                         alt="{{ $myClassroom->teacher->name }}"
                                         class="object-cover w-full h-full">
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 pt-8 bg-white">
                            <p class="text-sm text-gray-600">{{ $myClassroom->teacher->name }}</p>
                        </div>

                        <!-- Overlay Link -->
                        <a href="{{ route('student.classrooms.show', ['classroom' => $myClassroom->id]) }}"
                           class="absolute inset-0">
                            <span class="sr-only">View classroom</span>
                        </a>
                    </div>
                @empty
                    <div class="flex flex-col col-span-full justify-center items-center p-12 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed">
                        <div class="mb-4 w-16 h-16 text-gray-400">
                            <i class="text-4xl fi fi-rr-book-alt"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No Enrolled Classrooms</h3>
                        <p class="mt-1 text-sm text-center text-gray-500">Join a classroom to get started</p>
                    </div>
                @endforelse
            </div>
        @endif

        @if (request()->get('activeTab') == 0)
            <!-- Available Classrooms Grid -->
            <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($classrooms as $classroom)
                    <div class="overflow-hidden relative rounded-lg transition-shadow duration-300 group hover:shadow-xl">
                        <!-- Header Banner -->
                        <div class="relative h-32 bg-gradient-to-r from-accent to-accent/80">
                            <div class="absolute inset-0 p-6">
                                <h2 class="text-xl font-bold text-white truncate">{{ $classroom->subject->name }}</h2>
                                <p class="text-sm text-white/90">{{ $classroom->name }} - {{ $classroom->strand->acronym }}</p>
                                <p class="mt-1 text-sm text-white/80">{{ $classroom->academicYear->name }}</p>
                            </div>
                            <!-- Teacher Avatar -->
                            <div class="absolute right-4 -bottom-6">
                                <div class="overflow-hidden w-12 h-12 bg-white rounded-full ring-4 ring-white">
                                    <img src="{{ $classroom->teacher->profile->image }}"
                                         alt="{{ $classroom->teacher->name }}"
                                         class="object-cover w-full h-full">
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 pt-8 bg-white">
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-600">{{ $classroom->teacher->name }}</p>
                                @if (!$classroom->classroomStudents()->where('student_id', Auth::user()->id)->exists())
                                    <button class="btn btn-sm btn-accent" onclick="enroll_{{ $classroom->id }}.showModal()">
                                        <i class="mr-2 fi fi-rr-plus"></i>Join
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
                                    <button class="absolute top-2 right-2 btn btn-sm btn-circle btn-ghost">✕</button>
                                </form>
                                <h3 class="mb-4 text-lg font-bold">Join Classroom</h3>
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
                                               class="w-full input input-bordered"
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
                    <div class="flex flex-col col-span-full justify-center items-center p-12 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed">
                        <div class="mb-4 w-16 h-16 text-gray-400">
                            <i class="text-4xl fi fi-rr-search"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No Classrooms Available</h3>
                        <p class="mt-1 text-sm text-center text-gray-500">Check back later for new classes</p>
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
