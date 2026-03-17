{{-- filepath: e:\Projects\Theos MIS\resources\views\users\registrar\enrollment\create.blade.php --}}
<x-dashboard.registrar.base>
    <x-notification-message />
    <x-dashboard.page-title :back_url="route('registrar.enrollments.index')" :title="_('Enrollment Create')" />

    <div class="w-full max-w-2xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <form action="{{ route('registrar.enrollments.store') }}" method="post" class="space-y-6">
                @csrf

                <h1 class="text-xl font-semibold text-gray-800 mb-6">
                    Enrollment Create Form
                </h1>

                <!-- Name -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Enrollment Name</span>
                        <span class="label-text-alt text-error">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           class="input input-bordered w-full @error('name') input-error @enderror"
                           value="{{ old('name') }}"
                           placeholder="e.g., First Semester Enrollment 2024-2025"
                           required>
                    @error('name')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Academic Year and Semester -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Academic Year</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <select name="academic_year_id"
                                class="select select-bordered w-full @error('academic_year_id') select-error @enderror"
                                required>
                            <option value="">Select Academic Year</option>
                            @foreach ($academic_years as $academic_year)
                                <option value="{{ $academic_year->id }}" {{ old('academic_year_id') == $academic_year->id ? 'selected' : '' }}>
                                    {{ $academic_year->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_year_id')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Semester</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <select name="semester"
                                class="select select-bordered w-full @error('semester') select-error @enderror"
                                required>
                            <option value="">Select Semester</option>
                            <option value="1st Semester" {{ old('semester') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                            <option value="2nd Semester" {{ old('semester') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                        </select>
                        @error('semester')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Start Date</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="date"
                               name="start_date"
                               class="input input-bordered w-full @error('start_date') input-error @enderror"
                               value="{{ old('start_date') }}"
                               required>
                        @error('start_date')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">End Date</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="date"
                               name="end_date"
                               class="input input-bordered w-full @error('end_date') input-error @enderror"
                               value="{{ old('end_date') }}"
                               required>
                        @error('end_date')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Description</span>
                    </label>
                    <textarea name="description"
                              class="textarea textarea-bordered w-full h-28 sm:h-32 @error('description') textarea-error @enderror"
                              placeholder="Enter enrollment description or instructions...">{{ old('description') }}</textarea>
                    @error('description')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-2 pt-4 border-t">
                    <a href="{{ route('registrar.enrollments.index') }}"
                       class="btn btn-ghost w-full sm:w-auto text-center">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-accent gap-2 w-full sm:w-auto">
                        <i class="fi fi-rr-check"></i>
                        Create Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.registrar.base>
