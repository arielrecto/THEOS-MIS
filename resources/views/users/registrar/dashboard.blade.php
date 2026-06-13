<x-dashboard.registrar.base>

    {{-- Academic Year Alert --}}
    <div class="mb-6">
        @if($currentAcademicYear)
            <div class="alert alert-info">
                <i class="fi fi-rr-info"></i>
                <span>Current Academic Year: <strong>{{ $currentAcademicYear->name }}</strong></span>
            </div>
        @else
            <div class="alert alert-warning">
                <i class="fi fi-rr-exclamation"></i>
                <span>No active academic year set</span>
            </div>
        @endif
    </div>

    {{-- Top Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
        <x-card-v1 icon="fi fi-rr-graduation-cap" label="Total Enrollments" :count="$counts['enrollments']" icon_color="blue-500" />
        <x-card-v1 icon="fi fi-rr-users" label="Total Students" :count="$counts['students']" icon_color="secondary" />
        <x-card-v1 icon="fi fi-rr-calendar" label="Academic Years" :count="$counts['academic_years']" icon_color="accent" />
    </div>

    {{-- Enrollee & Payment Summary --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Enrollment Summary --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2">
                    <i class="fi fi-rr-users text-accent text-lg"></i>
                    <h2 class="font-bold text-accent">Enrollee Summary</h2>
                    @if($currentAcademicYear)
                        <span class="badge badge-ghost badge-sm">{{ $currentAcademicYear->name }}</span>
                    @endif
                </div>
                <a href="{{ route('registrar.reports.enrollment') }}" class="btn btn-ghost btn-xs gap-1">
                    <i class="fi fi-rr-file-chart-line"></i> Report
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
                <div class="bg-base-200 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-gray-800">{{ $enrolleeCounts['total'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Total</p>
                </div>
                <div class="bg-success/10 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-success">{{ $enrolleeCounts['approved'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Approved</p>
                </div>
                <div class="bg-warning/10 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-warning">{{ $enrolleeCounts['pending'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Pending</p>
                </div>
                <div class="bg-error/10 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-error">{{ $enrolleeCounts['rejected'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Rejected</p>
                </div>
            </div>

            {{-- By Grade Level --}}
            @if($enrolleesByGrade->count())
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">By Grade Level</h3>
                <div class="space-y-2">
                    @foreach($enrolleesByGrade as $grade => $count)
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-600 w-20 shrink-0">{{ $grade }}</span>
                            <div class="flex-1 bg-base-200 rounded-full h-2">
                                <div class="bg-accent h-2 rounded-full"
                                     style="width: {{ $enrolleeCounts['total'] > 0 ? round(($count / $enrolleeCounts['total']) * 100) : 0 }}%">
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-gray-700 w-6 text-right">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-4">No enrollees yet for this school year.</p>
            @endif
        </div>

        {{-- Payment Summary --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2">
                    <i class="fi fi-rr-sack-dollar text-success text-lg"></i>
                    <h2 class="font-bold text-success">Payment Summary</h2>
                    @if($currentAcademicYear)
                        <span class="badge badge-ghost badge-sm">{{ $currentAcademicYear->name }}</span>
                    @endif
                </div>
                <a href="{{ route('registrar.reports.payment') }}" class="btn btn-ghost btn-xs gap-1">
                    <i class="fi fi-rr-file-chart-line"></i> Report
                </a>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-5">
                <div class="bg-success/10 rounded-lg p-4 col-span-2 text-center">
                    <p class="text-3xl font-bold text-success">₱{{ number_format($paymentStats['total_amount'], 2) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total Approved Amount</p>
                </div>
                <div class="bg-base-200 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-gray-800">{{ $paymentStats['total_count'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Transactions</p>
                </div>
                <div class="bg-warning/10 rounded-lg p-3 text-center">
                    <p class="text-2xl font-bold text-warning">{{ $paymentStats['pending_count'] }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Pending</p>
                </div>
            </div>

            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Recent Payments</h3>
            @if($recentPayments->count())
                <div class="space-y-2">
                    @foreach($recentPayments as $payment)
                        <div class="flex items-center justify-between p-2 rounded-lg bg-base-200 text-sm">
                            <div class="min-w-0">
                                <p class="font-medium text-gray-800 truncate">{{ $payment->user?->name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($payment->created_at)->format('M d, Y') }}
                                    · {{ $payment->paymentAccount?->name ?? $payment->payment_method ?? '—' }}
                                </p>
                            </div>
                            <div class="text-right shrink-0 ml-3">
                                <p class="font-bold text-gray-800">₱{{ number_format($payment->amount, 2) }}</p>
                                <span class="badge badge-xs {{ $payment->status === 'approved' ? 'badge-success' : ($payment->status === 'pending' ? 'badge-warning' : 'badge-error') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-4">No payment records yet.</p>
            @endif
        </div>

    </div>

    {{-- Chart & Recent Enrollments --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <h2 class="mb-4 text-xl font-bold text-blue-500">Enrollment Statistics</h2>
            <div x-data="{
                stats: {{ json_encode($enrollmentStats) }},
                chartInstance: null,
                getHeight() { return window.innerWidth < 640 ? 260 : 350; },
                init() {
                    const options = {
                        chart: { type: 'bar', height: this.getHeight(), toolbar: { show: false }, animations: { enabled: true } },
                        series: [{ name: 'Enrollees', data: this.stats.map(item => item.count) }],
                        xaxis: { categories: this.stats.map(item => item.name), labels: { rotate: -45 } },
                        responsive: [{ breakpoint: 640, options: { chart: { height: 260 }, plotOptions: { bar: { columnWidth: '60%' } } } }]
                    };
                    this.chartInstance = new ApexCharts(this.$refs.chart, options);
                    this.chartInstance.render();
                    window.addEventListener('resize', () => {
                        this.chartInstance.updateOptions({ chart: { height: this.getHeight() } }, false, true);
                    });
                }
            }" class="w-full">
                <div x-ref="chart" class="w-full"></div>
            </div>
        </div>

        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <h2 class="mb-4 text-xl font-bold text-blue-500">Recent Enrollments</h2>
            <div class="space-y-3">
                @forelse($recentEnrollments as $enrollment)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-base-200 rounded-lg">
                        <div class="min-w-0">
                            <h3 class="font-medium text-sm truncate">{{ $enrollment->name }}</h3>
                            <p class="text-xs text-gray-500 truncate">{{ $enrollment->academicYear->name }}</p>
                        </div>
                        <div class="mt-2 sm:mt-0 flex items-center gap-3 shrink-0">
                            <span class="badge badge-{{ $enrollment->status === 'active' ? 'success' : 'warning' }} badge-sm">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                            <p class="text-xs text-gray-500">{{ $enrollment->enrollees->count() }} enrollees</p>
                            <a href="{{ route('registrar.enrollments.show', $enrollment->id ?? 0) }}"
                               class="btn btn-ghost btn-xs hidden sm:inline-flex">View</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-8">
                        <i class="fi fi-rr-info block text-2xl mb-2"></i>
                        <p class="text-sm">No recent enrollments</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</x-dashboard.registrar.base>
