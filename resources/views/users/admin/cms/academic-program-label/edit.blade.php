<x-dashboard.admin.base>
    <div class="container px-4 py-8 mx-auto max-w-3xl">
        <x-dashboard.page-title :title="__('Edit Academic Program Label')" :back_url="route('admin.CMS.academic-program-label.index')" />

        <x-notification-message />

        <div class="mt-6 bg-white rounded-lg shadow-lg">
            <form action="{{ route('admin.CMS.academic-program-label.update', $label->id) }}" method="POST"
                class="p-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-medium">Title <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="title" value="{{ old('title', $label->title) }}"
                        class="input input-bordered @error('title') input-error @enderror"
                        placeholder="Enter program label title" required>
                    @error('title')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Subtitle -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-medium">Subtitle <span class="text-error">*</span></span>
                    </label>
                    <textarea name="subtitle" rows="4" class="textarea textarea-bordered @error('subtitle') textarea-error @enderror"
                        placeholder="Enter program label subtitle" required>{{ old('subtitle', $label->subtitle) }}</textarea>
                    @error('subtitle')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 justify-end">
                    <a href="{{ route('admin.CMS.academic-program-label.index') }}" class="btn btn-ghost">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-accent">
                        <i class="fi fi-rr-check"></i>
                        Update Label
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Section -->
        <div class="mt-6 bg-white rounded-lg shadow-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-error mb-2">Danger Zone</h3>
                <p class="text-sm text-gray-600 mb-4">Once you delete this label, there is no going back. Please be
                    certain.</p>
                <form action="{{ route('admin.CMS.academic-program-label.destroy', $label->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this label? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-outline">
                        <i class="fi fi-rr-trash"></i>
                        Delete Label
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
