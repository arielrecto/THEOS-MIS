<x-dashboard.employee.base>
    <div class="container mx-auto p-6">
        <!-- Welcome Banner -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Position Info -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-accent/10 rounded-lg">
                        <i class="fi fi-rr-briefcase text-accent text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Position</p>
                        <p class="font-semibold">Software Developer</p>
                    </div>
                </div>
            </div>

            <!-- Department -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary/10 rounded-lg">
                        <i class="fi fi-rr-building text-primary text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Department</p>
                        <p class="font-semibold">IT Department</p>
                    </div>
                </div>
            </div>

            <!-- Work Schedule -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-success/10 rounded-lg">
                        <i class="fi fi-rr-time-check text-success text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Work Schedule</p>
                        <p class="font-semibold">Full Time</p>
                    </div>
                </div>
            </div>

            <!-- Employment Status -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-secondary/10 rounded-lg">
                        <i class="fi fi-rr-badge text-secondary text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-semibold">Active</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile and Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex flex-col items-center text-center">
                    <div class="avatar mb-4">
                        <div class="w-24 h-24 rounded-full bg-accent/10 flex items-center justify-center">
                            <i class="fi fi-rr-user text-accent text-3xl"></i>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold">John Doe</h2>
                    <p class="text-sm text-gray-600 mb-4">Software Developer</p>

                    <div class="w-full space-y-3">
                        <div class="flex items-center gap-2 text-sm">
                            <i class="fi fi-rr-envelope text-gray-400"></i>
                            <span>john.doe@example.com</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <i class="fi fi-rr-phone-call text-gray-400"></i>
                            <span>+63 912 345 6789</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <i class="fi fi-rr-marker text-gray-400"></i>
                            <span>123 Main Street, City</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employment Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4">Employment Information</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600">Department</p>
                            <p class="font-medium">IT Department</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Position</p>
                            <p class="font-medium">Software Developer</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Date Hired</p>
                            <p class="font-medium">January 15, 2024</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Employment Type</p>
                            <p class="font-medium">Full Time</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.employee.base>
