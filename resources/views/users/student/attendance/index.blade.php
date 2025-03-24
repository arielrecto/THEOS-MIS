<x-dashboard.student.base>
    <div class="container p-6 mx-auto">
        <!-- Header Section -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Attendance Records</h1>
                <p class="text-gray-600">Track your attendance history across all classes</p>
            </div>

            <a href="{{ route('student.attendances.scanner') }}"
               class="btn btn-accent gap-2">
                <i class="fi fi-rr-qrcode"></i>
                Scan QR Code
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Present Rate</p>
                        <p class="text-2xl font-bold text-accent">
                            {{ number_format($presentRate, 1) }}%
                        </p>
                    </div>
                    <div class="p-3 bg-accent/10 rounded-full">
                        <i class="text-2xl text-accent fi fi-rr-chart-line"></i>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Present</p>
                        <p class="text-2xl font-bold text-green-600">{{ $presentCount }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="text-2xl text-green-600 fi fi-rr-check"></i>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Absent</p>
                        <p class="text-2xl font-bold text-red-600">{{ $absentCount }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="text-2xl text-red-600 fi fi-rr-cross"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Log Table -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Attendance Log</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Time</th>
                            <th class="px-6 py-3">Subject</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Teacher</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    {{ $attendance->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $attendance->created_at->format('h:i A') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $attendance->attendance->classroom->subject->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        {{ $attendance->status === 'present' ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $attendance->attendance->classroom->teacher->name }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No attendance records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</x-dashboard.student.base>
