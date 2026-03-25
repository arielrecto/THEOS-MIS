<x-dashboard.registrar.base>
    <div class="py-8">
        <div class="container px-4 sm:px-6 mx-auto">
            <div class="mx-auto max-w-5xl">
                <x-dashboard.page-title :title="__('Enrollee Details')" :back_url="route('registrar.enrollments.show', $enrollee->enrollment_id)">
                    <x-slot name="other">
                        @if ($enrollee->status != 'enrolled')
                            <div class="dropdown dropdown-end">
                                <button class="btn btn-ghost btn-xs">
                                    <i class="fi fi-rr-menu-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    @foreach (['pending', 'review', 'interviewed'] as $status)
                                        <li>
                                            <form
                                                action="{{ route('registrar.enrollments.update-status', $enrollee->id) }}"
                                                method="POST" class="w-full">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="{{ $status }}">
                                                <button type="button"
                                                    onclick="updateStatus(this.form, '{{ $status }}')"
                                                    class="w-full text-left {{ $enrollee->status === $status ? 'bg-accent/10 text-accent' : '' }}">
                                                    {{ ucfirst($status) }}
                                                </button>
                                            </form>
                                        </li>
                                    @endforeach

                                    <li>
                                        <form action="{{ route('registrar.enrollments.enrolled', $enrollee->id) }}"
                                            method="POST" class="w-full">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="enrolled">
                                            <button type="button" onclick="updateStatus(this.form, 'enrolled')"
                                                class="w-full text-left {{ $enrollee->status === 'enrolled' ? 'bg-accent/10 text-accent' : '' }}">
                                                {{ ucfirst('enrolled') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
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

                    <!-- Section Assignment -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fi fi-rr-users-alt"></i>
                            Section Assignment
                        </h3>

                        @if($enrollee->status === 'enrolled')
                            <!-- Show assigned section if already enrolled -->
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-600">Assigned Section:</span>
                                <span class="badge badge-lg badge-accent">
                                    {{ $enrollee->section ?? 'Not Assigned' }}
                                </span>
                            </div>
                        @else
                            <!-- Section selection form -->
                            <form action="{{ route('registrar.enrollments.update-section', $enrollee->id) }}" 
                                  method="POST" 
                                  id="sectionForm">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-medium">Select Section</span>
                                            @if($availableSections->isEmpty())
                                                <span class="label-text-alt text-error">No sections available</span>
                                            @endif
                                        </label>
                                        <select name="section" 
                                                class="select select-bordered" 
                                                required
                                                {{ $availableSections->isEmpty() ? 'disabled' : '' }}>
                                            <option value="" disabled {{ !$enrollee->section ? 'selected' : '' }}>
                                                Choose a section
                                            </option>
                                            @foreach($availableSections as $section)
                                                <option value="{{ $section->name }}"
                                                        {{ $enrollee->section === $section->name ? 'selected' : '' }}
                                                        {{ $section->student_count >= $section->capacity ? 'disabled' : '' }}>
                                                    {{ $section->name }} 
                                                    ({{ $section->student_count }}/{{ $section->capacity }} students)
                                                    {{ $section->student_count >= $section->capacity ? '- FULL' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label class="label">
                                            <span class="label-text-alt">
                                                Sections for {{ $enrollee->grade_level }}
                                            </span>
                                        </label>
                                    </div>

                                    <div class="form-control">
                                        <button type="submit" 
                                                class="btn btn-primary"
                                                {{ $availableSections->isEmpty() ? 'disabled' : '' }}>
                                            <i class="fi fi-rr-check mr-2"></i>
                                            {{ $enrollee->section ? 'Update Section' : 'Assign Section' }}
                                        </button>
                                    </div>
                                </div>

                                @if($enrollee->section)
                                    <div class="mt-3 flex items-center gap-2 text-sm">
                                        <i class="fi fi-rr-info text-accent"></i>
                                        <span class="text-gray-600">
                                            Current section: <strong>{{ $enrollee->section }}</strong>
                                        </span>
                                    </div>
                                @endif
                            </form>

                            <!-- Section availability info -->
                            @if($availableSections->isNotEmpty())
                                <div class="mt-4 divider"></div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($availableSections as $section)
                                        <div class="p-3 bg-white rounded-lg border">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="font-semibold">{{ $section->name }}</span>
                                                <span class="badge badge-sm {{ $section->student_count >= $section->capacity ? 'badge-error' : 'badge-success' }}">
                                                    {{ $section->student_count >= $section->capacity ? 'Full' : 'Available' }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-600">
                                                <p>Capacity: {{ $section->student_count }}/{{ $section->capacity }}</p>
                                                @if($section->description)
                                                    <p class="mt-1">{{ $section->description }}</p>
                                                @endif
                                            </div>
                                            <progress class="progress progress-accent w-full mt-2" 
                                                      value="{{ $section->student_count }}" 
                                                      max="{{ $section->capacity }}"></progress>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
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
                            <p class="mt-1 break-words">{{ $enrollee->first_name }} {{ $enrollee->middle_name }}
                                {{ $enrollee->last_name }} {{ $enrollee->extension_name }}</p>
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
                            <p class="break-words">{{ $enrollee->house_no }} {{ $enrollee->street }},
                                {{ $enrollee->barangay }},
                                {{ $enrollee->city }}, {{ $enrollee->province }}, {{ $enrollee->zip_code }}</p>
                        </div>
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
                                <p class="mt-1 break-words">
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
                                <p class="mt-1 break-words">
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

                    <!-- Guardian Information (Only show if guardian exists) -->
                    @if($enrollee->guardian_name || $enrollee->guardian_last_name || $enrollee->guardian_middle_name)
                        <div class="mt-8">
                            <h3 class="mb-4 text-md font-medium text-gray-700 flex items-center gap-2">
                                <i class="fi fi-rr-shield-check"></i>
                                Guardian Information
                                <span class="text-xs text-gray-500 font-normal ml-2">(If different from parents)</span>
                            </h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Full Name</p>
                                    <p class="mt-1 break-words">
                                        {{ $enrollee->guardian_last_name ?? 'N/A' }},
                                        {{ $enrollee->guardian_name ?? 'N/A' }}
                                        {{ $enrollee->guardian_middle_name ?? '' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Relationship to Student</p>
                                    <p class="mt-1">
                                        <span class="badge badge-accent">
                                            {{ $enrollee->guardian_relationship ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Contact Number</p>
                                    <p class="mt-1">{{ $enrollee->guardian_contact_number ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Occupation</p>
                                    <p class="mt-1">{{ $enrollee->guardian_occupation ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Contact Information Card -->
                <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
                    <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                        <i class="fi fi-rr-envelope"></i>
                        <span>Contact Information</span>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-600">Email Address</p>
                        <p class="mt-1 break-words">{{ $enrollee->email ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Uploaded Documents Card -->
                <div class="p-6 mb-6 bg-white rounded-lg shadow-lg">
                    <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                        <i class="fi fi-rr-folder"></i>
                        <span>Uploaded Documents</span>
                    </div>

                    <!-- Required Documents Grid -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-6">
                        @php
                            $requiredDocs = [
                                'birth_certificate' => ['Birth Certificate (PSA/NSO)', 'fi-rr-id-badge'],
                                'form_138' => ['Report Card (Form 138)', 'fi-rr-diploma'],
                                'good_moral' => ['Good Moral Certificate', 'fi-rr-document'],
                            ];
                        @endphp

                        @foreach ($requiredDocs as $type => $details)
                            @php
                                $attachment = $enrollee
                                    ->attachments()
                                    ->where('file_dir', 'like', "%/{$type}/%")
                                    ->first();
                            @endphp
                            <div
                                class="p-4 bg-gray-50 rounded-lg border {{ $attachment ? 'border-accent/20' : 'border-error/20' }}">
                                <div class="flex items-start gap-3">
                                    <div class="p-3 rounded-lg {{ $attachment ? 'bg-accent/10' : 'bg-error/10' }}">
                                        <i
                                            class="text-lg fi {{ $details[1] }} {{ $attachment ? 'text-accent' : 'text-error' }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-medium text-gray-900 truncate">{{ $details[0] }}</h3>
                                        @if ($attachment)
                                            <p class="mt-1 text-xs text-gray-500 truncate">
                                                {{ $attachment->file_name }}
                                                <span class="block text-gray-400">
                                                    {{ number_format($attachment->file_size / 1024 / 1024, 2) }} MB
                                                </span>
                                            </p>
                                            <div class="flex gap-2 mt-3 flex-wrap">
                                                <a href="{{ Storage::url($attachment->file_dir) }}" target="_blank"
                                                    class="btn btn-xs btn-ghost gap-1">
                                                    <i class="fi fi-rr-eye text-xs"></i>
                                                    View
                                                </a>
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
                        $additionalDocs = $enrollee->attachments()->where('file_dir', 'like', '%/additional/%')->get();
                    @endphp

                    @if ($additionalDocs->count() > 0)
                        <div class="mt-4">
                            <h3 class="mb-4 font-medium text-gray-700">Additional Documents</h3>

                            {{-- Desktop/Table View --}}
                            <div class="hidden md:block overflow-x-auto">
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
                                        @foreach ($additionalDocs as $doc)
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
                                                        <a href="{{ Storage::url($doc->file_dir) }}" target="_blank"
                                                            class="btn btn-ghost btn-xs gap-1">
                                                            <i class="fi fi-rr-eye text-xs"></i>
                                                            View
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile Card List --}}
                            <div class="md:hidden space-y-3">
                                @foreach ($additionalDocs as $doc)
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="min-w-0">
                                                <p class="font-medium text-sm truncate">{{ $doc->file_name }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ strtoupper(pathinfo($doc->file_name, PATHINFO_EXTENSION)) }} •
                                                    {{ number_format($doc->file_size / 1024 / 1024, 2) }} MB
                                                </p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <a href="{{ Storage::url($doc->file_dir) }}" target="_blank"
                                                    class="btn btn-ghost btn-xs">
                                                    <i class="fi fi-rr-eye text-xs"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-end mt-6">
                    <a href="{{ route('registrar.enrollments.index') }}" class="btn btn-ghost w-full sm:w-auto">
                        <i class="fi fi-rr-arrow-left"></i>
                        <span class="hidden sm:inline">Back to List</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function updateStatus(form, status) {
                let remarks = '';

                if (['review', 'interviewed', 'enrolled'].includes(status)) {
                    remarks = prompt('Enter any additional remarks (optional):');
                }

                if (status === 'enrolled') {
                    // Check if section is assigned before enrolling
                    const sectionSelect = document.querySelector('select[name="section"]');
                    if (sectionSelect && !sectionSelect.value && sectionSelect.options.length > 1) {
                        alert('Please assign a section before enrolling the student.');
                        return;
                    }

                    if (!confirm('Are you sure you want to enroll this student?')) {
                        return;
                    }
                }

                const remarksInput = document.createElement('input');
                remarksInput.type = 'hidden';
                remarksInput.name = 'remarks';
                remarksInput.value = remarks || '';

                form.appendChild(remarksInput);
                form.submit();
            }
        </script>
    @endpush
</x-dashboard.registrar.base>
