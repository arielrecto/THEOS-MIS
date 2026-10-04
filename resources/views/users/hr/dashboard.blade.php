@php
    use App\Enums\LeaveStatus;

    $monthStart = $today->copy()->startOfMonth();
    $leadingBlanks = $monthStart->dayOfWeek;
    $daysInMonth = $today->daysInMonth;

    $upcomingBirthdays = $birthdays->filter(fn($employee) => $employee->date_of_birth->day >= $today->day);
    $birthdayPreview = $birthdays->take(3);

    $formatRange = function ($leave) {
        $start = \Illuminate\Support\Carbon::parse($leave->start_date);
        $end = \Illuminate\Support\Carbon::parse($leave->end_date);
        if ($start->isSameDay($end)) {
            return $start->format('M j');
        }
        return $start->isSameMonth($end)
            ? $start->format('M j') . '–' . $end->format('j')
            : $start->format('M j') . ' – ' . $end->format('M j');
    };
@endphp

<x-dashboard.hr.base>
    <div class="overflow-hidden px-4 py-5 bg-center bg-no-repeat bg-cover rounded-2xl sm:px-6 sm:py-6 lg:px-8"
        style="background-image: url('{{ asset('bg4.JPEG') }}')">

        <!-- Heading -->
        <div>
            <h1 class="text-2xl font-bold text-slate-800 sm:text-3xl">HR Dashboard</h1>
            <p class="mt-1 text-sm text-slate-600">Welcome back, {{ auth()->user()->name }}</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 gap-4 mt-5 sm:grid-cols-3">
            <div class="p-5 rounded-2xl border shadow-md backdrop-blur-sm border-white/70 bg-white/90">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Total Employees</p>
                        <p class="mt-1 text-3xl font-bold text-blue-600">{{ $totalEmployees }}</p>
                    </div>
                    <span class="flex justify-center items-center w-11 h-11 text-xl text-blue-600 bg-blue-100 rounded-full">
                        <i class="flex fi fi-rr-users"></i>
                    </span>
                </div>
                <p class="mt-3 text-xs text-slate-500">Active roster</p>
            </div>

            <div class="p-5 rounded-2xl border shadow-md backdrop-blur-sm border-white/70 bg-white/90">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-600">New Hires</p>
                        <p class="mt-1 text-3xl font-bold text-emerald-600">{{ $newHires }}</p>
                    </div>
                    <span class="flex justify-center items-center w-11 h-11 text-xl text-emerald-600 bg-emerald-100 rounded-full">
                        <i class="flex fi fi-rr-user-add"></i>
                    </span>
                </div>
                <p class="mt-3 text-xs text-slate-500">Last 30 days</p>
            </div>

            <div class="p-5 rounded-2xl border shadow-md backdrop-blur-sm border-white/70 bg-white/90">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Pending Leaves</p>
                        <p class="mt-1 text-3xl font-bold text-amber-500">{{ $pendingLeaves }}</p>
                    </div>
                    <span class="flex justify-center items-center w-11 h-11 text-xl text-amber-600 bg-amber-100 rounded-full">
                        <i class="flex fi fi-rr-calendar"></i>
                    </span>
                </div>
                <p class="mt-3 text-xs text-slate-500">Awaiting approval</p>
            </div>
        </div>

        <!-- Department distribution & recent activities -->
        <div class="grid grid-cols-1 gap-4 mt-4 lg:grid-cols-2">
            <div class="p-5 rounded-2xl border shadow-md backdrop-blur-sm border-white/70 bg-white/90">
                <h2 class="font-semibold text-slate-800">Department Distribution</h2>
                <div class="mt-4 space-y-4">
                    @forelse ($departmentDistribution as $dept)
                        <div>
                            <div class="flex justify-between mb-1.5 text-sm">
                                <span class="font-medium text-slate-700">{{ $dept['name'] }}</span>
                                <span class="text-slate-500">{{ $dept['count'] }} · {{ $dept['percentage'] }}%</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-slate-100">
                                <div class="h-2 bg-blue-500 rounded-full" style="width: {{ $dept['percentage'] }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No employees are assigned to a department yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="p-5 rounded-2xl border shadow-md backdrop-blur-sm border-white/70 bg-white/90">
                <h2 class="font-semibold text-slate-800">Recent Activities</h2>
                <div class="mt-4 space-y-4">
                    @forelse ($recentActivities as $activity)
                        <div class="flex gap-3 items-start">
                            <span @class([
                                'flex justify-center items-center w-8 h-8 rounded-full shrink-0',
                                'bg-emerald-100 text-emerald-600' => $activity['type'] === 'new_hire',
                                'bg-blue-100 text-blue-600' => $activity['type'] !== 'new_hire',
                            ])>
                                <i class="flex fi {{ $activity['type'] === 'new_hire' ? 'fi-rr-user-add' : 'fi-rr-document' }}"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-slate-700">{{ $activity['message'] }}</p>
                                <p class="text-xs text-slate-500">{{ $activity['date']->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No recent activity.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Calendar, upcoming leaves, birthdays -->
        <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2 xl:grid-cols-3">
            <!-- Calendar -->
            <div class="p-5 rounded-2xl border shadow-md backdrop-blur-sm border-white/70 bg-white/90">
                <div class="flex gap-3 items-center">
                    <span class="flex justify-center items-center w-9 h-9 text-blue-600 bg-blue-100 rounded-lg">
                        <i class="flex fi fi-rr-calendar"></i>
                    </span>
                    <div>
                        <h2 class="font-semibold text-slate-800">Calendar</h2>
                        <p class="text-xs text-slate-500">{{ $today->format('F Y') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-7 gap-y-1 mt-4 text-xs text-center">
                    @foreach (['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'] as $weekday)
                        <span class="py-1 font-semibold text-slate-500">{{ $weekday }}</span>
                    @endforeach
                    @for ($i = 0; $i < $leadingBlanks; $i++)
                        <span></span>
                    @endfor
                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        @php $marks = $calendarMarks[$day] ?? []; @endphp
                        <span class="flex flex-col items-center py-0.5">
                            <span @class([
                                'flex justify-center items-center w-7 h-7 rounded-full',
                                'bg-blue-600 font-semibold text-white' => $day === $today->day,
                                'text-slate-700' => $day !== $today->day,
                            ])>{{ $day }}</span>
                            <span class="flex gap-0.5 h-1.5">
                                @isset($marks['leave'])
                                    <span class="w-1.5 h-1.5 bg-amber-400 rounded-full"></span>
                                @endisset
                                @isset($marks['birthday'])
                                    <span class="w-1.5 h-1.5 bg-pink-400 rounded-full"></span>
                                @endisset
                            </span>
                        </span>
                    @endfor
                </div>

                <div class="flex gap-4 pt-3 mt-3 text-xs border-t border-slate-100 text-slate-500">
                    <span class="flex gap-1.5 items-center"><span class="w-2 h-2 bg-amber-400 rounded-full"></span>Leave</span>
                    <span class="flex gap-1.5 items-center"><span class="w-2 h-2 bg-pink-400 rounded-full"></span>Birthday</span>
                </div>
            </div>

            <!-- Upcoming leaves -->
            <div class="p-5 rounded-2xl border shadow-md backdrop-blur-sm border-white/70 bg-white/90">
                <div class="flex gap-3 justify-between items-center">
                    <div class="flex gap-3 items-center">
                        <span class="flex justify-center items-center w-9 h-9 text-amber-600 bg-amber-100 rounded-lg">
                            <i class="flex fi fi-rr-calendar-clock"></i>
                        </span>
                        <h2 class="font-semibold text-slate-800">Upcoming Leaves</h2>
                    </div>
                    <a href="{{ route('hr.leaves.index') }}" class="text-xs font-medium text-blue-600 hover:underline">View all</a>
                </div>

                <ul class="mt-4 space-y-3">
                    @forelse ($upcomingLeaves as $leave)
                        <li class="flex gap-3 items-start">
                            <span @class([
                                'mt-1.5 w-2 h-2 rounded-full shrink-0',
                                'bg-emerald-500' => $leave->status === LeaveStatus::APPROVED->value,
                                'bg-amber-400' => $leave->status !== LeaveStatus::APPROVED->value,
                            ])></span>
                            <div class="min-w-0">
                                <p class="text-sm font-medium truncate text-slate-700">
                                    {{ $leave->employee->first_name }} {{ $leave->employee->last_name }}
                                </p>
                                <p class="text-xs text-slate-500">
                                    {{ ucfirst($leave->leave_type) }} — {{ $formatRange($leave) }}
                                    <span class="capitalize">· {{ $leave->status }}</span>
                                </p>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">No upcoming leaves.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Birthdays -->
            <div class="p-5 rounded-2xl border shadow-md backdrop-blur-sm md:col-span-2 xl:col-span-1 border-white/70 bg-white/90">
                <div class="flex gap-3 items-center">
                    <span class="flex justify-center items-center w-9 h-9 text-pink-600 bg-pink-100 rounded-lg">
                        <i class="flex fi fi-rr-cake-birthday"></i>
                    </span>
                    <div>
                        <h2 class="font-semibold text-slate-800">Employee Birthdays</h2>
                        <p class="text-xs text-slate-500">{{ $today->format('F') }}</p>
                    </div>
                </div>

                <ul class="mt-4 space-y-3">
                    @forelse ($birthdayPreview as $employee)
                        @php $isToday = $employee->date_of_birth->day === $today->day; @endphp
                        <li class="flex gap-3 items-center">
                            <span class="flex justify-center items-center w-8 h-8 text-pink-500 bg-pink-50 rounded-lg shrink-0">
                                <i class="flex fi fi-rr-gift"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-medium truncate text-slate-700">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                                <p class="text-xs {{ $isToday ? 'font-semibold text-pink-600' : 'text-slate-500' }}">
                                    {{ $isToday ? 'Today' : $employee->date_of_birth->format('M j') }}
                                </p>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">No birthdays this month.</li>
                    @endforelse
                </ul>

                @if ($birthdays->count() > $birthdayPreview->count())
                    <p class="px-3 py-2 mt-3 text-xs text-center rounded-lg bg-slate-50 text-slate-500">
                        +{{ $birthdays->count() - $birthdayPreview->count() }} more this month
                    </p>
                @elseif ($birthdays->isNotEmpty() && $upcomingBirthdays->isEmpty())
                    <p class="px-3 py-2 mt-3 text-xs text-center rounded-lg bg-slate-50 text-slate-500">
                        All of this month's birthdays have passed
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
