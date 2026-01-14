<x-dashboard.admin.base>
    <div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-4xl">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.CMS.header-contents.index') }}" class="btn btn-ghost btn-sm">
                    <i class="fi fi-rr-arrow-left"></i>
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Create Header Content</h1>
            </div>
            <p class="text-sm text-gray-600 ml-12">Add new header content for your website</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <form action="{{ route('admin.CMS.header-contents.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-semibold">Title <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="input input-bordered w-full @error('title') input-error @enderror"
                        placeholder="Enter header title" required>
                    @error('title')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Subtitle -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-semibold">Subtitle</span>
                    </label>
                    <textarea name="subtitle" rows="3"
                        class="textarea textarea-bordered w-full @error('subtitle') textarea-error @enderror"
                        placeholder="Enter subtitle or description">{{ old('subtitle') }}</textarea>
                    @error('subtitle')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Show Button -->
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" name="show_button" value="1" class="checkbox checkbox-primary"
                            {{ old('show_button') ? 'checked' : '' }} x-data
                            x-on:change="$el.checked ? $refs.buttonFields.classList.remove('hidden') : $refs.buttonFields.classList.add('hidden')">
                        <span class="label-text font-semibold">Show Button</span>
                    </label>
                </div>

                <!-- Button Fields -->
                <div x-data x-ref="buttonFields"
                    class="{{ old('show_button') ? '' : 'hidden' }} space-y-4 pl-4 border-l-2 border-primary/20">
                    <!-- Button Text -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Button Text</span>
                        </label>
                        <input type="text" name="button_text" value="{{ old('button_text') }}"
                            class="input input-bordered w-full @error('button_text') input-error @enderror"
                            placeholder="e.g., Learn More">
                        @error('button_text')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Button URL -->
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Button URL</span>
                        </label>
                        <input type="url" name="button_url" value="{{ old('button_url') }}"
                            class="input input-bordered w-full @error('button_url') input-error @enderror"
                            placeholder="https://example.com">
                        @error('button_url')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Is Active -->
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-success"
                            {{ old('is_active') ? 'checked' : '' }}>
                        <div>
                            <span class="label-text font-semibold">Set as Active</span>
                            <p class="text-xs text-gray-500 mt-1">Only one header content can be active at a time</p>
                        </div>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="btn btn-primary flex-1 sm:flex-none">
                        <i class="fi fi-rr-check"></i>
                        Create Header Content
                    </button>
                    <a href="{{ route('admin.CMS.header-contents.index') }}" class="btn btn-ghost flex-1 sm:flex-none">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.admin.base>
