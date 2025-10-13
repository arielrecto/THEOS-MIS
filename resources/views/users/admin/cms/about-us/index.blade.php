<x-dashboard.admin.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">About Us Management</h1>
            <p class="text-gray-600">Manage your website's about us content</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm">
            <form action="{{ route('admin.CMS.about-us.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Title Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Title</span>
                                <span class="label-text-alt text-error">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   class="input input-bordered @error('title') input-error @enderror"
                                   value="{{ old('title', $aboutUs->title) }}"
                                   required>
                            @error('title')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Subtitle</span>
                            </label>
                            <input type="text"
                                   name="sub_title"
                                   class="input input-bordered @error('sub_title') input-error @enderror"
                                   value="{{ old('sub_title', $aboutUs->sub_title) }}">
                            @error('sub_title')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Featured Image</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <input type="file"
                                       name="image"
                                       class="file-input file-input-bordered w-full @error('image') file-input-error @enderror"
                                       accept="image/*">
                                @error('image')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                            @if($aboutUs->path)
                                <div class="aspect-video rounded-lg overflow-hidden bg-gray-100">
                                    <img src="{{ Storage::url($aboutUs->path) }}"
                                         alt="About Us Image"
                                         class="w-full h-full object-cover">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Description</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <textarea name="description"
                                  class="textarea textarea-bordered h-32 @error('description') textarea-error @enderror"
                                  required>{{ old('description', $aboutUs->description) }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Mission and Vision -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Mission & Vision</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <textarea name="mission_and_vision"
                                  class="textarea textarea-bordered h-32 @error('mission_and_vision') textarea-error @enderror"
                                  required>{{ old('mission_and_vision', $aboutUs->mission_and_vision) }}</textarea>
                        @error('mission_and_vision')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>


                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Address</span>
                            <span class="label-text-alt text-error">*</span>
                        </label>
                        <textarea name="address"
                                  class="textarea textarea-bordered h-32 @error('address') textarea-error @enderror"
                                  required>{{ old('address', $aboutUs->address) }}</textarea>
                        @error('address')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end mt-6 pt-6 border-t">
                    <button type="submit" class="btn btn-accent">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.admin.base>
