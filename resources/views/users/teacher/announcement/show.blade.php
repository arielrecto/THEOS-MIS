<x-dashboard.teacher.base>
    <div class="w-full">
        <x-dashboard.page-title :title="_('Announcement Details')" :back_url="route('teacher.announcements.index', ['type' => request()->type ?? 'general'])" />
        <x-notification-message />

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="border-b border-gray-200">
                <div class="px-4 py-3 sm:px-6 sm:py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-start sm:items-center gap-4 min-w-0">
                            <div class="avatar flex-shrink-0 mt-1">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full overflow-hidden">
                                    @if ($announcement instanceof \App\Models\GeneralAnnouncement)
                                        <img src="{{ $announcement->postedBy->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($announcement->postedBy->name) }}"
                                            alt="Profile" class="object-cover w-full h-full">
                                    @else
                                        <img src="{{ $announcement->classroom->teacher->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($announcement->classroom->teacher->name) }}"
                                            alt="Profile" class="object-cover w-full h-full">
                                    @endif
                                </div>
                            </div>

                            <div class="min-w-0">
                                <h3 class="font-semibold text-base sm:text-lg truncate">
                                    @if ($announcement instanceof \App\Models\GeneralAnnouncement)
                                        {{ $announcement->postedBy->name }}
                                        <span class="ml-2 text-xs inline-block px-2 py-0.5 rounded bg-gray-100 text-gray-600">General</span>
                                    @else
                                        {{ $announcement->classroom->teacher->name }}
                                        <span class="ml-2 text-xs inline-block px-2 py-0.5 rounded bg-gray-100 text-gray-600">{{ $announcement->classroom->subject->name }}</span>
                                    @endif
                                </h3>
                                <p class="text-xs text-gray-500 mt-1 sm:mt-0">
                                    Posted {{ $announcement->created_at->format('F j, Y \a\t g:i A') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('teacher.announcements.index', ['type' => request()->type ?? 'general']) }}"
                               class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-sm border border-gray-200 bg-white hover:bg-gray-50">
                                <i class="fi fi-rr-arrow-left"></i>
                                <span class="hidden sm:inline">Back</span>
                            </a>

                            @if ($announcement->file_dir || ($announcement instanceof \App\Models\GeneralAnnouncement && $announcement->attachments->count()))
                                <button id="open-attachments" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-sm bg-accent text-white hover:opacity-95">
                                    <i class="fi fi-rr-paperclip"></i>
                                    <span class="hidden sm:inline">Attachments</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-4 sm:p-6">
                <h2 class="mb-3 text-lg sm:text-2xl font-bold leading-tight break-words">{{ $announcement->title }}</h2>
                <div class="mb-6 max-w-none prose prose-sm sm:prose sm:prose-lg text-gray-800 break-words">
                    {!! nl2br(e($announcement->description)) !!}
                </div>

                <!-- Attachments Section (cards collapse on small screens) -->
                @if ($announcement instanceof \App\Models\GeneralAnnouncement)
                    @if ($announcement->attachments->count() > 0)
                        <div class="mt-4">
                            <h4 class="mb-3 text-sm font-semibold text-gray-800">Attachments</h4>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                @foreach ($announcement->attachments as $attachment)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="flex-shrink-0 w-10 h-10 rounded bg-white border flex items-center justify-center text-accent">
                                                <i class="fi fi-rr-document text-xl"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium truncate">{{ $attachment->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ \Illuminate\Support\Str::limit($attachment->mime ?? '', 30) }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ asset($attachment->file_dir) }}" class="ml-3 btn btn-sm btn-accent flex-shrink-0" download>
                                            <i class="fi fi-rr-download mr-1"></i>
                                            <span class="hidden sm:inline">Download</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    @if ($announcement->file_dir)
                        <div class="mt-4">
                            <h4 class="mb-3 text-sm font-semibold text-gray-800">Attachment</h4>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="flex-shrink-0 w-10 h-10 rounded bg-white border flex items-center justify-center text-accent">
                                        <i class="fi fi-rr-document text-xl"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium truncate">Attached File</p>
                                        <p class="text-xs text-gray-500 truncate">{{ basename($announcement->file_dir) }}</p>
                                    </div>
                                </div>
                                <a href="{{ asset($announcement->file_dir) }}" class="ml-3 btn btn-sm btn-accent flex-shrink-0" download>
                                    <i class="fi fi-rr-download mr-1"></i>
                                    <span class="hidden sm:inline">Download</span>
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Comments Section -->
        <div class="mt-6 bg-white rounded-lg shadow-lg p-4 sm:p-6">
            <h3 class="mb-4 text-base sm:text-lg font-semibold">Comments</h3>

            <!-- Comments List -->
            <div class="space-y-4">
                @forelse($announcement->comments->sortByDesc('created_at') as $comment)
                    <x-commentThread :comment="$comment" :url="route('teacher.announcements.comments.reply', ['comment' => $comment->id])" :deleteUrl="route('teacher.announcements.comments.destroy', ['comment' => $comment->id])" />
                @empty
                    <div class="py-8 text-center text-gray-500">
                        <i class="mb-2 text-3xl fi fi-rr-comment-alt"></i>
                        <p>No comments yet</p>
                    </div>
                @endforelse
            </div>

            <!-- New Comment Form -->
            <form action="{{ route('teacher.announcements.comments.store', [
                'announcement' => $announcement->id,
                'type' => $announcement instanceof \App\Models\GeneralAnnouncement ? 'general' : 'classroom'
            ]) }}" method="POST" class="mt-6">
                @csrf
                <div class="form-control">
                    <label class="label">
                        <span class="font-medium label-text">Add a comment</span>
                    </label>
                    <textarea name="content"
                             class="textarea textarea-bordered min-h-[100px] w-full @error('content') textarea-error @enderror"
                             placeholder="Write your comment here..."></textarea>
                    @error('content')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4">
                    <div class="text-xs text-gray-500 hidden sm:block">
                        Be respectful. Your comment will be visible to others.
                    </div>

                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="btn btn-accent w-full sm:w-auto inline-flex items-center justify-center">
                            <i class="fi fi-rr-comment mr-2"></i>
                            Post Comment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Form -->
    <form id="deleteForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
        <script>
            function confirmDelete(id, type) {
                if (confirm('Are you sure you want to delete this announcement?')) {
                    const form = document.getElementById('deleteForm');
                    form.action = `{{ route('teacher.announcements.destroy', '') }}/${id}?type=${type}`;
                    form.submit();
                }
            }

            // Optional: simple attachments toggle for mobile
            document.addEventListener('DOMContentLoaded', function () {
                const btn = document.getElementById('open-attachments');
                if (!btn) return;
                btn.addEventListener('click', function () {
                    // scroll to attachments section if present
                    const attachmentsHeading = document.querySelector('h4:contains("Attachments"), h4:contains("Attachment")');
                    if (attachmentsHeading) {
                        attachmentsHeading.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        window.scrollBy({ top: 400, behavior: 'smooth' });
                    }
                });
            });
        </script>
    @endpush
</x-dashboard.teacher.base>
