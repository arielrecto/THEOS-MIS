<x-dashboard.registrar.base>
    <div class="grid grid-cols-3 gap-5">
        <x-card-v1 icon="fi fi-rr-chalkboard" label="Classrooms" count="1" icon_color="primary" />
        <x-card-v1 icon="fi fi-rr-chalkboard-user" label="Students" count="1" icon_color="secondary" />
        <x-card-v1 icon="fi fi-rr-books" label="Subjects" count="1" icon_color="accent" />
    </div>

    <div class="grid grid-cols-2 gap-6 mt-6">
        <!-- Class Performance Chart -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-2xl font-bold text-primary">Class Performance</h2>
            <div x-data="lineChart">
                <div x-ref="chart"></div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-2xl font-bold text-primary">Recent Activities</h2>
            <ul class="text-sm text-secondary">
                <li><i class="fi fi-rr-time-past text-accent"></i> Graded Assignment for Class A</li>
                <li><i class="fi fi-rr-user-check text-accent"></i> Attended Parent-Teacher Meeting</li>
                <li><i class="fi fi-rr-document-signed text-accent"></i> Updated Syllabus for Math 101</li>
            </ul>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mt-6">

            <x-dashboard.bar-chart />


        <!-- Upcoming Deadlines -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-2xl font-bold text-primary">Upcoming Deadlines</h2>
            <ul class="text-sm text-secondary">
                <li><i class="fi fi-rr-calendar text-accent"></i> Submit Midterm Grades - March 20</li>
                <li><i class="fi fi-rr-notebook text-accent"></i> Lesson Plan Update - March 25</li>
                <li><i class="fi fi-rr-presentation text-accent"></i> Faculty Meeting - March 28</li>
            </ul>
        </div>
    </div>
</x-dashboard.registrar.base>
