<x-dashboard.hr.base>
    <x-notification-message />
    <div class="w-full p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                <a href="{{ route('hr.departments.index') }}" class="hover:text-accent">Departments</a>
                <i class="fi fi-rr-angle-right"></i>
                <span>Edit</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Department</h1>
        </div>

        <!-- Form Card -->
        <div class="w-full bg-white rounded-lg shadow-sm">
            <form action="{{ route('hr.departments.update', $department) }}"
                  method="POST"
                  class="p-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="space-y-6">
                    <!-- Department Name -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Department Name</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               class="input input-bordered @error('name') input-error @enderror"
                               value="{{ old('name', $department->name) }}"
                               placeholder="Enter department name"
                               required>
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Department Description -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Description</span>
                        </label>
                        <textarea name="description"
                                  class="textarea textarea-bordered h-24 @error('description') textarea-error @enderror"
                                  placeholder="Enter department description">{{ old('description', $department->description) }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Department Code -->
                    {{-- <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Department Code</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="text"
                               name="code"
                               class="input input-bordered uppercase @error('code') input-error @enderror"
                               value="{{ old('code', $department->code) }}"
                               placeholder="Enter department code"
                               required>
                        @error('code')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div> --}}

                    <!-- Status -->
                    {{-- <div class="form-control">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox"
                                   name="is_active"
                                   class="checkbox checkbox-accent"
                                   {{ old('is_active', $department->is_active) ? 'checked' : '' }}>
                            <span class="label-text">Active Department</span>
                        </label>
                    </div> --}}
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t">
                    <a href="{{ route('hr.departments.index') }}"
                       class="btn btn-ghost">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-accent">
                        Update Department
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.hr.base>
