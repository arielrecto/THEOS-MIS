<x-dashboard.admin.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Add Academic Program</h1>
                    <p class="text-gray-600">Create a new academic program</p>
                </div>
                <a href="{{ route('admin.CMS.programs.index') }}" class="btn btn-ghost gap-2">
                    <i class="fi fi-rr-arrow-left"></i>
                    Back to Programs
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('admin.CMS.programs.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    <div class="form-control">
                        <label class="label">Title</label>
                        <input type="text"
                               name="title"
                               class="input input-bordered @error('title') input-error @enderror"
                               value="{{ old('title') }}"
                               required>
                        @error('title')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">Category</label>
                        <select name="category"
                                class="select select-bordered w-full @error('category') select-error @enderror"
                                required>
                            <option value="">Select a category</option>
                            <option value="Pre-School" {{ old('category') === 'Pre-School' ? 'selected' : '' }}>Pre-School</option>
                            <option value="Elementary" {{ old('category') === 'Elementary' ? 'selected' : '' }}>Elementary</option>
                            <option value="Junior High School" {{ old('category') === 'Junior High School' ? 'selected' : '' }}>Junior High School</option>
                            <option value="Senior High School" {{ old('category') === 'Senior High School' ? 'selected' : '' }}>Senior High School</option>
                        </select>
                        @error('category')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">Description</label>
                        <textarea name="description"
                                  class="textarea textarea-bordered h-32 @error('description') textarea-error @enderror"
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">Program Image</label>
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
                        <button type="submit" class="btn btn-accent">Create Program</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
