<x-dashboard.hr.base>
    <div class="container p-6 mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">HR Reports</h1>
                    <p class="text-gray-600">View and generate various HR reports</p>
                </div>
            </div>
        </div>

        <!-- Report Categories -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <!-- Attendance Report -->
            {{-- <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex flex-col h-full">
                    <div class="flex gap-4 items-center mb-4">
                        <div class="p-3 rounded-lg bg-primary/10">
                            <i class="text-2xl fi fi-rr-time-check text-primary"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">Attendance Report</h2>
                            <p class="text-sm text-gray-600">Employee attendance and time logs</p>
                        </div>
                    </div>

                    <div class="flex-grow space-y-4">
                        <div class="text-sm text-gray-600">
                            <ul class="space-y-2">
                                <li class="flex gap-2 items-center">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Daily attendance summaries
                                </li>
                                <li class="flex gap-2 items-center">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Late arrival tracking
                                </li>
                                <li class="flex gap-2 items-center">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Work hour analysis
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('hr.reports.attendance') }}" class="gap-2 w-full btn btn-primary">
                            <i class="fi fi-rr-file-chart-line"></i>
                            Generate Report
                        </a>
                    </div>
                </div>
            </div> --}}

            <!-- Leave Report -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex flex-col h-full">
                    <div class="flex gap-4 items-center mb-4">
                        <div class="p-3 rounded-lg bg-accent/10">
                            <i class="text-2xl fi fi-rr-calendar-clock text-accent"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">Leave Report</h2>
                            <p class="text-sm text-gray-600">Employee leave management data</p>
                        </div>
                    </div>

                    <div class="flex-grow space-y-4">
                        <div class="text-sm text-gray-600">
                            <ul class="space-y-2">
                                <li class="flex gap-2 items-center">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Leave usage statistics
                                </li>
                                <li class="flex gap-2 items-center">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Leave balance tracking
                                </li>
                                <li class="flex gap-2 items-center">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Leave type analysis
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('hr.reports.leave') }}" class="gap-2 w-full btn btn-accent">
                            <i class="fi fi-rr-file-chart-line"></i>
                            Generate Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recruitment Report -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex flex-col h-full">
                    <div class="flex gap-4 items-center mb-4">
                        <div class="p-3 rounded-lg bg-success/10">
                            <i class="text-2xl fi fi-rr-users text-success"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold">Recruitment Report</h2>
                            <p class="text-sm text-gray-600">Hiring and recruitment metrics</p>
                        </div>
                    </div>

                    <div class="flex-grow space-y-4">
                        <div class="text-sm text-gray-600">
                            <ul class="space-y-2">
                                <li class="flex gap-2 items-center">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Application statistics
                                </li>
                                <li class="flex gap-2 items-center">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Hiring progress tracking
                                </li>
                                <li class="flex gap-2 items-center">
                                    <i class="fi fi-rr-check text-success"></i>
                                    Position fill rates
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('hr.reports.recruitment') }}" class="gap-2 w-full btn btn-success">
                            <i class="fi fi-rr-file-chart-line"></i>
                            Generate Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
