<x-dashboard.student.base>
    <div class="container p-6 mx-auto">
        <h1 class="mb-6 text-2xl font-bold text-gray-700">Account Settings</h1>

        <div class="grid gap-6">
            <!-- Profile Information -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-lg font-medium text-gray-900">Profile Information</h2>
                <form method="POST" action="{{ route('student.settings.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">LRN</label>
                            <input type="text" disabled name="lrn"
                                value="{{ old('lrn', $student->studentProfile->lrn) }}"
                                class="mt-1 w-full input input-bordered" required>
                            @error('lrn')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="text" name="contact_number"
                                inputmode="numeric"
                                minlength="11"
                                maxlength="11"
                                pattern="\d{11}"
                                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);"
                                value="{{ old('contact_number', $student->studentProfile->contact_number) }}"
                                class="mt-1 w-full input input-bordered" title="Please enter exactly 11 digits">
                            @error('contact_number')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Parent/Guardian Name</label>
                            <input type="text" name="parent_name"
                                value="{{ old('parent_name', $student->studentProfile->parent_name) }}"
                                class="mt-1 w-full input input-bordered" required>
                            @error('parent_name')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Relationship</label>
                            <input type="text" name="relationship"
                                value="{{ old('relationship', $student->studentProfile->relationship) }}"
                                class="mt-1 w-full input input-bordered" required>
                            @error('relationship')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" class="mt-1 w-full textarea textarea-bordered" rows="3" required>{{ old('address', $student->studentProfile->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-error">{{ $message }}</p>
                            @enderror
                        </div> --}}
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-accent">Update Profile</button>
                    </div>
                </form>
            </div>

            <!-- Update Email -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-lg font-medium text-gray-900">Update Email</h2>
                <form method="POST" action="{{ route('student.settings.email.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}"
                            class="mt-1 w-full input input-bordered" required>
                        @error('email')
                            <p class="mt-1 text-sm text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-accent">Update Email</button>
                    </div>
                </form>
            </div>

            <!-- Update Password -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-lg font-medium text-gray-900">Update Password</h2>
                <form method="POST" action="{{ route('student.settings.password.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password" class="mt-1 w-full input input-bordered"
                            required>
                        @error('current_password')
                            <p class="mt-1 text-sm text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" class="mt-1 w-full input input-bordered" required>
                        @error('password')
                            <p class="mt-1 text-sm text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="mt-1 w-full input input-bordered"
                            required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-accent">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="toast toast-end">
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
</x-dashboard.student.base>
