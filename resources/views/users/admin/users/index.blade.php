<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('users')"/>
    <div class="panel p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Students Card --}}
            <a href="{{route('admin.users.students.index')}}"
               class="group transition-all duration-300 hover:shadow-lg rounded-xl border border-gray-200 bg-white p-6 hover:border-accent">
                <div class="flex items-center justify-between">
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-800">
                            Students
                        </h2>
                        <p class="text-4xl font-bold text-accent">
                            {{count($students)}}
                        </p>
                        <p class="text-sm text-gray-500">
                            Total enrolled students
                        </p>
                    </div>
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-accent/10 group-hover:bg-accent/20">
                        <i class="fi fi-rr-graduation-cap text-3xl text-accent"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-accent">
                    <span>View details</span>
                    <i class="fi fi-rr-arrow-right ml-2"></i>
                </div>
            </a>

            {{-- Teachers Card --}}
            <a href="{{route('admin.users.teacher.index')}}"
               class="group transition-all duration-300 hover:shadow-lg rounded-xl border border-gray-200 bg-white p-6 hover:border-accent">
                <div class="flex items-center justify-between">
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-800">
                            Teachers
                        </h2>
                        <p class="text-4xl font-bold text-accent">
                            {{count($teachers)}}
                        </p>
                        <p class="text-sm text-gray-500">
                            Total active teachers
                        </p>
                    </div>
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-accent/10 group-hover:bg-accent/20">
                        <i class="fi fi-rr-chalkboard-user text-3xl text-accent"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-accent">
                    <span>View details</span>
                    <i class="fi fi-rr-arrow-right ml-2"></i>
                </div>
            </a>
        </div>
    </div>
</x-dashboard.admin.base>
