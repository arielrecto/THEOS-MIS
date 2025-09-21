<x-dashboard.employee.base>
    <div class="container p-6 mx-auto">
        <!-- Welcome Banner -->
        <div class="p-6 mb-6 bg-white rounded-lg shadow-sm">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Welcome back!</h1>
                    <p class="text-gray-600">Monday, March 29, 2024</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Employee ID</p>
                    <p class="text-lg font-semibold">EMP-001</p>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Position Info -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex gap-4 items-center">
                    <div class="p-3 rounded-lg bg-accent/10">
                        <i class="text-xl fi fi-rr-briefcase text-accent"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Position</p>
                        <p class="font-semibold">{{ $user->employee?->position->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Department -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex gap-4 items-center">
                    <div class="p-3 rounded-lg bg-primary/10">
                        <i class="text-xl fi fi-rr-building text-primary"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Department</p>
                        <p class="font-semibold">{{ $user->employee?->department->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Work Schedule -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex gap-4 items-center">
                    <div class="p-3 rounded-lg bg-success/10">
                        <i class="text-xl fi fi-rr-time-check text-success"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Work Schedule</p>
                        <p class="font-semibold">Full Time</p>
                    </div>
                </div>
            </div>

            <!-- Employment Status -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex gap-4 items-center">
                    <div class="p-3 rounded-lg bg-secondary/10">
                        <i class="text-xl fi fi-rr-badge text-secondary"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-semibold">Active</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile and Details -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Profile Card -->
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <div class="flex flex-col items-center text-center">
                    <div class="mb-4 avatar">
                        <div class="flex justify-center items-center w-24 h-24 rounded-full bg-accent/10">
                            @if ($user?->profile?->image)
                                <img src="{{ $user->profile->image }}" alt="Profile Picture" class="object-cover" />
                            @elseif ($user->profilePicture)
                                <img src="{{ $user->profilePicture->file_dir }}" alt="Profile Picture"
                                    class="object-cover" />
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF"
                                    alt="Profile Picture" class="object-cover" />
                            @endif
                        </div>
                    </div>
                    <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                    <p class="mb-4 text-sm text-gray-600">{{ $user->employee?->position->name ?? 'N/A' }}</p>

                    <div class="space-y-3 w-full">
                        <div class="flex gap-2 items-center text-sm">
                            <i class="text-gray-400 fi fi-rr-envelope"></i>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="flex gap-2 items-center text-sm">
                            <i class="text-gray-400 fi fi-rr-phone-call"></i>
                            <span>{{ $user->employee?->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex gap-2 items-center text-sm">
                            <i class="text-gray-400 fi fi-rr-marker"></i>
                            <span>{{ $user->employee?->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Details -->
            <div class="lg:col-span-2">
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <h2 class="mb-4 text-lg font-semibold">Employment Information</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600">Department</p>


                            <p class="font-medium">{{ $user->employee?->department->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Position</p>
                            <p class="font-medium">{{ $user->employee?->position->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Date Hired</p>
                            <p class="font-medium">
                                {{ $user->employee?->created_at ? $user->employee->created_at->format('F j, Y') : 'N/A' }}
                            </p>
                        </div>
                        {{-- <div>
                            <p class="text-sm text-gray-600">Employment Type</p>
                            <p class="font-medium">{{ $user->employee?->employment_type ?? 'RE' }}</p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.employee.base>
