<x-dashboard.hr.base>
    <x-notification-message/>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent">Dashboard</a>
                <i class="fi fi-rr-angle-right"></i>
                <a href="{{ route('hr.departments.index') }}" class="hover:text-accent">Departments</a>
                <i class="fi fi-rr-angle-right"></i>
                <span>Create Position</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Create New Position</h1>
        </div>

        <!-- Form Card -->
        <div class="max-w-3xl bg-white rounded-lg shadow-sm">
            <form action="{{ route('hr.positions.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Position Name -->
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text font-medium">Position Title</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               class="input input-bordered @error('name') input-error @enderror"
                               value="{{ old('name') }}"
                               placeholder="Enter position title"
                               required>
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Department</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <select name="department_id"
                                class="select select-bordered @error('department_id') select-error @enderror"
                                required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Position Type -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Employment Type</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <select name="type"
                                class="select select-bordered @error('type') select-error @enderror"
                                required>
                            <option value="">Select Type</option>
                            <option value="full-time" {{ old('type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part-time" {{ old('type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                            <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                        @error('type')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Salary Range -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Minimum Salary</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="number"
                               name="min_salary"
                               class="input input-bordered @error('min_salary') input-error @enderror"
                               value="{{ old('min_salary') }}"
                               placeholder="Enter minimum salary"
                               required>
                        @error('min_salary')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Maximum Salary</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="number"
                               name="max_salary"
                               class="input input-bordered @error('max_salary') input-error @enderror"
                               value="{{ old('max_salary') }}"
                               placeholder="Enter maximum salary"
                               required>
                        @error('max_salary')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Status</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <select name="status"
                                class="select select-bordered @error('status') select-error @enderror"
                                required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('status')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text font-medium">Description</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <textarea name="description"
                                  class="textarea textarea-bordered h-32 @error('description') textarea-error @enderror"
                                  placeholder="Enter position description"
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Is Hiring Toggle -->
                    <div class="form-control md:col-span-2">
                        <label class="label cursor-pointer justify-start gap-4">
                            <input type="checkbox"
                                   name="is_hiring"
                                   class="toggle toggle-accent"
                                   {{ old('is_hiring') ? 'checked' : '' }}>
                            <div>
                                <span class="label-text font-medium">Open for Hiring</span>
                                <p class="text-xs text-gray-500">Toggle this if you're currently accepting applications for this position</p>
                            </div>
                        </label>
                        @error('is_hiring')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t">
                    <a href="{{ url()->previous() }}"
                       class="btn btn-ghost">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-accent">
                        Create Position
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.hr.base>
