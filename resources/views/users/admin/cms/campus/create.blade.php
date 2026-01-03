<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Add Campus</h1>
                <p class="text-sm text-gray-600">Create a new campus</p>
            </div>

            <a href="{{ route('admin.CMS.campuses.index') }}"
               class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                <i class="fi fi-rr-arrow-left"></i>
                <span class="text-xs sm:text-sm">Back</span>
            </a>
        </div>

        <x-notification-message />

        <div class="mx-auto max-w-2xl bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <form action="{{ route('admin.CMS.campuses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Campus Name</span></label>
                    <input name="name" value="{{ old('name') }}" class="input input-bordered w-full @error('name') input-error @enderror" required />
                    @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-medium text-sm sm:text-base">Email</span></label>
                        <input name="email" value="{{ old('email') }}" class="input input-bordered w-full @error('email') input-error @enderror" />
                        @error('email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text font-medium text-sm sm:text-base">Phone</span></label>
                        <input name="phone" value="{{ old('phone') }}" class="input input-bordered w-full @error('phone') input-error @enderror" />
                        @error('phone') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Address</span></label>
                    <input name="address" value="{{ old('address') }}" class="input input-bordered w-full @error('address') input-error @enderror" />
                    @error('address') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Description</span></label>
                    <textarea name="description" class="textarea textarea-bordered w-full min-h-32 @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                    @error('description') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text font-medium text-sm sm:text-base">Campus Image</span></label>
                    <input type="file" name="image" accept="image/*" class="file-input file-input-bordered w-full @error('image') file-input-error @enderror" />
                    <p class="text-xs text-gray-500 mt-1">Recommended: 1200×675 (16:9), max 5MB</p>
                    @error('image') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t flex flex-col sm:flex-row gap-3 justify-end">
                    <a href="{{ route('admin.CMS.campuses.index') }}" class="btn btn-ghost w-full sm:w-auto justify-center">Cancel</a>
                    <button class="btn btn-accent w-full sm:w-auto justify-center gap-2">
                        <i class="fi fi-rr-plus"></i>
                        Create Campus
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.admin.base>
