<x-dashboard.employee.base>
    <div class="container max-w-7xl p-4 sm:p-6 mx-auto">
        <!-- Welcome Banner -->
        <div class="p-4 sm:p-6 mb-6 bg-white rounded-lg shadow-sm">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 truncate">Welcome back!</h1>
                    <p class="text-sm sm:text-base text-gray-600">{{ now()->format('l, F d, Y') }}</p>
                </div>
                <div class="text-left sm:text-right">
                    <p class="text-sm text-gray-600">Employee ID</p>
                    <p class="text-base sm:text-lg font-semibold">EMP-001</p>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Position Info -->
            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-2 sm:p-3 rounded-lg bg-accent/10">
                        <i class="text-lg sm:text-xl fi fi-rr-briefcase text-accent"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm text-gray-600">Position</p>
                        <p class="font-semibold text-sm sm:text-base truncate">
                            {{ $user->employee?->position->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Department -->
            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-2 sm:p-3 rounded-lg bg-primary/10">
                        <i class="text-lg sm:text-xl fi fi-rr-building text-primary"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm text-gray-600">Department</p>
                        <p class="font-semibold text-sm sm:text-base truncate">
                            {{ $user->employee?->department->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Work Schedule -->
            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-2 sm:p-3 rounded-lg bg-success/10">
                        <i class="text-lg sm:text-xl fi fi-rr-time-check text-success"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm text-gray-600">Work Schedule</p>
                        <p class="font-semibold text-sm sm:text-base">Full Time</p>
                    </div>
                </div>
            </div>

            <!-- Employment Status -->
            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-2 sm:p-3 rounded-lg bg-secondary/10">
                        <i class="text-lg sm:text-xl fi fi-rr-badge text-secondary"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm text-gray-600">Status</p>
                        <p class="font-semibold text-sm sm:text-base">Active</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile and Details -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Profile Card -->
            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <div class="flex flex-col items-center text-center">
                    <div class="mb-4 avatar">
                        <div
                            class="flex justify-center items-center w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 rounded-full bg-accent/10 overflow-hidden">
                            @if ($user?->profile?->image)
                                <img src="{{ $user->profile->image }}" alt="Profile Picture"
                                    class="object-cover w-full h-full" />
                            @elseif ($user->profilePicture)
                                <img src="{{ $user->profilePicture->file_dir }}" alt="Profile Picture"
                                    class="object-cover w-full h-full" />
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF"
                                    alt="Profile Picture" class="object-cover w-full h-full" />
                            @endif
                        </div>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold truncate">{{ $user->name }}</h2>
                    <p class="mb-4 text-xs sm:text-sm text-gray-600 truncate">
                        {{ $user->employee?->position->name ?? 'N/A' }}</p>

                    <div class="space-y-3 w-full text-sm">
                        <div class="flex gap-2 items-center text-xs sm:text-sm break-words">
                            <i class="text-gray-400 fi fi-rr-envelope"></i>
                            <span class="truncate">{{ $user->email }}</span>
                        </div>
                        <div class="flex gap-2 items-center text-xs sm:text-sm break-words">
                            <i class="text-gray-400 fi fi-rr-phone-call"></i>
                            <span>{{ $user->employee?->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex gap-2 items-center text-xs sm:text-sm break-words">
                            <i class="text-gray-400 fi fi-rr-marker"></i>
                            <span class="truncate">{{ $user->employee?->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Details -->
            <div class="lg:col-span-2">
                <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                    <h2 class="mb-4 text-base sm:text-lg font-semibold">Employment Information</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600">Department</p>
                            <p class="font-medium text-sm sm:text-base truncate">
                                {{ $user->employee?->department->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600">Position</p>
                            <p class="font-medium text-sm sm:text-base truncate">
                                {{ $user->employee?->position->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600">Date Hired</p>
                            <p class="font-medium text-sm sm:text-base">
                                {{ $user->employee?->created_at ? $user->employee->created_at->format('F j, Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.employee.base>
