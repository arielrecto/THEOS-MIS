<x-dashboard.admin.base>
    <div class="grid grid-cols-3 gap-6 w-full">
        <!-- Users Card -->
        <div
            class="flex items-center p-6 w-full h-40 rounded-lg shadow-lg transition-transform duration-300 bg-base-100 hover:scale-105">
            <div class="flex justify-center items-center w-16 h-16 rounded-full bg-primary/10">
                <i class="text-4xl fi fi-rr-users text-primary"></i>
            </div>
            <div class="ml-4">
                <h1 class="text-lg font-semibold text-gray-600">Total Users</h1>
                <p class="text-4xl font-bold text-primary">{{ $total_users ?? 120 }}</p>
            </div>
        </div>

        <!-- Classrooms Card -->
        <div
            class="flex items-center p-6 w-full h-40 rounded-lg shadow-lg transition-transform duration-300 bg-base-100 hover:scale-105">
            <div class="flex justify-center items-center w-16 h-16 rounded-full bg-success/10">
                <i class="text-4xl fi fi-rr-chalkboard-user text-success"></i>
            </div>
            <div class="ml-4">
                <h1 class="text-lg font-semibold text-gray-600">Total Classrooms</h1>
                <p class="text-4xl font-bold text-success">{{ $total_classrooms ?? 15 }}</p>
            </div>
        </div>

        <!-- Students Card -->
        <div
            class="flex items-center p-6 w-full h-40 rounded-lg shadow-lg transition-transform duration-300 bg-base-100 hover:scale-105">
            <div class="flex justify-center items-center w-16 h-16 rounded-full bg-secondary/10">
                <i class="text-4xl fi fi-rr-graduation-cap text-secondary"></i>
            </div>
            <div class="ml-4">
                <h1 class="text-lg font-semibold text-gray-600">Total Students</h1>
                <p class="text-4xl font-bold text-secondary">{{ $total_students ?? 450 }}</p>
            </div>
        </div>
    </div>

    <div class="p-6 mt-6 rounded-lg shadow-lg panel bg-base-100">
        <h2 class="mb-4 text-2xl font-bold text-primary">Statistics</h2>
        <x-dashboard.line-chart />
    </div>

    <div class="grid grid-cols-2 gap-6 mt-6">
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-2xl font-bold text-primary">Recent Activities</h2>
            <ul class="text-secondary">
                <li>Admin logged in at 9:00 AM</li>
                <li>New student registered</li>
                <li>Exam schedule updated</li>
            </ul>
        </div>
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-2xl font-bold text-primary">Upcoming Events</h2>
            <ul class="text-secondary">
                <li>Parent-Teacher Meeting - March 20</li>
                <li>Final Exams - April 10</li>
                <li>Graduation Ceremony - May 5</li>
            </ul>
        </div>
    </div>


    <x-dashboard.bar-chart />

</x-dashboard.admin.base>
