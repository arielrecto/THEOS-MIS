<x-dashboard.registrar.base>
    <div class="py-8">
        <div class="container px-4 mx-auto">
            <div class="mx-auto max-w-5xl">
                <x-dashboard.page-title
                    :title="__('Enrollee Details')"
                    :back_url="route('registrar.enrollments.index')"
                >
                    <x-slot name="other">
                        @if ($enrollee->status == 'pending')
                            <form action="{{ route('registrar.enrollments.enrolled', $enrollee->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="gap-2 btn btn-sm btn-accent">
                                    <i class="fi fi-rr-check"></i>
                                    Mark as Enrolled
                                </button>
                            </form>
                        @endif
                    </x-slot>
                </x-dashboard.page-title>

                <x-notification-message />

                <!-- Status Badge -->
                <div class="p-4 mb-6 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600">Status:</span>
                        <span class="badge {{ $enrollee->status == 'pending' ? 'badge-warning' : 'badge-success' }}">
                            {{ ucfirst($enrollee->status) }}
                        </span>
                    </div>
                </div>

                <!-- Enrollment Details Card -->
                <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
                    <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                        <i class="fi fi-rr-graduation-cap"></i>
                        <span>Enrollment Details</span>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <p class="text-sm font-medium text-gray-600">School Year</p>
                            <p class="mt-1">{{ $enrollee->school_year }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Grade Level</p>
                            <p class="mt-1">{{ $enrollee->grade_level }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Returning Learner</p>
                            <p class="mt-1">{{ $enrollee->balik_aral ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Student Information Card -->
                <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
                    <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                        <i class="fi fi-rr-user"></i>
                        <span>Student Information</span>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Full Name</p>
                            <p class="mt-1">{{ $enrollee->first_name }} {{ $enrollee->middle_name }} {{ $enrollee->last_name }} {{ $enrollee->extension_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Date of Birth</p>
                            <p class="mt-1">{{ $enrollee->birthdate }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Place of Birth</p>
                            <p class="mt-1">{{ $enrollee->birthplace }}</p>
                        </div>
                    </div>
                </div>

                <!-- Address Information Card -->
                <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
                    <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                        <i class="fi fi-rr-home"></i>
                        <span>Address Information</span>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="mb-2 text-sm font-medium text-gray-600">Current Address</h3>
                            <p>{{ $enrollee->house_no }} {{ $enrollee->street }}, {{ $enrollee->barangay }}, {{ $enrollee->city }}, {{ $enrollee->province }}, {{ $enrollee->zip_code }}</p>
                        </div>

                        <div>
                            <h3 class="mb-2 text-sm font-medium text-gray-600">Permanent Address</h3>
                            <p>{{ $enrollee->perm_house_no }} {{ $enrollee->perm_street }}, {{ $enrollee->perm_barangay }}, {{ $enrollee->perm_city }}, {{ $enrollee->perm_province }}, {{ $enrollee->perm_zip_code }}</p>
                        </div>
                    </div>
                </div>

                <!-- Parent/Guardian Information Card -->
                <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
                    <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                        <i class="fi fi-rr-users"></i>
                        <span>Parent/Guardian Information</span>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Full Name</p>
                            <p class="mt-1">{{ $enrollee->parent_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Relationship</p>
                            <p class="mt-1">{{ $enrollee->relationship }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Contact Number</p>
                            <p class="mt-1">{{ $enrollee->contact_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Occupation</p>
                            <p class="mt-1">{{ $enrollee->occupation }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
                    <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                        <i class="fi fi-rr-envelope"></i>
                        <span>Contact Information</span>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-600">Email Address</p>
                        <p class="mt-1">{{ $enrollee->email ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 justify-end mt-6">
                    <a href="{{ route('registrar.enrollments.index') }}" class="btn btn-ghost">
                        <i class="fi fi-rr-arrow-left"></i>
                        Back to List
                    </a>
                    {{-- <a href="{{ route('registrar.enrollments.print', $enrollee->id) }}" class="gap-2 btn btn-accent">
                        <i class="fi fi-rr-print"></i>
                        Print Form
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
</x-dashboard.registrar.base>
