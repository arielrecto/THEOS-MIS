<x-dashboard.hr.base>
    <div class="container mx-auto px-4 sm:px-6 py-6 max-w-5xl">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">HR Reports</h1>
                    <p class="text-sm sm:text-base text-gray-600">View and generate various HR reports</p>
                </div>
            </div>
        </div>

        <!-- Report Categories -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Leave Report -->
            <div class="flex flex-col p-4 sm:p-6 bg-white rounded-lg shadow-sm h-full">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="p-3 rounded-lg bg-accent/10 flex-none">
                        <i class="text-2xl sm:text-3xl fi fi-rr-calendar-clock text-accent"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-base sm:text-lg font-semibold truncate">Leave Report</h2>
                        <p class="text-xs sm:text-sm text-gray-600">Employee leave management data</p>
                    </div>
                </div>

                <div class="flex-1 mt-4 text-sm text-gray-600">
                    <ul class="space-y-2">
                        <li class="flex gap-2 items-start">
                            <i class="fi fi-rr-check text-success mt-0.5"></i>
                            <span class="truncate">Leave usage statistics</span>
                        </li>
                        <li class="flex gap-2 items-start">
                            <i class="fi fi-rr-check text-success mt-0.5"></i>
                            <span class="truncate">Leave balance tracking</span>
                        </li>
                        <li class="flex gap-2 items-start">
                            <i class="fi fi-rr-check text-success mt-0.5"></i>
                            <span class="truncate">Leave type analysis</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-4">
                    <a href="{{ route('hr.reports.leave') }}" class="gap-2 btn btn-accent w-full sm:w-auto text-center">
                        <i class="fi fi-rr-file-chart-line"></i>
                        <span class="ml-1">Generate Report</span>
                    </a>
                </div>
            </div>

            <!-- Recruitment Report -->
            <div class="flex flex-col p-4 sm:p-6 bg-white rounded-lg shadow-sm h-full">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="p-3 rounded-lg bg-success/10 flex-none">
                        <i class="text-2xl sm:text-3xl fi fi-rr-users text-success"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-base sm:text-lg font-semibold truncate">Recruitment Report</h2>
                        <p class="text-xs sm:text-sm text-gray-600">Hiring and recruitment metrics</p>
                    </div>
                </div>

                <div class="flex-1 mt-4 text-sm text-gray-600">
                    <ul class="space-y-2">
                        <li class="flex gap-2 items-start">
                            <i class="fi fi-rr-check text-success mt-0.5"></i>
                            <span class="truncate">Application statistics</span>
                        </li>
                        <li class="flex gap-2 items-start">
                            <i class="fi fi-rr-check text-success mt-0.5"></i>
                            <span class="truncate">Hiring progress tracking</span>
                        </li>
                        <li class="flex gap-2 items-start">
                            <i class="fi fi-rr-check text-success mt-0.5"></i>
                            <span class="truncate">Position fill rates</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-4">
                    <a href="{{ route('hr.reports.recruitment') }}" class="gap-2 btn btn-success w-full sm:w-auto text-center">
                        <i class="fi fi-rr-file-chart-line"></i>
                        <span class="ml-1">Generate Report</span>
                    </a>
                </div>
            </div>

            <!-- (Optional) Additional report card placeholder to keep grid balanced on larger screens -->
            <div class="flex flex-col p-4 sm:p-6 bg-white rounded-lg shadow-sm h-full">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="p-3 rounded-lg bg-primary/10 flex-none">
                        <i class="text-2xl sm:text-3xl fi fi-rr-analytics text-primary"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-base sm:text-lg font-semibold truncate">Other Reports</h2>
                        <p class="text-xs sm:text-sm text-gray-600">Additional HR reports</p>
                    </div>
                </div>

                <div class="flex-1 mt-4 text-sm text-gray-600">
                    <ul class="space-y-2">
                        <li class="flex gap-2 items-start">
                            <i class="fi fi-rr-check text-success mt-0.5"></i>
                            <span class="truncate">Attendance (coming soon)</span>
                        </li>
                        <li class="flex gap-2 items-start">
                            <i class="fi fi-rr-check text-success mt-0.5"></i>
                            <span class="truncate">Performance summaries</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-4">
                    <a href="#" class="gap-2 btn btn-ghost w-full sm:w-auto text-center" aria-disabled="true">
                        <i class="fi fi-rr-file-chart-line"></i>
                        <span class="ml-1">Generate</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
