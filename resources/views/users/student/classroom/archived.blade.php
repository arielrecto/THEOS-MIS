<x-dashboard.student.base>
    <x-notification-message />

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Archived Classrooms</h1>
                <p class="text-sm text-gray-500 mt-1">Classrooms you were enrolled in that have been archived by the teacher.</p>
            </div>
            <a href="{{ route('student.classrooms.index') }}" class="btn btn-ghost btn-sm gap-2 whitespace-nowrap">
                <i class="fi fi-rr-arrow-left"></i>
                Back to Classrooms
            </a>
        </div>

        <!-- Notice Banner -->
        <div class="alert bg-amber-50 border border-amber-200 text-amber-800 mb-6 rounded-lg flex gap-3 items-start p-4">
            <i class="fi fi-rr-info text-lg flex-shrink-0 mt-0.5"></i>
            <div class="text-sm">
                <p class="font-semibold">These classrooms are no longer active.</p>
                <p class="mt-1 text-amber-700">Archived classrooms are read-only. You can still view past announcements and tasks, but you cannot submit new work or join activities.</p>
            </div>
        </div>

        @if($archivedClassrooms->count() > 0)
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($archivedClassrooms as $classroom)
                    <article class="overflow-hidden relative rounded-lg bg-white shadow-sm border border-gray-200">
                        <!-- Header Banner (greyscale to indicate archived) -->
                        <div class="relative h-24 sm:h-28 md:h-32 bg-gradient-to-r from-gray-500 to-gray-400">
                            <!-- Archived badge -->
                            <div class="absolute top-2 left-2 z-10">
                                <span class="badge badge-sm bg-amber-500 text-white border-0 gap-1">
                                    <i class="fi fi-rr-folder-download text-xs"></i>
                                    Archived
                                </span>
                            </div>

                            <div class="absolute inset-0 p-3 sm:p-4 flex flex-col justify-end">
                                <h2 class="text-base sm:text-lg font-semibold text-white truncate">
                                    {{ $classroom->subject->name }}
                                </h2>
                                <p class="text-xs sm:text-sm text-white/90 truncate">{{ $classroom->name }} • {{ $classroom->strand->acronym }}</p>
                                <p class="mt-1 text-xs sm:text-sm text-white/80">{{ $classroom->academicYear->name }}</p>
                            </div>

                            <!-- Teacher Avatar -->
                            <div class="absolute right-3 bottom-3">
                                <div class="overflow-hidden w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-full ring-4 ring-white">
                                    @if($classroom->teacher->profile?->image)
                                        <img src="{{ $classroom->teacher->profile->image }}"
                                             alt="{{ $classroom->teacher->name }}"
                                             class="object-cover w-full h-full grayscale">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <i class="fi fi-rr-user text-gray-500 text-lg"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-3 sm:p-4 bg-white">
                            <p class="text-sm text-gray-600 truncate">{{ $classroom->teacher->name }}</p>
                            <p class="text-xs text-gray-400 mt-1 truncate">Class code: {{ $classroom->class_code }}</p>
                        </div>

                        <!-- Overlay Link -->
                        <a href="{{ route('student.classrooms.show', $classroom->id) }}"
                           class="absolute inset-0"
                           aria-label="View archived classroom {{ $classroom->subject->name }}">
                            <span class="sr-only">View classroom</span>
                        </a>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $archivedClassrooms->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 bg-white rounded-lg shadow-sm border border-dashed border-gray-300">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <i class="fi fi-rr-folder-download text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-base font-semibold text-gray-700">No Archived Classrooms</h3>
                <p class="text-sm text-gray-500 mt-1">You have no archived classrooms at the moment.</p>
                <a href="{{ route('student.classrooms.index') }}" class="btn btn-accent btn-sm text-white mt-4 gap-2">
                    <i class="fi fi-rr-users-alt"></i>
                    Go to Classrooms
                </a>
            </div>
        @endif
    </div>
</x-dashboard.student.base>
