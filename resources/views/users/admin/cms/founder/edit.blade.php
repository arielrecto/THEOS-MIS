{{-- filepath: e:\Projects\Theos MIS\resources\views\users\admin\cms\founder\edit.blade.php --}}
<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 break-words">Edit Founder</h1>
                <p class="text-sm text-gray-600 break-words">{{ $founder->name }}</p>
            </div>

            <a href="{{ route('admin.CMS.founders.show', $founder) }}"
               class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center">
                Back
            </a>
        </div>

        <x-notification-message />

        <div class="mx-auto max-w-2xl bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <form action="{{ route('admin.CMS.founders.update', $founder) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Name</span></label>
                    <input name="name" value="{{ old('name', $founder->name) }}" class="input input-bordered w-full @error('name') input-error @enderror" required />
                    @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Bio</span></label>
                    <textarea name="bio" class="textarea textarea-bordered w-full min-h-32 @error('bio') textarea-error @enderror">{{ old('bio', $founder->bio) }}</textarea>
                    @error('bio') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-sm" {{ old('is_active', $founder->is_active) ? 'checked' : '' }}>
                        <span class="label-text font-medium text-sm sm:text-base">Active</span>
                    </label>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Profile Image</span></label>

                    @if($founder->image?->file_dir)
                        <div class="mb-3 flex items-start gap-3 p-3 rounded-lg bg-gray-50">
                            <div class="w-16 h-16 rounded overflow-hidden bg-gray-100 flex-shrink-0">
                                <img src="{{ asset($founder->image->file_dir) }}" alt="{{ $founder->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-800 truncate">{{ $founder->image->file_name ?? 'Current image' }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $founder->image->file_type ?? '' }}</div>
                                <label class="mt-2 inline-flex items-center gap-2 cursor-pointer text-sm">
                                    <input type="checkbox" name="remove_image" value="1" class="checkbox checkbox-sm" />
                                    <span class="text-xs text-gray-600">Remove current image</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <input type="file" name="image" accept="image/*" class="file-input file-input-bordered w-full @error('image') file-input-error @enderror" />
                    <p class="text-xs text-gray-500 mt-1">Upload a new image to replace the current one</p>
                    @error('image') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t flex flex-col sm:flex-row gap-3 justify-end">
                    <a href="{{ route('admin.CMS.founders.show', $founder) }}" class="btn btn-ghost w-full sm:w-auto justify-center">Cancel</a>
                    <button class="btn btn-accent w-full sm:w-auto justify-center gap-2">
                        <i class="fi fi-rr-edit"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.admin.base>
