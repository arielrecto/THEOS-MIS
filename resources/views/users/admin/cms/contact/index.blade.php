<x-dashboard.admin.base>
    <div class="container p-6 mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Contact Information Management</h1>
            <p class="text-gray-600">Update your organization's contact details</p>
        </div>

        <div class="max-w-2xl">
            <!-- Notification Messages -->
            @if (session('success'))
                <div class="alert alert-success mb-6">
                    <i class="fi fi-rr-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('admin.CMS.contact.store') }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <!-- Content Label -->
                        <div>
                            <label for="content_label" class="label">
                                <span class="label-text font-medium">Content Label</span>
                                <span class="label-text-alt text-gray-500">Section heading text</span>
                            </label>
                            <input type="text" name="content_label" id="content_label"
                                value="{{ old('content_label', $contactInfo?->content_label) }}"
                                class="input input-bordered w-full @error('content_label') input-error @enderror"
                                placeholder="e.g., Contact Us">
                            @error('content_label')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                            <label class="label">
                                <span class="label-text-alt text-gray-500">This will be displayed as the contact section
                                    heading</span>
                            </label>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone_number" class="label">
                                <span class="label-text font-medium">Phone Number</span>
                            </label>
                            <input type="text" name="phone_number" id="phone_number" inputmode="numeric"
                                minlength="11" maxlength="11" pattern="\d{11}"
                                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);"
                                value="{{ old('phone_number', $contactInfo?->phone_number) }}"
                                class="input input-bordered w-full @error('phone_number') input-error @enderror"
                                placeholder="09171234567">
                            @error('phone_number')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                            <label class="label">
                                <span class="label-text-alt text-gray-500">11-digit Philippine mobile number</span>
                            </label>
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email_address" class="label">
                                <span class="label-text font-medium">Email Address</span>
                            </label>
                            <input type="email" name="email_address" id="email_address"
                                value="{{ old('email_address', $contactInfo?->email_address) }}"
                                class="input input-bordered w-full @error('email_address') input-error @enderror"
                                placeholder="contact@example.com">
                            @error('email_address')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fi fi-rr-eye"></i>
                            Preview
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="font-medium">Section Heading:</span>
                                <span class="text-gray-600" id="preview-label">
                                    {{ $contactInfo?->content_label ?? 'Contact Us' }}
                                </span>
                            </div>
                            <div>
                                <span class="font-medium">Phone:</span>
                                <span class="text-gray-600" id="preview-phone">
                                    {{ $contactInfo?->phone_number ?? 'Not set' }}
                                </span>
                            </div>
                            <div>
                                <span class="font-medium">Email:</span>
                                <span class="text-gray-600" id="preview-email">
                                    {{ $contactInfo?->email_address ?? 'Not set' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('admin.CMS.index') }}" class="btn btn-ghost">
                            <i class="fi fi-rr-cross-small"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fi fi-rr-check"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Live preview updates
            document.getElementById('content_label')?.addEventListener('input', function(e) {
                document.getElementById('preview-label').textContent = e.target.value || 'Contact Us';
            });

            document.getElementById('phone_number')?.addEventListener('input', function(e) {
                document.getElementById('preview-phone').textContent = e.target.value || 'Not set';
            });

            document.getElementById('email_address')?.addEventListener('input', function(e) {
                document.getElementById('preview-email').textContent = e.target.value || 'Not set';
            });
        </script>
    @endpush
</x-dashboard.admin.base>
