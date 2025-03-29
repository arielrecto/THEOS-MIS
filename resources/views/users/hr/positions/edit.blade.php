<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent">Dashboard</a>
                <i class="fi fi-rr-angle-right"></i>
                <a href="{{ route('hr.positions.index') }}" class="hover:text-accent">Positions</a>
                <i class="fi fi-rr-angle-right"></i>
                <a href="{{ route('hr.positions.show', $position) }}" class="hover:text-accent">
                    {{ $position->name }}
                </a>
                <i class="fi fi-rr-angle-right"></i>
                <span>Edit</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Position</h1>
        </div>

        <!-- Form Card -->
        <div class="max-w-3xl bg-white rounded-lg shadow-sm">
            <form action="{{ route('hr.positions.update', $position) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Position Name -->
                            <div class="md:col-span-2">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-medium">Position Title</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <input type="text"
                                           name="name"
                                           class="input input-bordered @error('name') input-error @enderror"
                                           value="{{ old('name', $position->name) }}"
                                           required>
                                    @error('name')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
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
                                                {{ old('department_id', $position->department_id) == $department->id ? 'selected' : '' }}>
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

                            <!-- Employment Type -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Employment Type</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="type"
                                        class="select select-bordered @error('type') select-error @enderror"
                                        required>
                                    <option value="full-time" {{ old('type', $position->type) === 'full-time' ? 'selected' : '' }}>
                                        Full Time
                                    </option>
                                    <option value="part-time" {{ old('type', $position->type) === 'part-time' ? 'selected' : '' }}>
                                        Part Time
                                    </option>
                                    <option value="contract" {{ old('type', $position->type) === 'contract' ? 'selected' : '' }}>
                                        Contract
                                    </option>
                                </select>
                                @error('type')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Salary Range -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Salary Range</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Minimum Salary -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Minimum Salary</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="number"
                                       name="min_salary"
                                       class="input input-bordered @error('min_salary') input-error @enderror"
                                       value="{{ old('min_salary', $position->min_salary) }}"
                                       required>
                                @error('min_salary')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Maximum Salary -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Maximum Salary</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="number"
                                       name="max_salary"
                                       class="input input-bordered @error('max_salary') input-error @enderror"
                                       value="{{ old('max_salary', $position->max_salary) }}"
                                       required>
                                @error('max_salary')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Job Description</h2>
                        <div class="form-control">
                            <textarea name="description"
                                      class="textarea textarea-bordered h-32 @error('description') textarea-error @enderror"
                                      required>{{ old('description', $position->description) }}</textarea>
                            @error('description')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Position Status</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Status</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="status"
                                        class="select select-bordered @error('status') select-error @enderror"
                                        required>
                                    <option value="active" {{ old('status', $position->status) === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="draft" {{ old('status', $position->status) === 'draft' ? 'selected' : '' }}>
                                        Draft
                                    </option>
                                    <option value="archived" {{ old('status', $position->status) === 'archived' ? 'selected' : '' }}>
                                        Archived
                                    </option>
                                </select>
                                @error('status')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label cursor-pointer justify-start gap-3">
                                    <input type="checkbox"
                                           name="is_hiring"
                                           class="checkbox checkbox-accent"
                                           {{ old('is_hiring', $position->is_hiring) ? 'checked' : '' }}>
                                    <span class="label-text">Currently Hiring</span>
                                </label>
                                @error('is_hiring')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t">
                        <a href="{{ route('hr.positions.show', $position) }}" class="btn btn-ghost">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-accent">
                            Update Position
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.hr.base>
