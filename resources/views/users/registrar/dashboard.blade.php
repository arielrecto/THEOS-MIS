<x-dashboard.registrar.base>
    <div class="mb-6">
        @if($currentAcademicYear)
            <div class="alert alert-info">
                <i class="fi fi-rr-info"></i>
                <span>Current Academic Year: {{ $currentAcademicYear->name }}</span>
            </div>
        @else
            <div class="alert alert-warning">
                <i class="fi fi-rr-exclamation"></i>
                <span>No active academic year set</span>
            </div>
        @endif
    </div>

    <!-- Top stats: stack on mobile, 2 cols on sm, 3 cols on lg -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <x-card-v1
            icon="fi fi-rr-graduation-cap"
            label="Total Enrollments"
            :count="$counts['enrollments']"
            icon_color="primary"
        />
        <x-card-v1
            icon="fi fi-rr-users"
            label="Total Students"
            :count="$counts['students']"
            icon_color="secondary"
        />
        <x-card-v1
            icon="fi fi-rr-calendar"
            label="Academic Years"
            :count="$counts['academic_years']"
            icon_color="accent"
        />
    </div>

    <!-- Main content: stacked on mobile, two columns on lg -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Enrollment Statistics Chart -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-xl sm:text-2xl font-bold text-primary">Enrollment Statistics</h2>

            <div x-data="{
                stats: {{ json_encode($enrollmentStats) }},
                chartInstance: null,
                getHeight() {
                    // smaller height for mobile
                    return (window.innerWidth < 640) ? 260 : 350;
                },
                init() {
                    const options = {
                        chart: {
                            type: 'bar',
                            height: this.getHeight(),
                            toolbar: { show: false },
                            animations: { enabled: true }
                        },
                        series: [{
                            name: 'Enrollees',
                            data: this.stats.map(item => item.count)
                        }],
                        xaxis: {
                            categories: this.stats.map(item => item.name),
                            labels: { rotate: -45 }
                        },
                        responsive: [
                            {
                                breakpoint: 640,
                                options: {
                                    chart: { height: 260 },
                                    plotOptions: { bar: { columnWidth: '60%' } }
                                }
                            }
                        ]
                    };
                    this.chartInstance = new ApexCharts(this.$refs.chart, options);
                    this.chartInstance.render();

                    // reflow on resize
                    window.addEventListener('resize', () => {
                        this.chartInstance.updateOptions({ chart: { height: this.getHeight() } }, false, true);
                    });
                }
            }" class="w-full">
                <div x-ref="chart" class="w-full"></div>
            </div>
        </div>

        <!-- Recent Enrollments -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-xl sm:text-2xl font-bold text-primary">Recent Enrollments</h2>

            <div class="space-y-4">
                @forelse($recentEnrollments as $enrollment)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-base-200 rounded-lg">
                        <div class="min-w-0">
                            <h3 class="font-medium text-sm sm:text-base truncate">{{ $enrollment->name }}</h3>
                            <p class="text-xs sm:text-sm text-gray-600 truncate">
                                {{ $enrollment->academicYear->name }}
                            </p>
                        </div>

                        <div class="mt-3 sm:mt-0 flex items-center gap-3">
                            <span class="badge badge-{{ $enrollment->status === 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                            <p class="text-xs sm:text-sm text-gray-500">
                                {{ $enrollment->enrollees->count() }} enrollees
                            </p>

                            <a href="{{ route('registrar.enrollments.show', $enrollment->id ?? 0) }}"
                               class="btn btn-ghost btn-xs ml-2 hidden sm:inline-flex">
                                View
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-6">
                        <i class="fi fi-rr-info text-2xl"></i>
                        <p class="mt-2">No recent enrollments</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard.registrar.base>
