<x-dashboard.admin.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $academicYear->name }}</h1>
                <p class="text-gray-600">
                    {{ \Carbon\Carbon::parse($academicYear->start_date)->format('F d, Y') }} -
                    {{ \Carbon\Carbon::parse($academicYear->end_date)->format('F d, Y') }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.academic-year.index') }}"
                   class="btn btn-ghost gap-2">
                    <i class="fi fi-rr-arrow-left"></i>
                    Back
                </a>
                <a href="{{ route('admin.academic-year.edit', $academicYear) }}"
                   class="btn btn-accent gap-2">
                    <i class="fi fi-rr-edit"></i>
                    Edit
                </a>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            <span class="badge badge-lg {{ $academicYear->status === 'active' ? 'badge-success' : 'badge-ghost' }}">
                {{ ucfirst($academicYear->status) }}
            </span>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Enrollment Statistics -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Enrollment</h3>
                    <i class="fi fi-rr-users text-2xl text-accent"></i>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Enrollees</span>
                        <span class="text-2xl font-bold">{{ $academicYear->enrollees->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pending</span>
                        <span class="text-xl text-warning">
                            {{ $academicYear->enrollees->where('status', 'pending')->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Approved</span>
                        <span class="text-xl text-success">
                            {{ $academicYear->enrollees->where('status', 'approved')->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Academic Records -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Academic Records</h3>
                    <i class="fi fi-rr-graduation-cap text-2xl text-accent"></i>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Records</span>
                        <span class="text-2xl font-bold">{{ $totalRecords }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Average Grade</span>
                        <span class="text-xl">
                            {{ number_format($academicYear->academicRecords->avg('average'), 2) }}%
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Passing Rate</span>
                        @php
                            $passingRate = $totalRecords > 0 ? ($passingCount / $totalRecords) * 100 : 0;
                        @endphp
                        <span class="text-xl {{ $passingRate >= 75 ? 'text-success' : 'text-error' }}">
                            {{ number_format($passingRate, 2) }}%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Enrollment Periods -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Enrollment Periods</h3>
                    <i class="fi fi-rr-calendar text-2xl text-accent"></i>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Active Periods</span>
                        <span class="text-2xl font-bold">{{ $ongoingPeriods }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Completed</span>
                        <span class="text-xl">{{ $completedPeriods }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Periods</span>
                        <span class="text-xl">{{ $academicYear->enrollments->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grade Level Analysis -->
        <div class="grid grid-cols-1 gap-6">
            <!-- Enrollment by Grade Level -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Enrollment by Grade Level</h3>
                <div class="overflow-x-auto">
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
                                    <td>{{ $gradeLevel }}</td>
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
            </div>

            <!-- Academic Performance by Grade Level -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Academic Performance by Grade Level</h3>
                <div class="overflow-x-auto">
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
                                    <td>{{ $gradeLevel }}</td>
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
    </div>
</x-dashboard.admin.base>
