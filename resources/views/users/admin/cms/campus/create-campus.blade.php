<x-dashboard.admin.base>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm breadcrumbs mb-4">
                <a href="{{ route('admin.CMS.campus-content.index') }}" class="text-gray-600 hover:text-primary">
                    Campus Content
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900">Create New</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Create Campus Content</h1>
            <p class="text-sm text-gray-600 mt-1">Add a new campus section content</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('admin.CMS.campus-content.store') }}" method="POST">
                @csrf

                <!-- Title -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Title <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="input input-bordered w-full @error('title') input-error @enderror"
                        placeholder="e.g., Our Campuses" required>
                    @error('title')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Description <span class="text-error">*</span></span>
                    </label>
                    <textarea name="description" rows="5"
                        class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                        placeholder="Enter campus section description..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-gray-500">
                            This description will be shown at the top of the campus section
                        </span>
                    </label>
                </div>

                <!-- Is Active -->
                <div class="form-control mb-6">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-primary"
                            {{ old('is_active', true) ? 'checked' : '' }}>
                        <div>
                            <span class="label-text font-semibold">Set as Active</span>
                            <p class="text-xs text-gray-500 mt-1">
                                Only one campus content can be active. Setting this as active will deactivate others.
                            </p>
                        </div>
                    </label>
                    @error('is_active')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t">
                    <button type="submit" class="btn btn-primary gap-2 flex-1 sm:flex-none">
                        <i class="fi fi-rr-check"></i>
                        Create Campus Content
                    </button>
                    <a href="{{ route('admin.CMS.campus-content.index') }}"
                        class="btn btn-ghost gap-2 flex-1 sm:flex-none">
                        <i class="fi fi-rr-cross"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.admin.base>
