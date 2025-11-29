<x-dashboard.admin.base>
    <div class="container mx-auto px-4 sm:px-6 p-4 sm:p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Add Gallery Image</h1>
                    <p class="text-sm sm:text-gray-600 mt-1">Upload new images to the website gallery</p>
                </div>

                <a href="{{ route('admin.CMS.gallery.index') }}"
                   class="btn btn-ghost gap-2 mt-2 sm:mt-0 whitespace-nowrap">
                    <i class="fi fi-rr-arrow-left"></i>
                    <span class="hidden sm:inline">Back to Gallery</span>
                </a>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="max-w-xl w-full mx-auto">
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                <form action="{{ route('admin.CMS.gallery.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-5">
                    @csrf

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm">Image Title</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               class="input input-bordered w-full @error('name') input-error @enderror"
                               value="{{ old('name') }}"
                               required
                               aria-required="true"
                               placeholder="Enter a short title">
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm">Description</span>
                        </label>
                        <textarea name="description"
                                  class="textarea textarea-bordered w-full h-28 @error('description') textarea-error @enderror"
                                  placeholder="Optional short description">{{ old('description') }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Image preview + file input -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm">Image</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>

                        <div class="w-full flex flex-col sm:flex-row sm:items-center gap-3">
                            <div class="w-full sm:w-1/2">
                                <div id="previewContainer" class="w-full h-44 sm:h-36 bg-gray-50 rounded border flex items-center justify-center overflow-hidden">
                                    <img id="imagePreview" src="#" alt="Preview" class="hidden w-full h-full object-contain" />
                                    <span id="previewPlaceholder" class="text-xs text-gray-400 text-center px-3">No image selected</span>
                                </div>
                            </div>

                            <div class="w-full sm:w-1/2 flex flex-col gap-3">
                                <input id="image" type="file"
                                       name="image"
                                       class="file-input file-input-bordered w-full @error('image') file-input-error @enderror"
                                       accept="image/*"
                                       required
                                       aria-required="true">
                                @error('image')
                                    <span class="text-xs text-error">{{ $message }}</span>
                                @enderror

                                <small class="text-xs text-gray-500">Recommended: JPG/PNG. Max 5MB.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm">Category</span>
                        </label>

                        <select name="category" id="category" class="select select-bordered w-full">
                            <option value="" disabled selected>Select a category</option>
                            <option value="school events" {{ old('category') === 'school events' ? 'selected' : '' }}>School Events</option>
                            <option value="academic events" {{ old('category') === 'academic events' ? 'selected' : '' }}>Academic Events</option>
                            <option value="campus life" {{ old('category') === 'campus life' ? 'selected' : '' }}>Campus Life</option>
                            <option value="activities" {{ old('category') === 'activities' ? 'selected' : '' }}>Activities</option>
                        </select>
                        @error('category')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-accent w-full sm:w-auto">
                            Upload Image
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            (function () {
                const input = document.getElementById('image');
                const preview = document.getElementById('imagePreview');
                const placeholder = document.getElementById('previewPlaceholder');

                if (!input) return;

                input.addEventListener('change', function (e) {
                    const file = e.target.files && e.target.files[0];
                    if (!file) {
                        preview.src = '#';
                        preview.classList.add('hidden');
                        placeholder.classList.remove('hidden');
                        return;
                    }

                    const url = URL.createObjectURL(file);
                    preview.src = url;
                    preview.onload = () => URL.revokeObjectURL(url);
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                });
            })();
        </script>
    @endpush
</x-dashboard.admin.base>
