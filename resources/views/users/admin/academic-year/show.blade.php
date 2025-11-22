<x-dashboard.admin.base>
    <div class="container mx-auto px-4 sm:px-6 py-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 truncate">{{ $academicYear->name }}</h1>
                <p class="text-sm text-gray-600 mt-1 truncate">
                    {{ \Carbon\Carbon::parse($academicYear->start_date)->format('F d, Y') }} -
                    {{ \Carbon\Carbon::parse($academicYear->end_date)->format('F d, Y') }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.academic-year.index') }}"
                   class="btn btn-ghost gap-2 btn-sm">
                    <i class="fi fi-rr-arrow-left"></i>
                    <span class="hidden sm:inline">Back</span>
                </a>
                <a href="{{ route('admin.academic-year.edit', $academicYear) }}"
                   class="btn btn-accent gap-2 btn-sm">
                    <i class="fi fi-rr-edit"></i>
                    <span class="hidden sm:inline">Edit</span>
                </a>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            <span class="badge badge-lg {{ $academicYear->status === 'active' ? 'badge-success' : 'badge-ghost' }}">
                {{ ucfirst($academicYear->status) }}
            </span>
        </div>

        <!-- Statistics Grid (responsive) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold">Enrollment</h3>
                    <i class="fi fi-rr-users text-lg text-accent"></i>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Enrollees</span>
                        <span class="text-lg font-bold">{{ $academicYear->enrollees->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Pending</span>
                        <span class="text-lg text-warning">{{ $academicYear->enrollees->where('status','pending')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Approved</span>
                        <span class="text-lg text-success">{{ $academicYear->enrollees->where('status','approved')->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold">Academic Records</h3>
                    <i class="fi fi-rr-graduation-cap text-lg text-accent"></i>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Records</span>
                        <span class="text-lg font-bold">{{ $totalRecords }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Average Grade</span>
                        <span class="text-lg">{{ number_format($academicYear->academicRecords->avg('average'), 2) }}%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Passing Rate</span>
                        @php
                            $passingRate = $totalRecords > 0 ? ($passingCount / $totalRecords) * 100 : 0;
                        @endphp
                        <span class="text-lg {{ $passingRate >= 75 ? 'text-success' : 'text-error' }}">{{ number_format($passingRate, 2) }}%</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold">Enrollment Periods</h3>
                    <i class="fi fi-rr-calendar text-lg text-accent"></i>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Active Periods</span>
                        <span class="text-lg font-bold">{{ $ongoingPeriods }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Completed</span>
                        <span class="text-lg">{{ $completedPeriods }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Periods</span>
                        <span class="text-lg">{{ $academicYear->enrollments->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grade Level Analysis: stacked on small screens -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Enrollment by Grade Level -->
            <div class="bg-white rounded-lg shadow-sm p-4 overflow-x-auto">
                <h3 class="text-lg font-semibold mb-3">Enrollment by Grade Level</h3>
                <table class="table w-full">
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
                                <td class="max-w-xs truncate">{{ $gradeLevel }}</td>
                                <td class="text-right">{{ $stats['total'] }}</td>
                                <td class="text-right text-success">{{ $stats['approved'] }}</td>
                                <td class="text-right text-warning">{{ $stats['pending'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No enrollment data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Academic Performance by Grade Level -->
            <div class="bg-white rounded-lg shadow-sm p-4 overflow-x-auto">
                <h3 class="text-lg font-semibold mb-3">Academic Performance by Grade Level</h3>
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Grade Level</th>
                            <th class="text-right">Students</th>
                            <th class="text-right">Average Grade</th>
                            <th class="text-right">Passing</th>
                            <th class="text-right">Failing</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($performanceByGradeLevel as $gradeLevel => $stats)
                            <tr>
                                <td class="max-w-xs truncate">{{ $gradeLevel }}</td>
                                <td class="text-right">{{ $stats['total'] }}</td>
                                <td class="text-right">{{ number_format($stats['average'], 2) }}%</td>
                                <td class="text-right text-success">{{ $stats['passing'] }}</td>
                                <td class="text-right text-error">{{ $stats['failing'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No performance data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
