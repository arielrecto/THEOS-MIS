<x-dashboard.admin.base>
    <x-dashboard.page-title
        :title="$academicYear->name"
        :back_url="route('admin.academic-year.index')">
        <x-slot name="other">
            <a href="{{ route('admin.academic-year.edit', $academicYear) }}"
               class="btn btn-accent btn-sm gap-2  text-white">
                <i class="fi fi-rr-edit"></i>
                <span class="hidden sm:inline">Edit</span>
            </a>
        </x-slot>
    </x-dashboard.page-title>

    <div class="space-y-6">

        {{-- Meta row: date range + status --}}
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fi fi-rr-calendar text-accent"></i>
                <span>
                    {{ \Carbon\Carbon::parse($academicYear->start_date)->format('F d, Y') }}
                    &mdash;
                    {{ \Carbon\Carbon::parse($academicYear->end_date)->format('F d, Y') }}
                </span>
            </div>
            <span class="badge badge-lg {{ $academicYear->status === 'active' ? 'badge-success' : 'badge-ghost' }}">
                {{ ucfirst($academicYear->status) }}
            </span>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

            {{-- Enrollment --}}
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <div class="flex items-center gap-4 mb-5">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-accent/10">
                        <i class="fi fi-rr-users text-2xl text-accent"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-700">Enrollment</h3>
                </div>
                <div class="space-y-3 divide-y divide-base-200">
                    <div class="flex justify-between items-center pb-3">
                        <span class="text-sm text-gray-500">Total Enrollees</span>
                        <span class="text-xl font-bold text-gray-800">{{ $academicYear->enrollees->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm text-gray-500">Pending</span>
                        <span class="badge badge-warning">{{ $academicYear->enrollees->where('status', 'pending')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-3">
                        <span class="text-sm text-gray-500">Approved</span>
                        <span class="badge badge-success">{{ $academicYear->enrollees->where('status', 'approved')->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- Academic Records --}}
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <div class="flex items-center gap-4 mb-5">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-secondary/10">
                        <i class="fi fi-rr-graduation-cap text-2xl text-secondary"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-700">Academic Records</h3>
                </div>
                @php $passingRate = $totalRecords > 0 ? ($passingCount / $totalRecords) * 100 : 0; @endphp
                <div class="space-y-3 divide-y divide-base-200">
                    <div class="flex justify-between items-center pb-3">
                        <span class="text-sm text-gray-500">Total Records</span>
                        <span class="text-xl font-bold text-gray-800">{{ $totalRecords }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm text-gray-500">Average Grade</span>
                        <span class="font-semibold text-gray-700">{{ number_format($academicYear->academicRecords->avg('average'), 2) }}%</span>
                    </div>
                    <div class="flex justify-between items-center pt-3">
                        <span class="text-sm text-gray-500">Passing Rate</span>
                        <span class="badge {{ $passingRate >= 75 ? 'badge-success' : 'badge-error' }}">
                            {{ number_format($passingRate, 2) }}%
                        </span>
                    </div>
                </div>
            </div>

            {{-- Enrollment Periods --}}
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <div class="flex items-center gap-4 mb-5">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-primary/10">
                        <i class="fi fi-rr-calendar text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-700">Enrollment Periods</h3>
                </div>
                <div class="space-y-3 divide-y divide-base-200">
                    <div class="flex justify-between items-center pb-3">
                        <span class="text-sm text-gray-500">Total Periods</span>
                        <span class="text-xl font-bold text-gray-800">{{ $academicYear->enrollments->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm text-gray-500">Active</span>
                        <span class="badge badge-success">{{ $ongoingPeriods }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-3">
                        <span class="text-sm text-gray-500">Completed</span>
                        <span class="badge badge-ghost">{{ $completedPeriods }}</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Grade-level Analysis --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Enrollment by Grade Level --}}
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <div class="flex items-center gap-3 mb-5">
                    <i class="fi fi-rr-users text-accent text-lg"></i>
                    <h3 class="text-base font-bold text-accent">Enrollment by Grade Level</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full text-sm">
                        <thead>
                            <tr>
                                <th>Grade Level</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">Approved</th>
                                <th class="text-right">Pending</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrollmentsByGradeLevel as $gradeLevel => $stats)
                                <tr>
                                    <td class="font-medium">{{ $gradeLevel }}</td>
                                    <td class="text-right font-bold">{{ $stats['total'] }}</td>
                                    <td class="text-right">
                                        <span class="badge badge-success badge-sm">{{ $stats['approved'] }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-warning badge-sm">{{ $stats['pending'] }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-gray-400">
                                        <i class="fi fi-rr-inbox block text-2xl mb-2"></i>
                                        No enrollment data available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Academic Performance by Grade Level --}}
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <div class="flex items-center gap-3 mb-5">
                    <i class="fi fi-rr-graduation-cap text-accent text-lg"></i>
                    <h3 class="text-base font-bold text-accent">Academic Performance by Grade Level</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full text-sm">
                        <thead>
                            <tr>
                                <th>Grade Level</th>
                                <th class="text-right">Students</th>
                                <th class="text-right">Avg Grade</th>
                                <th class="text-right">Passing</th>
                                <th class="text-right">Failing</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($performanceByGradeLevel as $gradeLevel => $stats)
                                <tr>
                                    <td class="font-medium">{{ $gradeLevel }}</td>
                                    <td class="text-right font-bold">{{ $stats['total'] }}</td>
                                    <td class="text-right font-semibold">{{ number_format($stats['average'], 2) }}%</td>
                                    <td class="text-right">
                                        <span class="badge badge-success badge-sm">{{ $stats['passing'] }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-error badge-sm">{{ $stats['failing'] }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-gray-400">
                                        <i class="fi fi-rr-inbox block text-2xl mb-2"></i>
                                        No performance data available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-dashboard.admin.base>
