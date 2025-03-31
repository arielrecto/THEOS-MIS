<x-dashboard.admin.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Add Gallery Image</h1>
                    <p class="text-gray-600">Upload new images to the website gallery</p>
                </div>
                <a href="{{ route('admin.CMS.gallery.index') }}" class="btn btn-ghost gap-2">
                    <i class="fi fi-rr-arrow-left"></i>
                    Back to Gallery
                </a>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('admin.CMS.gallery.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Image Title</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               class="input input-bordered @error('name') input-error @enderror"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Description</span>
                        </label>
                        <textarea name="description"
                                  class="textarea textarea-bordered h-24 @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Image</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="file"
                               name="image"
                               class="file-input file-input-bordered w-full @error('image') file-input-error @enderror"
                               accept="image/*"
                               required>
                        @error('image')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-accent">Upload Image</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
