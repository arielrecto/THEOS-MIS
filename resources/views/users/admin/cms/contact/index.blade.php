<x-dashboard.admin.base>
    <div class="container p-6 mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Contact Information Management</h1>
            <p class="text-gray-600">Update your organization's contact details</p>
        </div>

        <div class="max-w-xl">
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
                        <div>
                            <label for="phone_number" class="label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" inputmode="numeric"
                                minlength="11" maxlength="11" pattern="\d{11}"
                                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);"
                                value="{{ old('phone_number', $contactInfo?->phone_number) }}"
                                class="input input-bordered w-full" placeholder="Enter phone number">
                            @error('phone_number')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="email_address" class="label">Email Address</label>
                            <input type="email" name="email_address" id="email_address"
                                value="{{ old('email_address', $contactInfo?->email_address) }}"
                                class="input input-bordered w-full" placeholder="Enter email address">
                            @error('email_address')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('admin.CMS.index') }}" class="btn btn-ghost">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
