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
                        <p class="text-2xl font-bold text-accent">156</p>
                    </div>
                    <div class="p-3 bg-accent/10 rounded-full">
                        <i class="fi fi-rr-users text-2xl text-accent"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    <span class="text-green-500">
                        <i class="fi fi-rr-arrow-up"></i> 12%
                    </span>
                    vs last month
                </div>
            </div>

            <!-- New Hires -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">New Hires</p>
                        <p class="text-2xl font-bold text-green-600">8</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fi fi-rr-user-add text-2xl text-green-600"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    This month
                </div>
            </div>

            <!-- Resignations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Resignations</p>
                        <p class="text-2xl font-bold text-red-600">2</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fi fi-rr-user-remove text-2xl text-red-600"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    This month
                </div>
            </div>

            <!-- Leave Requests -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Leave Requests</p>
                        <p class="text-2xl font-bold text-yellow-600">5</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fi fi-rr-calendar text-2xl text-yellow-600"></i>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-500">
                    Pending approval
                </div>
            </div>
        </div>

        <!-- Department Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Department Distribution -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Department Distribution</h2>
                <div class="space-y-4">
                    <!-- Teaching Staff -->
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium">Teaching Staff</span>
                            <span class="text-sm text-gray-600">65%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-accent h-2 rounded-full" style="width: 65%"></div>
                        </div>
                    </div>

                    <!-- Administrative -->
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium">Administrative</span>
                            <span class="text-sm text-gray-600">20%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-accent h-2 rounded-full" style="width: 20%"></div>
                        </div>
                    </div>

                    <!-- Support Staff -->
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium">Support Staff</span>
                            <span class="text-sm text-gray-600">15%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-accent h-2 rounded-full" style="width: 15%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-green-100 rounded-full">
                            <i class="fi fi-rr-user-add text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">New employee onboarded</p>
                            <p class="text-xs text-gray-500">Today at 9:30 AM</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-blue-100 rounded-full">
                            <i class="fi fi-rr-document text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Leave request approved</p>
                            <p class="text-xs text-gray-500">Yesterday at 4:15 PM</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-yellow-100 rounded-full">
                            <i class="fi fi-rr-calendar text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Performance review scheduled</p>
                            <p class="text-xs text-gray-500">March 23, 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
