<x-dashboard.student.base>
    <x-notification-message />

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <x-tab.tab :tabs="['Classrooms', 'My Classrooms']" :active="0" />

        <!-- Filters Section -->
        <div class="p-3 sm:p-4 mt-6 mb-4 bg-white rounded-lg shadow">
            <!-- stacked on mobile, horizontal on md+ -->
            <form method="GET" class="flex flex-col md:flex-row md:items-end gap-3">
                <input type="hidden" name="activeTab" value="{{ request()->get('activeTab', 0) }}">

                <!-- Academic Year Filter -->
                <div class="form-control w-full md:w-auto">
                    <label class="label">
                        <span class="font-medium label-text text-sm sm:text-base">Academic Year</span>
                    </label>
                    <select name="academic_year"
                            onchange="this.form.submit()"
                            class="select select-bordered w-full md:min-w-[200px] text-sm sm:text-base">
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
                <div class="form-control w-full md:w-auto">
                    <label class="label">
                        <span class="font-medium label-text text-sm sm:text-base">Grade Level</span>
                    </label>
                    <select name="grade_level"
                            onchange="this.form.submit()"
                            class="select select-bordered w-full md:min-w-[160px] text-sm sm:text-base">
                        <option value="">All Grade Levels</option>
                        <optgroup label="Elementary">
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ request('grade_level') == $i ? 'selected' : '' }}>
                                    Grade {{ $i }}
                                </option>
                            @endfor
                        </optgroup>
                    </select>
                </div>

                <!-- Clear Filters -->
                @if(request('academic_year') || request('grade_level'))
                    <div class="form-control w-full md:w-auto">
                        <label class="label">
                            <span class="font-medium opacity-0 label-text">Clear</span>
                        </label>
                        <a href="{{ route('student.classrooms.index', ['activeTab' => request()->get('activeTab', 0)]) }}"
                           class="btn btn-ghost btn-sm w-full md:w-auto text-sm">
                            <i class="mr-2 fi fi-rr-refresh"></i>
                            Clear Filters
                        </a>
                    </div>
                @endif
            </form>
        </div>

        @if (request()->get('activeTab') == 1)
            <!-- My Classrooms Grid -->
            <div class="grid grid-cols-1 gap-4 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($myClassrooms as $myClassroom)
                    <article class="overflow-hidden relative rounded-lg group bg-white shadow-sm hover:shadow-md">
                        <!-- Header Banner -->
                        <div class="relative h-24 sm:h-28 md:h-32 bg-gradient-to-r from-accent to-accent/80">
                            <div class="absolute inset-0 p-3 sm:p-4 flex flex-col justify-end">
                                <h2 class="text-base sm:text-lg md:text-xl font-semibold text-white truncate">
                                    {{ $myClassroom->subject->name }}
                                </h2>
                                <p class="text-xs sm:text-sm text-white/90 truncate">{{ $myClassroom->name }} • {{ $myClassroom->strand->acronym }}</p>
                                <p class="mt-1 text-xs sm:text-sm text-white/80">{{ $myClassroom->academicYear->name }}</p>
                            </div>

                            <!-- Teacher Avatar (responsive sizes) -->
                            <div class="absolute right-3 -bottom-6">
                                <div class="overflow-hidden w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-full ring-4 ring-white">
                                    <img src="{{ $myClassroom->teacher->profile->image }}"
                                         alt="{{ $myClassroom->teacher->name }}"
                                         class="object-cover w-full h-full">
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-3 sm:p-4 pt-8 bg-white">
                            <p class="text-sm sm:text-base text-gray-600 truncate">{{ $myClassroom->teacher->name }}</p>
                        </div>

                        <!-- Overlay Link -->
                        <a href="{{ route('student.classrooms.show', ['classroom' => $myClassroom->id]) }}"
                           class="absolute inset-0" aria-label="View classroom {{ $myClassroom->subject->name }}">
                            <span class="sr-only">View classroom</span>
                        </a>
                    </article>
                @empty
                    <div class="flex flex-col col-span-full justify-center items-center p-8 sm:p-12 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed">
                        <div class="mb-4 w-14 h-14 sm:w-16 sm:h-16 text-gray-400">
                            <i class="text-3xl sm:text-4xl fi fi-rr-book-alt"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-medium text-gray-900">No Enrolled Classrooms</h3>
                        <p class="mt-1 text-sm sm:text-base text-center text-gray-500">Join a classroom to get started</p>
                    </div>
                @endforelse
            </div>
        @endif

        @if (request()->get('activeTab') == 0)
            <!-- Available Classrooms Grid -->
            <div class="grid grid-cols-1 gap-4 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($classrooms as $classroom)
                    <article class="overflow-hidden relative rounded-lg group bg-white shadow-sm hover:shadow-md">
                        <!-- Header Banner -->
                        <div class="relative h-24 sm:h-28 md:h-32 bg-gradient-to-r from-accent to-accent/80">
                            <div class="absolute inset-0 p-3 sm:p-4 flex flex-col justify-end">
                                <h2 class="text-base sm:text-lg md:text-xl font-semibold text-white truncate">
                                    {{ $classroom->subject->name }}
                                </h2>
                                <p class="text-xs sm:text-sm text-white/90 truncate">{{ $classroom->name }} • {{ $classroom->strand->acronym }}</p>
                                <p class="mt-1 text-xs sm:text-sm text-white/80">{{ $classroom->academicYear->name }}</p>
                            </div>

                            <!-- Teacher Avatar -->
                            <div class="absolute right-3 -bottom-6">
                                <div class="overflow-hidden w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-full ring-4 ring-white">
                                    <img src="{{ $classroom->teacher->profile->image }}"
                                         alt="{{ $classroom->teacher->name }}"
                                         class="object-cover w-full h-full">
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-3 sm:p-4 pt-8 bg-white">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <p class="text-sm sm:text-base text-gray-600 truncate">{{ $classroom->teacher->name }}</p>
                                <div class="mt-2 sm:mt-0 flex items-center gap-3 w-full sm:w-auto">
                                    @if (!$classroom->classroomStudents()->where('student_id', Auth::user()->id)->exists())
                                        <!-- full width on mobile -->
                                        <button class="btn btn-sm btn-accent w-full sm:w-auto text-sm sm:text-base"
                                                onclick="document.getElementById('enroll_{{ $classroom->id }}').showModal()">
                                            <i class="mr-2 fi fi-rr-plus"></i>
                                            <span class="truncate">Join</span>
                                        </button>
                                    @else
                                        <span class="badge badge-accent w-full sm:w-auto text-center text-sm sm:text-base">Enrolled</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Join Modal -->
                        <dialog id="enroll_{{ $classroom->id }}" class="modal">
                            <div class="modal-box w-full max-w-md">
                                <form method="dialog">
                                    <button class="absolute top-2 right-2 btn btn-sm btn-circle btn-ghost">✕</button>
                                </form>
                                <h3 class="mb-3 text-lg sm:text-xl font-bold">Join Classroom</h3>
                                <form action="{{ route('student.classrooms.join', ['classroom' => $classroom->id]) }}"
                                      method="post"
                                      class="space-y-3">
                                    @csrf
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text text-sm">Enter Class Code</span>
                                        </label>
                                        <input type="text"
                                               name="class_code"
                                               class="w-full input input-bordered text-sm"
                                               placeholder="Enter the code provided by your teacher"
                                               required>
                                    </div>
                                    <div class="modal-action">
                                        <button type="submit" class="btn btn-accent w-full sm:w-auto text-sm sm:text-base">Join Class</button>
                                    </div>
                                </form>
                            </div>
                            <form method="dialog" class="modal-backdrop">
                                <button>close</button>
                            </form>
                        </dialog>

                        <!-- Overlay Link only when enrolled -->
                        @if ($classroom->classroomStudents()->where('student_id', Auth::user()->id)->exists())
                            <a href="{{ route('student.classrooms.show', ['classroom' => $classroom->id]) }}"
                               class="absolute inset-0" aria-label="Open classroom {{ $classroom->subject->name }}">
                                <span class="sr-only">View classroom</span>
                            </a>
                        @endif
                    </article>
                @empty
                    <div class="flex flex-col col-span-full justify-center items-center p-8 sm:p-12 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed">
                        <div class="mb-4 w-14 h-14 sm:w-16 sm:h-16 text-gray-400">
                            <i class="text-3xl sm:text-4xl fi fi-rr-search"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-medium text-gray-900">No Classrooms Available</h3>
                        <p class="mt-1 text-sm sm:text-base text-center text-gray-500">Check back later for new classes</p>
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
