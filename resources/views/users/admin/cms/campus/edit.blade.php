<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 break-words">Edit Campus</h1>
                <p class="text-sm text-gray-600 break-words">{{ $campus->name }}</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.CMS.campuses.show', $campus) }}" class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center">Back</a>
            </div>
        </div>

        <x-notification-message />

        <div class="mx-auto max-w-2xl bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <form action="{{ route('admin.CMS.campuses.update', $campus) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Campus Name</span></label>
                    <input name="name" value="{{ old('name', $campus->name) }}" class="input input-bordered w-full @error('name') input-error @enderror" required />
                    @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-medium text-sm sm:text-base">Email</span></label>
                        <input name="email" value="{{ old('email', $campus->email) }}" class="input input-bordered w-full @error('email') input-error @enderror" />
                        @error('email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text font-medium text-sm sm:text-base">Phone</span></label>
                        <input name="phone" value="{{ old('phone', $campus->phone) }}" class="input input-bordered w-full @error('phone') input-error @enderror" />
                        @error('phone') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Address</span></label>
                    <input name="address" value="{{ old('address', $campus->address) }}" class="input input-bordered w-full @error('address') input-error @enderror" />
                    @error('address') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Description</span></label>
                    <textarea name="description" class="textarea textarea-bordered w-full min-h-32 @error('description') textarea-error @enderror">{{ old('description', $campus->description) }}</textarea>
                    @error('description') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Current image -->
                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Campus Image</span></label>

                    @if($campus->image?->file_dir)
                        <div class="mb-3 flex items-start gap-3 p-3 rounded-lg bg-gray-50">
                            <div class="w-20 h-14 rounded overflow-hidden bg-gray-100 flex-shrink-0">
                                <img src="{{ asset($campus->image->file_dir) }}" alt="{{ $campus->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-800 truncate">{{ $campus->image->name ?? 'Current image' }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $campus->image->mime ?? '' }}</div>
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
                    <a href="{{ route('admin.CMS.campuses.show', $campus) }}" class="btn btn-ghost w-full sm:w-auto justify-center">Cancel</a>
                    <button class="btn btn-accent w-full sm:w-auto justify-center gap-2">
                        <i class="fi fi-rr-edit"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.admin.base>
