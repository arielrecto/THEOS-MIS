<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">HR Reports</h1>
                    <p class="text-gray-600">View and generate various HR reports</p>
                </div>
            </div>
        </div>

        <!-- Report Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Attendance Report -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex flex-col h-full">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-primary/10 rounded-lg">
                            <i class="fi fi-rr-time-check text-primary text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">Attendance Report</h2>
                            <p class="text-sm text-gray-600">Employee attendance and time logs</p>
                        </div>
                    </div>

                    <div class="space-y-4 flex-grow">
                        <div class="text-sm text-gray-600">
                            <ul class="space-y-2">
                                <li class="flex items-center gap-2">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Daily attendance summaries
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Late arrival tracking
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Work hour analysis
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('hr.reports.attendance') }}" class="btn btn-primary w-full gap-2">
                            <i class="fi fi-rr-file-chart-line"></i>
                            Generate Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Leave Report -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex flex-col h-full">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-accent/10 rounded-lg">
                            <i class="fi fi-rr-calendar-clock text-accent text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">Leave Report</h2>
                            <p class="text-sm text-gray-600">Employee leave management data</p>
                        </div>
                    </div>

                    <div class="space-y-4 flex-grow">
                        <div class="text-sm text-gray-600">
                            <ul class="space-y-2">
                                <li class="flex items-center gap-2">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Leave usage statistics
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Leave balance tracking
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Leave type analysis
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('hr.reports.leave') }}" class="btn btn-accent w-full gap-2">
                            <i class="fi fi-rr-file-chart-line"></i>
                            Generate Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recruitment Report -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex flex-col h-full">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-success/10 rounded-lg">
                            <i class="fi fi-rr-users text-success text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">Recruitment Report</h2>
                            <p class="text-sm text-gray-600">Hiring and recruitment metrics</p>
                        </div>
                    </div>

                    <div class="space-y-4 flex-grow">
                        <div class="text-sm text-gray-600">
                            <ul class="space-y-2">
                                <li class="flex items-center gap-2">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Application statistics
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Hiring progress tracking
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Position fill rates
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('hr.reports.recruitment') }}" class="btn btn-success w-full gap-2">
                            <i class="fi fi-rr-file-chart-line"></i>
                            Generate Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
