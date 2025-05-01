<x-landing-page.base>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Header Section -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Enrollment Now Open</h1>
                    <p class="text-lg text-gray-600">Theos Higher Ground Academe. welcomes new students for the upcoming academic year</p>
                </div>

                <!-- Main Content -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- Enrollment Status Banner -->
                    <div class="bg-accent/10 px-6 py-4 border-b">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">
                                    Academic Year {{ date('Y', strtotime($enrollment->academicYear->start_date)) }} - {{ date('Y', strtotime($enrollment->academicYear->end_date)) }}
                                </h2>
                                <p class="text-gray-600 mt-1">Secure your child's future with quality Christian education</p>
                            </div>
                            <span class="px-4 py-2 bg-green-500 text-white rounded-full text-sm font-medium">
                                Enrollment Active
                            </span>
                        </div>
                    </div>

                    <!-- Enrollment Details -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-500">Enrollment Period</h3>
                                <div class="flex items-center text-gray-800">
                                    <i class="fi fi-rr-calendar mr-2 text-accent"></i>
                                    <span>{{ date('F d', strtotime($enrollment->start_date)) }} - {{ date('F d, Y', strtotime($enrollment->end_date)) }}</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-500">Available Programs</h3>
                                <div class="flex items-center text-gray-800">
                                    <i class="fi fi-rr-graduation-cap mr-2 text-accent"></i>
                                    <span>Elementary to Senior High School</span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="bg-gray-50 rounded-xl p-6 mb-8">
                            <h3 class="text-sm font-medium text-gray-500 mb-3">Important Information</h3>
                            <div class="prose prose-sm max-w-none text-gray-600">
                                {{ $enrollment->description }}
                            </div>
                        </div>

                        <!-- Requirements Section -->
                        <div class="flex justify-between">
                            <div class="mb-8">
                                <h3 class="text-sm font-medium text-gray-500 mb-3">New/Transferee</h3>

                                <h3 class="text-sm font-medium text-gray-500 mb-3">Requirements</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fi fi-rr-check text-accent mt-1 mr-2"></i>
                                        <span class="text-gray-600">Birth Certificate (PSA/NSO)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fi fi-rr-check text-accent mt-1 mr-2"></i>
                                        <span class="text-gray-600">Report Card from previous school</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fi fi-rr-check text-accent mt-1 mr-2"></i>
                                        <span class="text-gray-600">2x2 ID Picture (4 pieces)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fi fi-rr-check text-accent mt-1 mr-2"></i>
                                        <span class="text-gray-600">Good Moral Certificate</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="mb-8">

                                <h3 class="text-sm font-medium text-gray-500 mb-3">Old Student Requirements:</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fi fi-rr-check text-accent mt-1 mr-2"></i>
                                        <span class="text-gray-600">Grade Report Card</span>
                                    </li>

                                </ul>
                            </div>

                        </div>


                        <!-- Action Section -->
                        <div class="text-center">
                            <p class="text-gray-600 mb-4">Ready to begin your journey with Theos Higher Ground Academe?</p>
                            <a href="{{ route('enrollment.form', ['enrollment' => $enrollment->id]) }}"
                               class="btn btn-accent btn-lg gap-2">
                                <i class="fi fi-rr-edit"></i>
                                Start Enrollment Process
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="mt-8 text-center text-gray-600">
                    <p>Need assistance? Contact our admissions office:</p>
                    <p class="font-medium">(046) 123-4567 | admissions@sta.edu.ph</p>
                </div>
            </div>
        </div>
    </div>
</x-landing-page.base>
