<x-dashboard.admin.base>
    <div class="space-y-6 w-full">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">
            <!-- Users Card -->
            <div class="flex items-center p-4 sm:p-6 rounded-lg shadow-lg transition-transform duration-300 bg-base-100 hover:scale-105">
                <div class="flex justify-center items-center w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-primary/10">
                    <i class="text-2xl sm:text-4xl fi fi-rr-users text-primary"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <h1 class="text-sm sm:text-lg font-semibold text-gray-600">Total Users</h1>
                    <p class="text-2xl sm:text-4xl font-bold text-primary">{{ $total_users }}</p>
                </div>
            </div>

            <!-- Classrooms Card -->
            <div class="flex items-center p-4 sm:p-6 rounded-lg shadow-lg transition-transform duration-300 bg-base-100 hover:scale-105">
                <div class="flex justify-center items-center w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-success/10">
                    <i class="text-2xl sm:text-4xl fi fi-rr-chalkboard-user text-success"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <h1 class="text-sm sm:text-lg font-semibold text-gray-600">Total Classrooms</h1>
                    <p class="text-2xl sm:text-4xl font-bold text-success">{{ $total_classrooms }}</p>
                </div>
            </div>

            <!-- Students Card -->
            <div class="flex items-center p-4 sm:p-6 rounded-lg shadow-lg transition-transform duration-300 bg-base-100 hover:scale-105">
                <div class="flex justify-center items-center w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-secondary/10">
                    <i class="text-2xl sm:text-4xl fi fi-rr-graduation-cap text-secondary"></i>
                </div>
                <div class="ml-3 sm:ml-4">
                    <h1 class="text-sm sm:text-lg font-semibold text-gray-600">Total Students</h1>
                    <p class="text-2xl sm:text-4xl font-bold text-secondary">{{ $total_students }}</p>
                </div>
            </div>
        </div>

        {{-- Charts Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Enrollment Trend Chart --}}
            <div class="p-4 sm:p-6 rounded-lg shadow-lg bg-base-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg sm:text-2xl font-bold text-blue-600">Enrollment Trend</h2>
                    <span class="text-xs sm:text-sm text-gray-500">Last 6 months</span>
                </div>

                <!-- responsive chart wrapper -->
                <div class="h-56 sm:h-64 md:h-72 w-full">
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
                        height="100%"
                    />
                </div>
            </div>

            {{-- Students per Grade Level Chart --}}
            <div class="p-4 sm:p-6 rounded-lg shadow-lg bg-base-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg sm:text-2xl font-bold text-blue-600">Students per Grade Level</h2>
                    <span class="text-xs sm:text-sm text-gray-500">Current Academic Year</span>
                </div>

                <div class="h-56 sm:h-64 md:h-72 w-full">
                    <x-charts.bar-chart
                        chartId="studentsPerStrand"
                        :labels="$studentsPerStrand['labels']"
                        :datasets="$studentsPerStrand['datasets']"
                        :options="[
                            'title' => 'Grade Levels Distribution',
                            'plugins' => [
                                'legend' => [
                                    'position' => 'bottom'
                                ]
                            ]
                        ]"
                        height="100%"
                    />
                </div>
            </div>

            {{-- Gender Distribution Chart --}}
            <div class="p-4 sm:p-6 rounded-lg shadow-lg bg-base-100 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg sm:text-2xl font-bold text-blue-600">Gender Distribution</h2>
                    <span class="text-xs sm:text-sm text-gray-500">All Students</span>
                </div>

                <div class="max-w-md sm:max-w-lg mx-auto">
                    <div class="h-56 sm:h-64 md:h-72 w-full">
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
                            height="100%"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
