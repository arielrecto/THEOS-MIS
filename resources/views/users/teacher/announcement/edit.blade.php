<x-dashboard.teacher.base>
    <div class="w-full">
        <x-dashboard.page-title
            :title="_('Edit Announcement')"
            :back_url="route('teacher.announcements.index', ['type' => 'classroom'])" />
        <x-notification-message />

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form method="POST"
                  action="{{ route('teacher.announcements.update', ['announcement' => $announcement->id]) }}"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="classroom">

                <!-- Title -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Title</label>
                    <input type="text"
                           name="title"
                           value="{{ old('title', $announcement->title) }}"
                           class="input input-bordered w-full @error('title') input-error @enderror">
                    @error('title')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description"
                              rows="4"
                              class="textarea textarea-bordered w-full @error('description') textarea-error @enderror">{{ old('description', $announcement->description) }}</textarea>
                    @error('description')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Attachment -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">File Attachment</label>
                    @if($announcement->file_dir)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg mb-4">
                            <div class="flex items-center space-x-3">
                                <i class="fi fi-rr-document text-2xl text-accent"></i>
                                <span class="text-sm">Current attachment</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ asset($announcement->file_dir) }}"
                                   class="btn btn-sm btn-accent"
                                   download>
                                    <i class="fi fi-rr-download mr-2"></i>
                                    Download
                                </a>
                                <button type="button"
                                        onclick="removeFile()"
                                        class="btn btn-sm btn-error">
                                    <i class="fi fi-rr-trash mr-2"></i>
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endif
                    <input type="file"
                           name="attachment"
                           class="file-input file-input-bordered w-full @error('attachment') file-input-error @enderror">
                    @error('attachment')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-2">
                    <a href="{{ route('teacher.announcements.index', ['type' => 'classroom']) }}"
                       class="btn btn-ghost">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-accent">
                        Update Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function removeFile() {
            if (confirm('Are you sure you want to remove the current file?')) {
                fetch(`{{ route('teacher.announcements.remove-file', $announcement->id) }}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            }
        }
    </script>
    @endpush
</x-dashboard.teacher.base>
