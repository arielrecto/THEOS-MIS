<x-landing-page.base>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Student Enrollment</h1>
                    <p class="text-gray-600">Select your enrollment type to continue</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- New Student Card -->
                    <a href="{{ route('enrollment.form', ['type' => 'new', 'enrollment' => $enrollment->id]) }}"
                       class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                                <i class="fi fi-rr-user-add text-2xl text-primary"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">New Student</h2>
                            <p class="text-gray-600 text-sm">
                                First time enrolling in this school? Start here to begin your enrollment process.
                            </p>
                        </div>
                    </a>

                    <!-- Old Student Card -->
                    <a href="{{ route('enrollment.form', ['type' => 'old', 'enrollment' => $enrollment->id]) }}"
                       class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mb-4">
                                <i class="fi fi-rr-user-check text-2xl text-accent"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Old Student</h2>
                            <p class="text-gray-600 text-sm">
                                Already enrolled before? Click here to continue with your enrollment.
                            </p>
                        </div>
                    </a>
                </div>

                <div class="mt-8 text-center">
                    <a href="/" class="text-gray-600 hover:text-accent text-sm flex items-center justify-center gap-2">
                        <i class="fi fi-rr-arrow-left"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-landing-page.base>
