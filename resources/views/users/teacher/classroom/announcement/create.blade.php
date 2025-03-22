<x-dashboard.teacher.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Create Announcement')" :back_url="route('teacher.classrooms.show', ['classroom' => $classroom_id])" />

    <div class="w-full">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('teacher.announcements.store') }}"
                  method="post"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <!-- Title Input -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Announcement Title</span>
                    </label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           class="input input-bordered w-full @error('title') input-error @enderror"
                           placeholder="Enter announcement title">
                    @error('title')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <input type="text" name="classroom_id" value="{{$classroom_id}}" hidden>

                <!-- Description Input -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Description</span>
                    </label>
                    <textarea name="description"
                              class="textarea textarea-bordered min-h-[200px] @error('description') textarea-error @enderror"
                              placeholder="Enter announcement details">{{ old('description') }}</textarea>
                    @error('description')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Attachment Input -->
                <div class="form-control" x-data="{ fileName: '' }">
                    <label class="label">
                        <span class="label-text font-medium">Attachment (Optional)</span>
                    </label>
                    <div class="border-2 border-dashed border-base-300 rounded-lg p-6">
                        <input type="file"
                               name="attachment"
                               id="attachment"
                               class="hidden"
                               @change="fileName = $event.target.files[0]?.name">
                        <label for="attachment"
                               class="flex flex-col items-center justify-center cursor-pointer">
                            <i class="fi fi-rr-file-upload text-3xl mb-2 text-accent"></i>
                            <span class="text-sm font-medium" x-text="fileName || 'Click to upload file'"></span>
                            <span class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX up to 10MB</span>
                        </label>
                    </div>
                    @error('attachment')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>



                <!-- Submit Button -->
                <div class="flex justify-end gap-2">
                    <a href="{{route('teacher.classrooms.show', ['classroom' => $classroom_id]) }}"
                       class="btn btn-ghost">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-accent">
                        <i class="fi fi-rr-paper-plane mr-2"></i>
                        Post Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.teacher.base>
