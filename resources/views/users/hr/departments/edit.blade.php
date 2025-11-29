<x-dashboard.hr.base>
    <x-notification-message />

    <!-- container with max width for better mobile readability -->
    <div class="container mx-auto px-4 sm:px-6 p-4 sm:p-6 max-w-2xl">
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
        <div class="w-full bg-white rounded-lg shadow-sm overflow-hidden">
            <form action="{{ route('hr.departments.update', $department) }}"
                  method="POST"
                  class="p-4 sm:p-6 space-y-6">
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
                               class="input input-bordered w-full @error('name') input-error @enderror"
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
                                  class="textarea textarea-bordered w-full h-28 sm:h-32 @error('description') textarea-error @enderror"
                                  placeholder="Enter department description">{{ old('description', $department->description) }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Department Code (kept commented, responsive if enabled) -->
                    {{-- <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Department Code</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="text"
                               name="code"
                               class="input input-bordered uppercase w-full @error('code') input-error @enderror"
                               value="{{ old('code', $department->code) }}"
                               placeholder="Enter department code"
                               required>
                        @error('code')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div> --}}
                </div>

                <!-- Department Head -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Head</span>
                        <span class="label-text-alt text-error">*</span>
                    </label>
                    <select name="head" class="select select-bordered w-full @error('head') select-error @enderror" required>
                        <option value="" disabled {{ old('head', $department->head) ? '' : 'selected' }}>Select department head</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ (string)old('head', $department->head) === (string)$employee->id ? 'selected' : '' }}>
                                {{ $employee->name }} ({{ $employee->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('head')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Form Actions: stacked on mobile, inline on larger screens -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-2 pt-4 border-t">
                    <a href="{{ route('hr.departments.index') }}"
                       class="btn btn-ghost w-full sm:w-auto text-center">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-accent w-full sm:w-auto">
                        Update Department
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.hr.base>
