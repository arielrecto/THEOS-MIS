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

    <div class="grid grid-cols-3 gap-5">
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

    <div class="grid grid-cols-2 gap-6 mt-6">
        <!-- Enrollment Statistics Chart -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-2xl font-bold text-primary">Enrollment Statistics</h2>
            <div x-data="{
                stats: {{ json_encode($enrollmentStats) }},
                init() {
                    const options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Enrollees',
                            data: this.stats.map(item => item.count)
                        }],
                        xaxis: {
                            categories: this.stats.map(item => item.name)
                        }
                    };
                    const chart = new ApexCharts(this.$refs.chart, options);
                    chart.render();
                }
            }">
                <div x-ref="chart"></div>
            </div>
        </div>

        <!-- Recent Enrollments -->
        <div class="p-6 rounded-lg shadow-lg bg-base-100">
            <h2 class="mb-4 text-2xl font-bold text-primary">Recent Enrollments</h2>
            <div class="space-y-4">
                @forelse($recentEnrollments as $enrollment)
                    <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                        <div>
                            <h3 class="font-medium">{{ $enrollment->name }}</h3>
                            <p class="text-sm text-gray-600">
                                {{ $enrollment->academicYear->name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-{{ $enrollment->status === 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $enrollment->enrollees->count() }} enrollees
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500">
                        <i class="fi fi-rr-info text-2xl"></i>
                        <p class="mt-2">No recent enrollments</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard.registrar.base>
