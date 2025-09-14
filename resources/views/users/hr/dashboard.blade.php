<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">HR Dashboard</h1>
            <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}</p>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Employees -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Employees</p>
                        <p class="text-2xl font-bold text-accent">{{ $totalEmployees }}</p>
                    </div>
                    <div class="p-3 bg-accent/10 rounded-full">
                        <i class="fi fi-rr-users text-2xl text-accent"></i>
                    </div>
                </div>
            </div>

            <!-- New Hires -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">New Hires</p>
                        <p class="text-2xl font-bold text-green-600">{{ $newHires }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fi fi-rr-user-add text-2xl text-green-600"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    Last 30 days
                </div>
            </div>

            <!-- Leave Requests -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending Leaves</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $pendingLeaves }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fi fi-rr-calendar text-2xl text-yellow-600"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    Awaiting approval
                </div>
            </div>

            <!-- Today's Attendance -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Present Today</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $attendanceAnalytics['present'] }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fi fi-rr-check-circle text-2xl text-blue-600"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    {{ $attendanceAnalytics['late'] }} came late
                </div>
            </div>
        </div>

        <!-- Department Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Department Distribution -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Department Distribution</h2>
                <div class="space-y-4">
                    @foreach($departmentDistribution as $dept)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium">{{ $dept['name'] }}</span>
                                <span class="text-sm text-gray-600">{{ $dept['percentage'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-accent h-2 rounded-full" style="width: {{ $dept['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h2>
                <div class="space-y-4">
                    @foreach($recentActivities as $activity)
                        <div class="flex items-start gap-4">
                            <div class="p-2 rounded-full {{ $activity['type'] === 'new_hire' ? 'bg-green-100' : 'bg-blue-100' }}">
                                <i class="fi {{ $activity['type'] === 'new_hire' ? 'fi-rr-user-add text-green-600' : 'fi-rr-document text-blue-600' }}"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $activity['message'] }}</p>
                                <p class="text-xs text-gray-500">{{ $activity['date']->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
