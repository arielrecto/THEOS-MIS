<x-dashboard.registrar.base>
    <x-dashboard.page-title
        :title="_('Edit Enrollment')"
        :back_url="route('registrar.enrollments.index')"
    />

    <div class="w-full">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('registrar.enrollments.update', $enrollment) }}"
                  method="POST"
                  class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Enrollment Name</span>
                        <span class="label-text-alt text-error">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           class="input input-bordered @error('name') input-error @enderror"
                           value="{{ old('name', $enrollment->name) }}"
                           required>
                    @error('name')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Academic Year -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Academic Year</span>
                        <span class="label-text-alt text-error">*</span>
                    </label>
                    <select name="academic_year_id"
                            class="select select-bordered @error('academic_year_id') select-error @enderror"
                            required>
                        <option value="">Select Academic Year</option>
                        @foreach(\App\Models\AcademicYear::where('status', \App\Enums\AcademicYearStatus::Active)->get() as $academicYear)
                            <option value="{{ $academicYear->id }}"
                                {{ old('academic_year_id', $enrollment->academic_year_id) == $academicYear->id ? 'selected' : '' }}>
                                {{ $academicYear->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('academic_year_id')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Start Date</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="date"
                               name="start_date"
                               class="input input-bordered @error('start_date') input-error @enderror"
                               value="{{ old('start_date', $enrollment->start_date) }}"
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
                               class="input input-bordered @error('end_date') input-error @enderror"
                               value="{{ old('end_date', $enrollment->end_date) }}"
                               required>
                        @error('end_date')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
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
                        @foreach(['On Going', 'Completed'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $enrollment->status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Description</span>
                    </label>
                    <textarea name="description"
                              class="textarea textarea-bordered h-32 @error('description') textarea-error @enderror">{{ old('description', $enrollment->description) }}</textarea>
                    @error('description')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('registrar.enrollments.index') }}"
                       class="btn btn-ghost">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-accent gap-2">
                        <i class="fi fi-rr-check"></i>
                        Update Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.registrar.base>
