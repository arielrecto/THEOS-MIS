<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('users')"/>
    <div class="panel p-4 sm:p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Students Card --}}
            <a href="{{route('admin.users.students.index')}}"
               class="group transition-all duration-300 hover:shadow-lg rounded-xl border border-gray-200 bg-white p-4 sm:p-6 hover:border-accent flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-accent/10 shrink-0">
                    <i class="fi fi-rr-graduation-cap text-2xl sm:text-3xl text-accent"></i>
                </div>

                <div class="flex-1 min-w-0">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 truncate">Students</h2>
                    <p class="text-2xl sm:text-4xl font-bold text-accent mt-1">{{ count($students) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Total enrolled students</p>
                </div>

                <div class="mt-3 sm:mt-0">
                    <span class="inline-flex items-center text-sm text-accent">
                        <span class="hidden sm:inline">View details</span>
                        <i class="fi fi-rr-arrow-right ml-2"></i>
                    </span>
                </div>
            </a>

            {{-- Teachers Card --}}
            <a href="{{route('admin.users.teacher.index')}}"
               class="group transition-all duration-300 hover:shadow-lg rounded-xl border border-gray-200 bg-white p-4 sm:p-6 hover:border-accent flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-accent/10 shrink-0">
                    <i class="fi fi-rr-chalkboard-user text-2xl sm:text-3xl text-accent"></i>
                </div>

                <div class="flex-1 min-w-0">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 truncate">Teachers</h2>
                    <p class="text-2xl sm:text-4xl font-bold text-accent mt-1">{{ count($teachers) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Total active teachers</p>
                </div>

                <div class="mt-3 sm:mt-0">
                    <span class="inline-flex items-center text-sm text-accent">
                        <span class="hidden sm:inline">View details</span>
                        <i class="fi fi-rr-arrow-right ml-2"></i>
                    </span>
                </div>
            </a>
        </div>
    </div>
</x-dashboard.admin.base>
