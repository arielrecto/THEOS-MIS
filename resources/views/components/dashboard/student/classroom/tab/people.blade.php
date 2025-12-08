@props(['classroom'])

<x-slot name="people">
    <div class="grid grid-cols-1 gap-6">
        <!-- Teacher Section -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-accent px-6 py-4">
                <h2 class="text-base sm:text-lg font-semibold text-white">Teacher</h2>
            </div>
            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-3">
                    <div class="avatar flex-shrink-0">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full overflow-hidden bg-gray-100">
                            <img
                                src="{{ $classroom->teacher->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($classroom->teacher->name) }}"
                                alt="{{ $classroom->teacher->name ?? 'Teacher' }}"
                                class="object-cover w-full h-full">
                        </div>
                    </div>

                    <div class="min-w-0">
                        <h3 class="text-sm sm:text-base font-medium leading-tight truncate">
                            {{ $classroom->teacher->name }}
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 truncate">
                            {{ $classroom->teacher->email }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Section -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-accent px-4 py-3 sm:px-6 sm:py-4 flex items-center justify-between gap-3">
                <h2 class="text-base sm:text-lg font-semibold text-white">Students</h2>
                <span class="badge badge-ghost  text-xs sm:text-sm">
                    {{ $classroom->classroomStudents->count() }} Students
                </span>
            </div>

            <div class="p-3 sm:p-6">
                {{-- make list scrollable on small screens and constrained height on larger lists --}}
                <div class="divide-y max-h-64 overflow-auto">
                    @foreach($classroom->classroomStudents as $classroomStudent)
                        <div class="flex items-center justify-between py-3 first:pt-0 last:pb-0">
                            <div class="flex items-center space-x-3 min-w-0">
                                <div class="avatar flex-shrink-0">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full overflow-hidden bg-gray-100">
                                        <img
                                            src="{{ $classroomStudent->student->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($classroomStudent->student->name) }}"
                                            alt="{{ $classroomStudent->student->name }}"
                                            class="object-cover w-full h-full">
                                    </div>
                                </div>

                                <div class="min-w-0">
                                    <h3 class="text-sm sm:text-base font-medium leading-tight truncate">
                                        {{ $classroomStudent->student->name }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-500 truncate">
                                        {{ $classroomStudent->student->email }}
                                    </p>
                                </div>
                            </div>

                            {{-- optional action area (keeps layout stable on mobile) --}}
                            <div class="ml-3 flex-shrink-0">
                                <span class="text-xs sm:text-sm text-gray-400">{{ $classroomStudent->student->studentProfile->lrn ?? '' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- when many students, provide "show more" for very small devices --}}
                @if($classroom->classroomStudents->count() > 8)
                    <div class="mt-3 text-center sm:hidden">
                        <details class="text-sm">
                            <summary class="text-accent font-medium">Show full list</summary>
                            <div class="mt-2 space-y-2">
                                @foreach($classroom->classroomStudents as $classroomStudent)
                                    <div class="flex items-center justify-between py-2">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-100">
                                                <img src="{{ $classroomStudent->student->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($classroomStudent->student->name) }}"
                                                     alt="{{ $classroomStudent->student->name }}" class="object-cover w-full h-full">
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium truncate">{{ $classroomStudent->student->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $classroomStudent->student->email }}</p>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $classroomStudent->student->studentProfile->lrn ?? '' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-slot>
