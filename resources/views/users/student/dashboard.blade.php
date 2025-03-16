<x-dashboard.student.base>
    <div class="container p-6 mx-auto">
        <h1 class="mb-4 text-2xl font-bold text-gray-700">Student Dashboard</h1>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

            <!-- Enrollment Status -->
            <div class="p-4 bg-white rounded-lg shadow-md">
                <h2 class="text-lg font-bold text-gray-700">Enrollment Status</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Status: <span class="font-semibold text-green-600">Approved</span>
                </p>
            </div>

            <!-- Tasks -->
            <div class="p-4 bg-white rounded-lg shadow-md md:col-span-2">
                <h2 class="text-lg font-bold text-gray-700">Tasks</h2>
                <ul class="mt-2 text-sm text-gray-600">
                    <li class="py-1">📌 <strong>Submit Essay</strong> - Due: March 20, 2025</li>
                    <li class="py-1">📌 <strong>Math Homework</strong> - Due: March 22, 2025</li>
                    <li class="py-1">📌 <strong>Science Project</strong> - Due: March 25, 2025</li>
                </ul>
            </div>

            <!-- Announcements -->
            <div class="p-4 bg-white rounded-lg shadow-md md:col-span-3">
                <h2 class="text-lg font-bold text-gray-700">Latest Announcements</h2>
                <ul class="mt-2 text-sm text-gray-600">
                    <li class="py-2 border-b">
                        <strong>School Opening Ceremony</strong> <br>
                        The school opening ceremony will be held on June 10, 2025.
                        <span class="text-xs text-gray-500">(Posted on March 10, 2025)</span>
                    </li>
                    <li class="py-2 border-b">
                        <strong>Midterm Exam Schedule</strong> <br>
                        Midterm exams will start on April 5, 2025. Prepare well!
                        <span class="text-xs text-gray-500">(Posted on March 5, 2025)</span>
                    </li>
                </ul>
            </div>

            <!-- Profile Information -->
            <div class="p-4 bg-white rounded-lg shadow-md">
                <h2 class="text-lg font-bold text-gray-700">Student Profile</h2>
                <p class="mt-2 text-sm text-gray-600">
                    <strong>Name:</strong> Juan Dela Cruz<br>
                    <strong>Student ID:</strong> 2025001234<br>
                    <strong>Grade Level:</strong> Grade 11
                </p>
            </div>

            <!-- Account Settings -->
            <div class="p-4 bg-white rounded-lg shadow-md">
                <h2 class="text-lg font-bold text-gray-700">Account Settings</h2>
                <p class="mt-2 text-sm text-gray-600">
                    <a href="#" class="text-blue-600 hover:underline">Edit Profile</a>
                </p>
            </div>

        </div>
    </div>    </div>
</x-dashboard.student.base>