<x-dashboard.hr.base>
    <div class="container p-6 mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex gap-2 items-center mb-2 text-sm text-gray-600">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent">Dashboard</a>
                <i class="fi fi-rr-angle-right"></i>
                <a href="{{ route('hr.employees.index') }}" class="hover:text-accent">Employees</a>
                <i class="fi fi-rr-angle-right"></i>
                <span>Create Employee</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Create New Employee</h1>
        </div>

        <!-- Form Card -->
        <div class="max-w-4xl bg-white rounded-lg shadow-sm">
            <form action="{{ route('hr.employees.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf
                @if ($applicant)
                    <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                @endif

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Basic Information -->
                    <div class="md:col-span-2">
                        <h2 class="mb-4 text-lg font-semibold text-gray-800">Basic Information</h2>
                    </div>

                    <!-- First Name -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text">First Name</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="text" name="first_name"
                            class="input input-bordered @error('first_name') input-error @enderror"
                            value="{{ old('first_name', $applicant?->name) }}" required>
                        @error('first_name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text">Last Name</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="text" name="last_name"
                            class="input input-bordered @error('last_name') input-error @enderror"
                            value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text">Email Address</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="email" name="email"
                            class="input input-bordered @error('email') input-error @enderror"
                            value="{{ old('email', $applicant?->email) }}" required>
                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text">Phone Number</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="tel" name="phone"
                            class="input input-bordered @error('phone') input-error @enderror"
                            value="{{ old('phone', $applicant?->phone) }}" required>
                        @error('phone')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Employment Details -->
                    <div class="pt-6 mt-2 border-t md:col-span-2">
                        <h2 class="mb-4 text-lg font-semibold text-gray-800">Employment Details</h2>
                    </div>

                    <!-- Position -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text">Position</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <select name="job_position_id"
                            class="select select-bordered @error('job_position_id') select-error @enderror" required>
                            <option value="">Select Position</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}"
                                    {{ old('job_position_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('job_position_id')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Salary -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text">Salary</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="number" name="salary"
                            class="input input-bordered @error('salary') input-error @enderror"
                            value="{{ old('salary') }}" required>
                        @error('salary')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>


                    <!-- Leave Credit -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text">Leave Credit</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="number" name="leave_credit"
                            class="input input-bordered @error('leave_credit') input-error @enderror"
                            value="{{ old('leave_credit') }}" required>
                        @error('leave_credit')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Personal Details -->
                    <div class="pt-6 mt-2 border-t md:col-span-2">
                        <h2 class="mb-4 text-lg font-semibold text-gray-800">Personal Details</h2>
                    </div>

                    <!-- Date of Birth -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text">Date of Birth</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="date" name="date_of_birth"
                            class="input input-bordered @error('date_of_birth') input-error @enderror"
                            value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Photo -->
                    <div class="form-control">
                        <label class="label">
                            <span class="font-medium label-text">Photo</span>
                        </label>
                        <input type="file" name="photo"
                            class="file-input file-input-bordered @error('photo') file-input-error @enderror"
                            accept="image/*">
                        @error('photo')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <div class="form-control">
                            <label class="label">
                                <span class="font-medium label-text">Address</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <textarea name="address" class="textarea textarea-bordered h-20 @error('address') textarea-error @enderror" required>{{ old('address') }}</textarea>
                            @error('address')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-3 justify-end items-center pt-6 mt-6 border-t md:col-span-2">
                        <a href="{{ url()->previous() }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-accent">Create Employee</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.hr.base>
