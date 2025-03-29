<x-dashboard.admin.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-accent">Dashboard</a>
                <i class="fi fi-rr-angle-right"></i>
                <a href="{{ route('admin.academic-year.index') }}" class="hover:text-accent">Academic Years</a>
                <i class="fi fi-rr-angle-right"></i>
                <span>Edit {{ $academicYear->name }}</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Academic Year</h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm">
            <form action="{{ route('admin.academic-year.update', $academicYear) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Date Range -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Academic Year Period</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Start Date</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="date"
                                       name="start_date"
                                       class="input input-bordered @error('start_date') input-error @enderror"
                                       value="{{ old('start_date', date('Y-m-d', strtotime('$academicYear->start_date'))) }}"
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
                                       value="{{ old('end_date', date('Y-m-d', strtotime($academicYear->end_date))) }}"
                                       required>
                                @error('end_date')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Status</h2>
                        <div class="form-control">
                            <label class="label cursor-pointer justify-start gap-3">
                                <input type="checkbox"
                                       name="status"
                                       class="checkbox checkbox-accent"
                                       value="active"
                                       {{ $academicYear->status === 'active' ? 'checked' : '' }}>
                                <span class="label-text">Active Academic Year</span>
                            </label>
                            @error('status')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t">
                        <a href="{{ route('admin.academic-year.index') }}" class="btn btn-ghost">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-accent">
                            Update Academic Year
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.admin.base>
