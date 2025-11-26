<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('Subject')" :back_url="route('admin.subjects.index')" />
    <div class="container max-w-7xl p-4 sm:p-6 mx-auto">
        <div class="panel flex flex-col gap-4 min-h-96">
            <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-accent capitalize truncate">{{ $subject->name }}
            </h1>

            <div class="p-3 sm:p-4 rounded-lg bg-gray-100 text-gray-700 text-sm">
                {{ $subject->description ?? 'No description provided.' }}
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
                <x-card label="Classrooms" total="{{ $subject->classrooms()->count() }}"
                    class="shadow-none border border-accent" />
                <!-- add other summary cards here if needed -->
            </div>

            <h2 class="text-base sm:text-lg font-bold text-accent mt-2">Classrooms</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 w-full">
                @forelse ($subject->classrooms as $classroom)
                    <div class="rounded-lg border border-accent overflow-hidden bg-white shadow-sm flex flex-col">
                        <!-- Top banner -->
                        <a href="#" class="relative p-4 flex items-start gap-3 md:gap-4 bg-accent/10 md:h-40">
                            <div class="flex-1 min-w-0">
                                <h3
                                    class="text-sm sm:text-base md:text-lg font-semibold text-primary capitalize truncate">
                                    {{ $classroom->subject->name }}
                                </h3>
                                <p class="text-xs sm:text-sm text-primary/80 mt-1 truncate">
                                    {{ $classroom->teacher->name }}
                                </p>
                                <p class="text-xs text-primary/70 mt-1 truncate">
                                    {{ $classroom->schedule ?? '' }}
                                </p>
                            </div>

                            <div class="flex-shrink-0 self-center">
                                @if (optional($classroom->teacher->profile)->image)
                                    <img src="{{ $classroom->teacher->profile->image }}"
                                        alt="{{ $classroom->teacher->name }}"
                                        class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 object-cover rounded-full border-2 border-white shadow-sm" />
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($classroom->teacher->name) }}&size=128"
                                        alt="{{ $classroom->teacher->name }}"
                                        class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 object-cover rounded-full border-2 border-white shadow-sm" />
                                @endif
                            </div>
                        </a>

                        <!-- Bottom details -->
                        <div class="p-3 sm:p-4 flex-1">
                            <div class="text-sm sm:text-base font-medium truncate">
                                {{ $classroom->name }}
                            </div>
                            <div class="text-xs text-gray-600 mt-1 truncate">
                                {{ $classroom->strand->acronym ?? ($classroom->strand->name ?? 'No Strand') }}
                            </div>

                            <div class="mt-3 flex items-center justify-between">
                                <div class="text-xs text-gray-500">
                                    {{ $classroom->classroomStudents->count() ?? 0 }} students
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.classrooms.show', ['classroom' => $classroom->id]) }}"
                                        class="btn btn-ghost btn-sm" aria-label="View classroom">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.classrooms.edit', ['classroom' => $classroom->id]) }}"
                                        class="btn btn-sm btn-primary" aria-label="Edit classroom">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex items-center justify-center p-6">
                        <div class="text-center text-gray-500">
                            <i class="fi fi-rr-book text-3xl mb-2"></i>
                            <p>No Classrooms</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
