@php
    $reports = [
        [
            'title' => 'Leave Report',
            'subtitle' => 'Employee leave management data',
            'icon' => 'fi-rr-calendar-clock',
            'route' => 'hr.reports.leave',
            'card' => 'bg-blue-50/90',
            'chip' => 'bg-blue-100 text-blue-600',
            'button' => 'bg-blue-600 hover:bg-blue-700',
            'features' => ['Leave request statistics', 'Approval status tracking', 'Leave type & duration details'],
        ],
        [
            'title' => 'Recruitment Report',
            'subtitle' => 'Hiring and recruitment metrics',
            'icon' => 'fi-rr-users',
            'route' => 'hr.reports.recruitment',
            'card' => 'bg-emerald-50/90',
            'chip' => 'bg-emerald-100 text-emerald-600',
            'button' => 'bg-emerald-500 hover:bg-emerald-600',
            'features' => ['Application statistics', 'Hiring progress tracking', 'Open vs. closed positions'],
        ],
        [
            'title' => 'Attendance Report',
            'subtitle' => 'Daily attendance and punctuality',
            'icon' => 'fi-rr-clock',
            'route' => 'hr.reports.attendance',
            'card' => 'bg-indigo-50/90',
            'chip' => 'bg-indigo-100 text-indigo-600',
            'button' => 'bg-indigo-500 hover:bg-indigo-600',
            'features' => ['Attendance records by date range', 'Late arrivals tracking', 'On-time rate & average hours'],
        ],
        [
            'title' => 'Payroll Report',
            'subtitle' => 'Salary and payroll summary',
            'icon' => 'fi-rr-usd-circle',
            'route' => 'hr.reports.payroll',
            'card' => 'bg-orange-50/90',
            'chip' => 'bg-orange-100 text-orange-600',
            'button' => 'bg-orange-500 hover:bg-orange-600',
            'features' => ['Salary totals by department', 'Employee salary listing', 'Missing salary records'],
        ],
    ];

    $summary = [
        ['label' => 'Total Employees', 'value' => $stats['total_employees'], 'icon' => 'fi-rr-graduation-cap'],
        ['label' => 'On Leave Today', 'value' => $stats['on_leave_today'], 'icon' => 'fi-rr-calendar-day'],
        ['label' => 'Open Roles', 'value' => $stats['open_roles'], 'icon' => 'fi-rr-user-add'],
        [
            'label' => 'Avg. Hiring Time',
            'value' => $stats['avg_hiring_days'] === null
                ? '—'
                : $stats['avg_hiring_days'] . ' ' . Str::plural('day', $stats['avg_hiring_days']),
            'icon' => 'fi-rr-chart-line-up',
        ],
    ];
@endphp

<x-dashboard.hr.base>
    <div class="overflow-hidden px-4 pt-5 pb-24 bg-bottom bg-no-repeat bg-cover rounded-2xl sm:px-6 sm:pt-6 sm:pb-32 lg:px-10"
        style="background-image: url('{{ asset('bg5.JPEG') }}')">

        <!-- Summary strip -->
        <div class="grid grid-cols-2 gap-y-4 p-4 mx-auto max-w-4xl rounded-2xl border shadow-lg backdrop-blur-sm lg:grid-cols-4 sm:p-5 border-white/70 bg-white/85">
            @foreach ($summary as $item)
                <div class="flex gap-3 items-center px-2 min-w-0 lg:justify-center">
                    <i class="flex text-2xl fi {{ $item['icon'] }} text-slate-700 shrink-0"></i>
                    <div class="min-w-0">
                        <p class="text-xs truncate text-slate-500">{{ $item['label'] }}</p>
                        <p class="text-lg font-bold leading-tight text-slate-800">{{ $item['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Heading -->
        <div class="mx-auto mt-8 max-w-4xl">
            <h1 class="text-2xl font-bold text-slate-800 sm:text-3xl">HR Reports</h1>
            <p class="mt-1 text-sm text-slate-600 sm:text-base">View and generate various HR reports</p>
        </div>

        <!-- Report cards -->
        <div class="grid grid-cols-1 gap-5 mx-auto mt-5 max-w-4xl md:grid-cols-2">
            @foreach ($reports as $report)
                <div class="flex flex-col p-5 rounded-2xl border shadow-lg backdrop-blur-sm sm:p-6 border-white/70 {{ $report['card'] }}">
                    <div class="flex gap-4 items-center">
                        <span class="flex justify-center items-center w-12 h-12 text-2xl rounded-xl shrink-0 {{ $report['chip'] }}">
                            <i class="flex fi {{ $report['icon'] }}"></i>
                        </span>
                        <div class="min-w-0">
                            <h2 class="text-lg font-semibold text-slate-800">{{ $report['title'] }}</h2>
                            <p class="text-sm text-slate-600">{{ $report['subtitle'] }}</p>
                        </div>
                    </div>

                    <ul class="flex-1 mt-4 space-y-2 text-sm text-slate-700">
                        @foreach ($report['features'] as $feature)
                            <li class="flex gap-2 items-center">
                                <i class="flex text-emerald-500 fi fi-rr-check-circle shrink-0"></i>
                                <span>{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-5">
                        <a href="{{ route($report['route']) }}"
                            class="inline-flex gap-2 justify-center items-center px-4 py-2 w-full text-sm font-medium text-white rounded-lg shadow-sm transition sm:w-auto {{ $report['button'] }}">
                            <i class="flex fi fi-rr-file-chart-line"></i>
                            Generate Report
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dashboard.hr.base>
