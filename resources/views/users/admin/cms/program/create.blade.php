<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Add Academic Program</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">Create a new academic program</p>
                </div>
                <a href="{{ route('admin.CMS.programs.index') }}"
                    class="btn btn-ghost btn-sm sm:btn-md gap-2 w-full sm:w-auto justify-center">
                    <i class="fi fi-rr-arrow-left"></i>
                    <span class="text-xs sm:text-sm">Back to Programs</span>
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="mx-auto max-w-2xl">
            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <form action="{{ route('admin.CMS.programs.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf

                    <!-- Title -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm sm:text-base font-medium">Title</span>
                        </label>
                        <input type="text" name="title" placeholder="Enter program title"
                            class="input input-bordered w-full text-sm sm:text-base @error('title') input-error @enderror"
                            value="{{ old('title') }}" required>
                        @error('title')
                            <label class="label">
                                <span class="label-text-alt text-error text-xs sm:text-sm">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm sm:text-base font-medium">Category</span>
                        </label>
                        <input type="text" name="category"
                            placeholder="e.g., Elementary, Grade 7, Senior High School"
                            class="input input-bordered w-full text-sm sm:text-base @error('category') input-error @enderror"
                            value="{{ old('category') }}" required>
                        <label class="label">
                            <span class="label-text-alt text-xs text-gray-500">Enter the program category or grade
                                level</span>
                        </label>
                        @error('category')
                            <label class="label">
                                <span class="label-text-alt text-error text-xs sm:text-sm">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm sm:text-base font-medium">Description</span>
                        </label>
                        <textarea name="description" placeholder="Write the program description..."
                            class="textarea textarea-bordered w-full min-h-32 text-sm sm:text-base @error('description') textarea-error @enderror"
                            required>{{ old('description') }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error text-xs sm:text-sm">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Program Image -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm sm:text-base font-medium">Program Image</span>
                        </label>
                        <input type="file" name="image"
                            class="file-input file-input-bordered w-full text-sm @error('image') file-input-error @enderror"
                            accept="image/*" required>
                        <label class="label">
                            <span class="label-text-alt text-xs text-gray-500">Accepted formats: JPG, PNG, GIF (max
                                5MB)</span>
                        </label>
                        @error('image')
                            <label class="label">
                                <span class="label-text-alt text-error text-xs sm:text-sm">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-end pt-4 border-t">
                        <a href="{{ route('admin.CMS.programs.index') }}"
                            class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center order-2 sm:order-1">
                            <span class="text-xs sm:text-sm">Cancel</span>
                        </a>
                        <button type="submit"
                            class="btn btn-accent btn-sm sm:btn-md w-full sm:w-auto justify-center order-1 sm:order-2 gap-2">
                            <i class="fi fi-rr-plus"></i>
                            <span class="text-xs sm:text-sm">Create Program</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
