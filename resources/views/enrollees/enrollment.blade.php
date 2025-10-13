<x-landing-page.base>
    <div class="py-12 min-h-screen bg-gray-50">
        <div class="container px-4 mx-auto">
            <div class="mx-auto max-w-4xl">
                <!-- Header Section -->
                <div class="mb-8 text-center">
                    <h1 class="mb-4 text-4xl font-bold text-gray-900">Enrollment Now Open</h1>
                    <p class="text-lg text-gray-600">Theos Higher Ground Academe. welcomes new students for the upcoming
                        academic year</p>
                </div>

                <!-- Main Content -->
                <div class="overflow-hidden bg-white rounded-2xl shadow-lg">
                    <!-- Enrollment Status Banner -->
                    <div class="px-6 py-4 border-b bg-accent/10">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">
                                    Academic Year {{ date('Y', strtotime($enrollment->academicYear->start_date)) }} -
                                    {{ date('Y', strtotime($enrollment->academicYear->end_date)) }}
                                </h2>
                                <p class="mt-1 text-gray-600">Secure your child's future with quality Christian
                                    education</p>
                            </div>

                            @if ($enrollment->academicYear->status === 'inactive')
                                <span class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-full">
                                    Enrollment Inactive
                                </span>
                            @else
                                <span class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-full">
                                    Enrollment Active
                                </span>
                            @endif

                        </div>
                    </div>

                    <!-- Enrollment Details -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-500">Enrollment Period</h3>
                                <div class="flex items-center text-gray-800">
                                    <i class="mr-2 fi fi-rr-calendar text-accent"></i>
                                    <span>{{ date('F d', strtotime($enrollment->start_date)) }} -
                                        {{ date('F d, Y', strtotime($enrollment->end_date)) }}</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-sm font-medium text-gray-500">Available Programs</h3>
                                <div class="flex items-center text-gray-800">
                                    <i class="mr-2 fi fi-rr-graduation-cap text-accent"></i>
                                    <span>Elementary to Grade 10</span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="p-6 mb-8 bg-gray-50 rounded-xl">
                            <h3 class="mb-3 text-sm font-medium text-gray-500">Important Information</h3>
                            <div class="max-w-none text-gray-600 prose prose-sm">
                                {{ $enrollment->description }}
                            </div>
                        </div>

                        <!-- Requirements Section -->
                        <div class="flex justify-between">
                            <div class="mb-8">
                                <h3 class="mb-3 text-sm font-medium text-gray-500">New/Transferee</h3>

                                <h3 class="mb-3 text-sm font-medium text-gray-500">Requirements</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="mt-1 mr-2 fi fi-rr-check text-accent"></i>
                                        <span class="text-gray-600">Birth Certificate (PSA/NSO)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="mt-1 mr-2 fi fi-rr-check text-accent"></i>
                                        <span class="text-gray-600">Report Card from previous school</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="mt-1 mr-2 fi fi-rr-check text-accent"></i>
                                        <span class="text-gray-600">2x2 ID Picture (4 pieces)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="mt-1 mr-2 fi fi-rr-check text-accent"></i>
                                        <span class="text-gray-600">Good Moral Certificate</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="mb-8">

                                <h3 class="mb-3 text-sm font-medium text-gray-500">Old Student Requirements:</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="mt-1 mr-2 fi fi-rr-check text-accent"></i>
                                        <span class="text-gray-600">Grade Report Card</span>
                                    </li>

                                </ul>
                            </div>

                        </div>


                        <!-- Action Section -->
                        <div class="text-center">
                            <p class="mb-4 text-gray-600">Ready to begin your journey with Theos Higher Ground Academe?
                            </p>
                            <a href="{{ route('enrollment.form', ['enrollment' => $enrollment->id]) }}"
                                class="gap-2 btn btn-accent btn-lg">
                                <i class="fi fi-rr-edit"></i>
                                Start Enrollment Process
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="mt-8 text-center text-gray-600">
                    <p>Need assistance? Contact our admissions office:</p>
                    <p class="font-medium">0917547 5374 | thgaofficial@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
</x-landing-page.base>
