<x-dashboard.teacher.base>
    <!-- Top stats: stack on mobile, 3 columns on small+ -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <x-card-v1 icon="fi fi-rr-chalkboard" label="Classrooms" count="1" icon_color="primary" />
        <x-card-v1 icon="fi fi-rr-chalkboard-user" label="Students" count="1" icon_color="secondary" />
        <x-card-v1 icon="fi fi-rr-books" label="Subjects" count="1" icon_color="accent" />
    </div>

    <!-- Two column section: stack on mobile -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Class Performance Chart -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-xl md:text-2xl font-bold text-primary">Class Performance</h2>
            <div x-data="lineChart">
                <div x-ref="chart" class="w-full h-56 md:h-72 lg:h-96"></div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-xl md:text-2xl font-bold text-primary">Recent Activities</h2>
            <ul class="text-sm text-secondary space-y-3 max-h-56 overflow-auto">
                <li class="flex items-start gap-2"><i class="fi fi-rr-time-past text-accent"></i><span>Graded Assignment
                        for Class A</span></li>
                <li class="flex items-start gap-2"><i class="fi fi-rr-user-check text-accent"></i><span>Attended
                        Parent-Teacher Meeting</span></li>
                <li class="flex items-start gap-2"><i class="fi fi-rr-document-signed text-accent"></i><span>Updated
                        Syllabus for Math 101</span></li>
            </ul>
        </div>
    </div>

    <!-- Bottom section: stack on mobile, 2 columns on md+ -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Upcoming Deadlines -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-xl md:text-2xl font-bold text-primary">Upcoming Deadlines</h2>
            <ul class="text-sm text-secondary space-y-2">
                <li class="flex items-center gap-2"><i class="fi fi-rr-calendar text-accent"></i><span>Submit Midterm
                        Grades - March 20</span></li>
                <li class="flex items-center gap-2"><i class="fi fi-rr-notebook text-accent"></i><span>Lesson Plan
                        Update - March 25</span></li>
                <li class="flex items-center gap-2"><i class="fi fi-rr-presentation text-accent"></i><span>Faculty
                        Meeting - March 28</span></li>
            </ul>
        </div>
    </div>
</x-dashboard.teacher.base>
