<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 break-words">Edit Login Content</h1>
                <p class="text-sm text-gray-600 break-words">{{ $loginContent->title }}</p>
            </div>

            <a href="{{ route('admin.CMS.login-contents.show', $loginContent) }}"
               class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center">
                Back
            </a>
        </div>

        <x-notification-message />

        <div class="mx-auto max-w-2xl bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <form action="{{ route('admin.CMS.login-contents.update', $loginContent) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Title</span></label>
                    <input name="title" value="{{ old('title', $loginContent->title) }}" class="input input-bordered w-full @error('title') input-error @enderror" required />
                    @error('title') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Description</span></label>
                    <textarea name="description" class="textarea textarea-bordered w-full min-h-24 @error('description') textarea-error @enderror">{{ old('description', $loginContent->description) }}</textarea>
                    @error('description') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-sm" {{ old('is_active', $loginContent->is_active) ? 'checked' : '' }}>
                        <span class="label-text font-medium text-sm sm:text-base">Active</span>
                    </label>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Background Image</span></label>

                    @if($loginContent->backgroundImage?->file_dir)
                        <div class="mb-3 rounded-lg overflow-hidden bg-gray-100 border">
                            <img src="{{ asset($loginContent->backgroundImage->file_dir) }}" alt="{{ $loginContent->title }}" class="w-full h-48 object-cover">
                        </div>
                        <label class="inline-flex items-center gap-2 cursor-pointer text-sm mb-2">
                            <input type="checkbox" name="remove_background_image" value="1" class="checkbox checkbox-sm" />
                            <span class="text-xs text-gray-600">Remove current image</span>
                        </label>
                    @endif

                    <input type="file" name="background_image" accept="image/*" class="file-input file-input-bordered w-full @error('background_image') file-input-error @enderror" />
                    <p class="text-xs text-gray-500 mt-1">Upload new image to replace current one</p>
                    @error('background_image') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t flex flex-col sm:flex-row gap-3 justify-end">
                    <a href="{{ route('admin.CMS.login-contents.show', $loginContent) }}" class="btn btn-ghost w-full sm:w-auto justify-center">Cancel</a>
                    <button class="btn btn-accent w-full sm:w-auto justify-center gap-2">
                        <i class="fi fi-rr-edit"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.admin.base>
