<x-dashboard.admin.base>
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
        <!-- Users Card -->
        <div class="flex items-center p-6 rounded-lg shadow-lg transition-transform duration-300 bg-base-100 hover:scale-105">
            <div class="flex justify-center items-center w-16 h-16 rounded-full bg-primary/10">
                <i class="text-4xl fi fi-rr-users text-primary"></i>
            </div>
            <div class="ml-4">
                <h1 class="text-lg font-semibold text-gray-600">Total Users</h1>
                <p class="text-4xl font-bold text-primary">{{ $total_users }}</p>
            </div>
        </div>

        <!-- Classrooms Card -->
        <div class="flex items-center p-6 rounded-lg shadow-lg transition-transform duration-300 bg-base-100 hover:scale-105">
            <div class="flex justify-center items-center w-16 h-16 rounded-full bg-success/10">
                <i class="text-4xl fi fi-rr-chalkboard-user text-success"></i>
            </div>
            <div class="ml-4">
                <h1 class="text-lg font-semibold text-gray-600">Total Classrooms</h1>
                <p class="text-4xl font-bold text-success">{{ $total_classrooms }}</p>
            </div>
        </div>

        <!-- Students Card -->
        <div class="flex items-center p-6 rounded-lg shadow-lg transition-transform duration-300 bg-base-100 hover:scale-105">
            <div class="flex justify-center items-center w-16 h-16 rounded-full bg-secondary/10">
                <i class="text-4xl fi fi-rr-graduation-cap text-secondary"></i>
            </div>
            <div class="ml-4">
                <h1 class="text-lg font-semibold text-gray-600">Total Students</h1>
                <p class="text-4xl font-bold text-secondary">{{ $total_students }}</p>
            </div>
        </div>
    </div>

    {{-- Charts Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        {{-- Enrollment Trend Chart --}}
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-primary">Enrollment Trend</h2>
                <span class="text-sm text-gray-500">Last 6 months</span>
            </div>
            <x-charts.bar-chart
                chartId="enrollmentTrend"
                :labels="$enrollmentTrend['labels']"
                :datasets="$enrollmentTrend['datasets']"
                :options="[
                    'title' => 'Monthly Enrollment',
                    'plugins' => [
                        'legend' => [
                            'position' => 'bottom'
                        ]
                    ]
                ]"
                height="300px"
            />
        </div>

        {{-- Students per Strand Chart --}}
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-primary">Students per Strand</h2>
                <span class="text-sm text-gray-500">Current Academic Year</span>
            </div>
            <x-charts.bar-chart
                chartId="studentsPerStrand"
                :labels="$studentsPerStrand['labels']"
                :datasets="$studentsPerStrand['datasets']"
                :options="[
                    'title' => 'Strand Distribution',
                    'plugins' => [
                        'legend' => [
                            'position' => 'bottom'
                        ]
                    ]
                ]"
                height="300px"
            />
        </div>

        {{-- Gender Distribution Chart --}}
        <div class="p-6 rounded-lg shadow-lg bg-base-100 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-primary">Gender Distribution</h2>
                <span class="text-sm text-gray-500">All Students</span>
            </div>
            <div class="max-w-md mx-auto">
                <x-charts.bar-chart
                    chartId="genderDistribution"
                    :labels="$genderDistribution['labels']"
                    :datasets="$genderDistribution['datasets']"
                    :options="[
                        'title' => 'Student Gender Distribution',
                        'plugins' => [
                            'legend' => [
                                'position' => 'bottom'
                            ]
                        ]
                    ]"
                    type="doughnut"
                    height="300px"
                />
            </div>
        </div>
    </div>


</x-dashboard.admin.base>
