<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Add Login Content</h1>
                <p class="text-sm text-gray-600">Create new login page content</p>
            </div>

            <a href="{{ route('admin.CMS.login-contents.index') }}"
               class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                <i class="fi fi-rr-arrow-left"></i>
                <span class="text-xs sm:text-sm">Back</span>
            </a>
        </div>

        <x-notification-message />

        <div class="mx-auto max-w-2xl bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <form action="{{ route('admin.CMS.login-contents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Title</span></label>
                    <input name="title" value="{{ old('title') }}" class="input input-bordered w-full @error('title') input-error @enderror" required />
                    @error('title') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Description</span></label>
                    <textarea name="description" class="textarea textarea-bordered w-full min-h-24 @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                    @error('description') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-sm" {{ old('is_active') ? 'checked' : '' }}>
                        <span class="label-text font-medium text-sm sm:text-base">Set as active</span>
                    </label>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Background Image</span></label>
                    <input type="file" name="background_image" accept="image/*" class="file-input file-input-bordered w-full @error('background_image') file-input-error @enderror" />
                    <p class="text-xs text-gray-500 mt-1">Recommended: 1920x1080px, max 5MB</p>
                    @error('background_image') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t flex flex-col sm:flex-row gap-3 justify-end">
                    <a href="{{ route('admin.CMS.login-contents.index') }}" class="btn btn-ghost w-full sm:w-auto justify-center">Cancel</a>
                    <button class="btn btn-accent w-full sm:w-auto justify-center gap-2">
                        <i class="fi fi-rr-plus"></i>
                        Create Content
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.admin.base>
