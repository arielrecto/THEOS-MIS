<x-dashboard.teacher.base>
    <div class="w-full">
        <x-dashboard.page-title
            :title="_('Edit Announcement')"
            :back_url="route('teacher.announcements.index', ['type' => 'classroom'])" />
        <x-notification-message />

        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-4 sm:p-6">
                <form method="POST"
                      action="{{ route('teacher.announcements.update', ['announcement' => $announcement->id]) }}"
                      enctype="multipart/form-data"
                      class="space-y-5">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="classroom">

                    <!-- Title -->
                    <div class="space-y-2">
                        <label class="text-sm sm:text-base font-medium text-gray-700">Title</label>
                        <input type="text"
                               name="title"
                               value="{{ old('title', $announcement->title) }}"
                               class="input input-bordered w-full text-sm sm:text-base @error('title') input-error @enderror"
                               aria-label="Announcement title"
                               placeholder="Enter a concise title">
                        @error('title')
                            <p class="text-error text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label class="text-sm sm:text-base font-medium text-gray-700">Description</label>
                        <textarea name="description"
                                  rows="5"
                                  class="textarea textarea-bordered w-full text-sm sm:text-base @error('description') textarea-error @enderror"
                                  placeholder="Write the announcement details...">{{ old('description', $announcement->description) }}</textarea>
                        @error('description')
                            <p class="text-error text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Attachment -->
                    <div class="space-y-2">
                        <label class="text-sm sm:text-base font-medium text-gray-700">File Attachment</label>

                        @if($announcement->file_dir)
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-3 bg-gray-50 rounded-lg mb-3 gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-12 h-12 flex items-center justify-center bg-white border rounded text-accent">
                                        <i class="fi fi-rr-document text-lg"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm sm:text-base font-medium truncate">{{ basename($announcement->file_dir) }}</p>
                                        <p class="text-xs text-gray-500 truncate">Current attachment</p>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-2 w-full sm:w-auto">
                                    <a href="{{ asset($announcement->file_dir) }}"
                                       class="btn btn-sm btn-accent w-full sm:w-auto inline-flex items-center justify-center"
                                       download
                                       aria-label="Download attachment">
                                        <i class="fi fi-rr-download mr-2"></i>
                                        <span class="text-xs sm:text-sm">Download</span>
                                    </a>

                                    <button type="button"
                                            onclick="removeFile()"
                                            class="btn btn-sm btn-error w-full sm:w-auto inline-flex items-center justify-center"
                                            aria-label="Remove current attachment">
                                        <i class="fi fi-rr-trash mr-2"></i>
                                        <span class="text-xs sm:text-sm">Remove</span>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                            <input type="file"
                                   name="attachment"
                                   class="file-input file-input-bordered w-full text-sm @error('attachment') file-input-error @enderror"
                                   aria-label="Upload attachment">
                            <div class="text-xs text-gray-500 mt-1 sm:mt-0">
                                Accepted formats: pdf, docx, jpg, png — max 10MB
                            </div>
                        </div>

                        @error('attachment')
                            <p class="text-error text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button (stacked on mobile, inline on larger screens) -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3">
                        <a href="{{ route('teacher.announcements.index', ['type' => 'classroom']) }}"
                           class="btn btn-ghost w-full sm:w-auto text-center">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-accent w-full sm:w-auto inline-flex items-center justify-center"
                                aria-label="Update announcement">
                            <i class="fi fi-rr-edit mr-2"></i>
                            <span class="text-sm sm:text-base">Update Announcement</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function removeFile() {
            if (!confirm('Are you sure you want to remove the current file?')) return;
            fetch(`{{ route('teacher.announcements.remove-file', $announcement->id) }}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    // show a subtle success then reload to reflect changes
                    window.location.reload();
                } else {
                    response.json().then(data => {
                        alert(data.message || 'Failed to remove file.');
                    }).catch(() => alert('Failed to remove file.'));
                }
            }).catch(() => alert('Network error. Try again.'));
        }
    </script>
    @endpush
</x-dashboard.teacher.base>
