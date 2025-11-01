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

                        {{-- <div>
                            <h3 class="mb-2 text-sm font-medium text-gray-600">Permanent Address</h3>
                            <p>{{ $enrollee->perm_house_no }} {{ $enrollee->perm_street }}, {{ $enrollee->perm_barangay }}, {{ $enrollee->perm_city }}, {{ $enrollee->perm_province }}, {{ $enrollee->perm_zip_code }}</p>
                        </div> --}}
                    </div>
                </div>

                <!-- Parent/Guardian Information Card -->
                <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
                    <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                        <i class="fi fi-rr-users"></i>
                        <span>Parent Information</span>
                    </div>

                    <!-- Father's Information -->
                    <div class="mb-8">
                        <h3 class="mb-4 text-md font-medium text-gray-700 flex items-center gap-2">
                            <i class="fi fi-rr-user"></i>
                            Father's Information
                        </h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 bg-gray-50 p-4 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Full Name</p>
                                <p class="mt-1">
                                    {{ $enrollee->parent_last_name }},
                                    {{ $enrollee->parent_name }}
                                    {{ $enrollee->parent_middle_name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Contact Number</p>
                                <p class="mt-1">{{ $enrollee->contact_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Occupation</p>
                                <p class="mt-1">{{ $enrollee->occupation ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Relationship</p>
                                <p class="mt-1">{{ $enrollee->relationship ?? 'Father' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Mother's Information -->
                    <div>
                        <h3 class="mb-4 text-md font-medium text-gray-700 flex items-center gap-2">
                            <i class="fi fi-rr-user"></i>
                            Mother's Information
                        </h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 bg-gray-50 p-4 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Full Name</p>
                                <p class="mt-1">
                                    {{ $enrollee->mother_last_name }},
                                    {{ $enrollee->mother_name }}
                                    {{ $enrollee->mother_middle_name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Contact Number</p>
                                <p class="mt-1">{{ $enrollee->mother_contact_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Occupation</p>
                                <p class="mt-1">{{ $enrollee->mother_occupation ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Relationship</p>
                                <p class="mt-1">{{ $enrollee->mother_relationship ?? 'Mother' }}</p>
                            </div>
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

                <!-- Uploaded Documents Card -->
                <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
                    <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                        <i class="fi fi-rr-folder"></i>
                        <span>Uploaded Documents</span>
                    </div>

                    <!-- Required Documents Grid -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 mb-8">
                        @php
                            $requiredDocs = [
                                'birth_certificate' => ['Birth Certificate (PSA/NSO)', 'fi-rr-id-badge'],
                                'form_138' => ['Report Card (Form 138)', 'fi-rr-diploma'],
                                'good_moral' => ['Good Moral Certificate', 'fi-rr-document']
                            ];
                        @endphp

                        @foreach($requiredDocs as $type => $details)
                            @php
                                $attachment = $enrollee->attachments()
                                    ->where('file_dir', 'like', "%/{$type}/%")
                                    ->first();
                            @endphp
                            <div class="p-4 bg-gray-50 rounded-lg border {{ $attachment ? 'border-accent/20' : 'border-error/20' }}">
                                <div class="flex items-start gap-3">
                                    <div class="p-3 rounded-lg {{ $attachment ? 'bg-accent/10' : 'bg-error/10' }}">
                                        <i class="text-lg fi {{ $details[1] }} {{ $attachment ? 'text-accent' : 'text-error' }}"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $details[0] }}</h3>
                                        @if($attachment)
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $attachment->file_name }}
                                                <span class="block text-gray-400">
                                                    {{ number_format($attachment->file_size / 1024 / 1024, 2) }} MB
                                                </span>
                                            </p>
                                            <div class="flex gap-2 mt-3">
                                                <a href="{{ Storage::url($attachment->file_dir) }}"
                                                   target="_blank"
                                                   class="btn btn-xs btn-ghost gap-1">
                                                    <i class="fi fi-rr-eye text-xs"></i>
                                                    View
                                                </a>
                                                {{-- <a href="{{ route('registrar.attachments.download', $attachment->id) }}"
                                                   class="btn btn-xs btn-ghost gap-1">
                                                    <i class="fi fi-rr-download text-xs"></i>
                                                    Download
                                                </a> --}}
                                            </div>
                                        @else
                                            <p class="mt-1 text-xs text-error">Document not uploaded</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Additional Documents Section -->
                    @php
                        $additionalDocs = $enrollee->attachments()
                            ->where('file_dir', 'like', "%/additional/%")
                            ->get();
                    @endphp

                    @if($additionalDocs->count() > 0)
                        <div class="mt-6">
                            <h3 class="mb-4 font-medium text-gray-700">Additional Documents</h3>
                            <div class="overflow-x-auto">
                                <table class="table table-zebra w-full">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>Type</th>
                                            <th>Size</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($additionalDocs as $doc)
                                            <tr>
                                                <td class="max-w-xs truncate">{{ $doc->file_name }}</td>
                                                <td>
                                                    <span class="badge badge-ghost">
                                                        {{ strtoupper(pathinfo($doc->file_name, PATHINFO_EXTENSION)) }}
                                                    </span>
                                                </td>
                                                <td>{{ number_format($doc->file_size / 1024 / 1024, 2) }} MB</td>
                                                <td class="text-right">
                                                    <div class="flex gap-2 justify-end">
                                                        <a href="{{ Storage::url($doc->file_dir) }}"
                                                           target="_blank"
                                                           class="btn btn-ghost btn-xs gap-1">
                                                            <i class="fi fi-rr-eye text-xs"></i>
                                                            View
                                                        </a>
                                                        {{-- <a href="{{ route('registrar.attachments.download', $doc->id) }}"
                                                           class="btn btn-ghost btn-xs gap-1">
                                                            <i class="fi fi-rr-download text-xs"></i>
                                                            Download
                                                        </a> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
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
