  @php
        use Illuminate\Support\Facades\Storage;

        $imageUrl = $aboutUs?->path ? Storage::url($aboutUs->path) : asset('logo-modified.png');
    @endphp

<x-dashboard.admin.base>


    <div class="container mx-auto px-4 sm:px-6 lg:px-8 p-4 sm:p-6">
        <div class="mb-6">
            <h1 class="text-base sm:text-2xl md:text-3xl font-bold text-gray-800">About Us</h1>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Update About content, image, mission and vision</p>
        </div>

        <x-notification-message />

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <form action="{{ route('admin.CMS.about-us.update') }}" method="POST"  enctype="multipart/form-data" class="p-4 sm:p-6 space-y-6">

                @method('PUT')
                @csrf


                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <div class="lg:col-span-5">
                        <div class="rounded-xl overflow-hidden bg-gray-100 border">
                            <img
                                src="{{ $imageUrl }}"
                                alt="About image"
                                class="w-full h-64 sm:h-72 object-cover"
                                onerror="this.src='{{ asset('logo-modified.png') }}'"
                            >
                        </div>

                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                            <input type="file" name="image" accept="image/*"
                                   class="file-input file-input-bordered w-full @error('image') file-input-error @enderror" />
                            @error('image') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="lg:col-span-7 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" name="title" value="{{ old('title', $aboutUs->title) }}"
                                   class="input input-bordered w-full @error('title') input-error @enderror" required>
                            @error('title') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                            <input type="text" name="sub_title" value="{{ old('sub_title', $aboutUs->sub_title) }}"
                                   class="input input-bordered w-full @error('sub_title') input-error @enderror">
                            @error('sub_title') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="6"
                                      class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                                      required>{{ old('description', $aboutUs->description) }}</textarea>
                            @error('description') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address (optional)</label>
                            <input type="text" name="address" value="{{ old('address', $aboutUs->address) }}"
                                   class="input input-bordered w-full @error('address') input-error @enderror">
                            @error('address') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vision</label>
                        <textarea name="vision" rows="7"
                                  class="textarea textarea-bordered w-full @error('vision') textarea-error @enderror"
                                  placeholder="Enter vision...">{{ old('vision', $aboutUs->vision) }}</textarea>
                        @error('vision') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mission</label>
                        <textarea name="mission" rows="7"
                                  class="textarea textarea-bordered w-full @error('mission') textarea-error @enderror"
                                  placeholder="Enter mission...">{{ old('mission', $aboutUs->mission) }}</textarea>
                        @error('mission') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Legacy field (optional, for old data/backward compatibility) --}}
                <div class="pt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Mission &amp; Vision (Legacy – optional)
                    </label>
                    <textarea name="mission_and_vision" rows="4"
                              class="textarea textarea-bordered w-full @error('mission_and_vision') textarea-error @enderror"
                              placeholder="Only needed if you still use the old combined field...">{{ old('mission_and_vision', $aboutUs->mission_and_vision) }}</textarea>
                    @error('mission_and_vision') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t flex flex-col sm:flex-row gap-2 justify-end">
                    <a href="{{ route('admin.CMS.index') }}" class="btn btn-ghost w-full sm:w-auto">Back</a>
                    <button type="submit" class="btn btn-accent w-full sm:w-auto">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.admin.base>
