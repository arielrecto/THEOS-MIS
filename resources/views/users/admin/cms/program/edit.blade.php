<x-dashboard.admin.base>
    <div class="container px-4 py-8 mx-auto max-w-4xl">
        <x-dashboard.page-title :title="__('Edit Academic Program')" 
            :back_url="route('admin.CMS.programs.index')" />

        <x-notification-message />

        <div class="mt-6 bg-white rounded-lg shadow-lg">
            <form action="{{ route('admin.CMS.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <!-- Current Image Preview -->
                <div class="mb-6">
                    <label class="label">
                        <span class="label-text font-medium">Current Image</span>
                    </label>
                    <div class="relative w-full h-64 bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ Storage::url($program->path) }}" 
                             alt="{{ $program->title }}"
                             class="w-full h-full object-cover"
                             id="currentImage">
                    </div>
                </div>

                <!-- Title -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-medium">Program Title <span class="text-error">*</span></span>
                    </label>
                    <input type="text" 
                           name="title" 
                           value="{{ old('title', $program->title) }}" 
                           class="input input-bordered @error('title') input-error @enderror" 
                           placeholder="Enter program title" 
                           required>
                    @error('title')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Category -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-medium">Category <span class="text-error">*</span></span>
                    </label>
                    <select name="category" 
                            class="select select-bordered @error('category') select-error @enderror" 
                            required>
                        <option value="" disabled>Select a category</option>
                        <option value="Elementary" {{ old('category', $program->category) == 'Elementary' ? 'selected' : '' }}>Elementary</option>
                        <option value="Junior High School" {{ old('category', $program->category) == 'Junior High School' ? 'selected' : '' }}>Junior High School</option>
                        <option value="Senior High School" {{ old('category', $program->category) == 'Senior High School' ? 'selected' : '' }}>Senior High School</option>
                        <option value="Special Programs" {{ old('category', $program->category) == 'Special Programs' ? 'selected' : '' }}>Special Programs</option>
                    </select>
                    @error('category')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-medium">Description <span class="text-error">*</span></span>
                    </label>
                    <textarea name="description" 
                              rows="6" 
                              class="textarea textarea-bordered @error('description') textarea-error @enderror" 
                              placeholder="Enter program description" 
                              required>{{ old('description', $program->description) }}</textarea>
                    @error('description')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- New Image Upload -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-medium">Update Image <span class="text-gray-500 text-xs">(Optional - leave empty to keep current image)</span></span>
                    </label>
                    <input type="file" 
                           name="image" 
                           accept="image/jpeg,image/png,image/jpg"
                           class="file-input file-input-bordered @error('image') file-input-error @enderror"
                           onchange="previewImage(event)">
                    <label class="label">
                        <span class="label-text-alt text-gray-500">Accepted formats: JPG, JPEG, PNG (Max: 2MB)</span>
                    </label>
                    @error('image')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Image Preview -->
                <div class="mb-6" id="imagePreviewContainer" style="display: none;">
                    <label class="label">
                        <span class="label-text font-medium">New Image Preview</span>
                    </label>
                    <div class="relative w-full h-64 bg-gray-100 rounded-lg overflow-hidden">
                        <img id="imagePreview" class="w-full h-full object-cover" alt="Preview">
                    </div>
                </div>

                <!-- Status Toggle -->
                <div class="form-control mb-6">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $program->is_active) ? 'checked' : '' }}
                               class="checkbox checkbox-accent">
                        <span class="label-text font-medium">Set as Active</span>
                    </label>
                    <label class="label">
                        <span class="label-text-alt text-gray-500">Active programs will be displayed on the website</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 justify-end pt-4 border-t">
                    <a href="{{ route('admin.CMS.programs.index') }}" class="btn btn-ghost">
                        <i class="fi fi-rr-cross-small"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-accent">
                        <i class="fi fi-rr-check"></i>
                        Update Program
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="mt-6 bg-white rounded-lg shadow-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-error mb-2 flex items-center gap-2">
                    <i class="fi fi-rr-triangle-warning"></i>
                    Danger Zone
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Once you delete this program, there is no going back. Please be certain.
                </p>
                <form action="{{ route('admin.CMS.programs.destroy', $program->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this program? This action cannot be undone and will also delete the associated image.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-outline">
                        <i class="fi fi-rr-trash"></i>
                        Delete Program
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const container = document.getElementById('imagePreviewContainer');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                container.style.display = 'none';
            }
        }
    </script>
    @endpush
</x-dashboard.admin.base>