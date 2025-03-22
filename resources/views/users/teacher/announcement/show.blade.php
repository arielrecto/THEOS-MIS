<x-dashboard.teacher.base>
    <div class="w-full">
        <x-dashboard.page-title :title="_('Announcement Details')" :back_url="route('teacher.announcements.index', ['type' => request()->type ?? 'general'])" />
        <x-notification-message />

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="avatar">
                                <div class="w-12 h-12 rounded-full">
                                    @if ($announcement instanceof \App\Models\GeneralAnnouncement)
                                        <img src="{{ $announcement->postedBy->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($announcement->postedBy->name) }}"
                                            alt="Profile">
                                    @else
                                        <img src="{{ $announcement->classroom->teacher->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($announcement->classroom->teacher->name) }}"
                                            alt="Profile">
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h3 class="font-medium">
                                    @if ($announcement instanceof \App\Models\GeneralAnnouncement)
                                        {{ $announcement->postedBy->name }}
                                        <span class="badge badge-accent ml-2">General</span>
                                    @else
                                        {{ $announcement->classroom->teacher->name }}
                                        <span
                                            class="badge badge-accent ml-2">{{ $announcement->classroom->subject->name }}</span>
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Posted {{ $announcement->created_at->format('F j, Y \a\t g:i A') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            {{-- <a href="{{ route('teacher.announcements.edit', ['id' => $announcement->id, 'type' => request()->type]) }}"
                               class="btn btn-sm btn-outline btn-warning">
                                <i class="fi fi-rr-edit mr-2"></i>
                                {{ __('Edit') }}
                            </a>
                            <button onclick="confirmDelete('{{ $announcement->id }}', '{{ request()->type }}')"
                                    class="btn btn-sm btn-outline btn-error">
                                <i class="fi fi-rr-trash mr-2"></i>
                                {{ __('Delete') }}
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">{{ $announcement->title }}</h2>
                <div class="prose max-w-none mb-6">
                    {{ $announcement->description }}
                </div>

                <!-- Attachments Section -->
                @if ($announcement instanceof \App\Models\GeneralAnnouncement)
                    @if ($announcement->attachments->count() > 0)
                        <div class="mt-6">
                            <h4 class="font-medium text-gray-900 mb-4">Attachments</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($announcement->attachments as $attachment)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <i class="fi fi-rr-document text-2xl text-accent"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $attachment->name }}
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ asset($attachment->file_dir) }}" class="btn btn-sm btn-accent"
                                            download>
                                            <i class="fi fi-rr-download mr-2"></i>
                                            Download
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    @if ($announcement->file_dir)
                        <div class="mt-6">
                            <h4 class="font-medium text-gray-900 mb-4">Attachment</h4>
                            <div class="p-4 bg-gray-50 rounded-lg flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <i class="fi fi-rr-document text-2xl text-accent"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            Attached File
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ asset($announcement->file_dir) }}" class="btn btn-sm btn-accent" download>
                                    <i class="fi fi-rr-download mr-2"></i>
                                    Download
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Comments Section -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-6">Comments</h3>

            <!-- Comments List -->
            <div class="space-y-6">
                @forelse($announcement->comments->sortByDesc('created_at') as $comment)
                    <div class="flex space-x-4">
                        <div class="flex-shrink-0">
                            <div class="avatar">
                                <div class="w-10 h-10 rounded-full">
                                    <img src="{{ $comment->user->studentProfile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                                         alt="{{ $comment->user->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium">{{ $comment->user->name }}</h4>
                                    <p class="text-xs text-gray-500">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                @if($comment->user_id === auth()->id())
                                    <form method="POST"
                                          action="{{ route('teacher.announcements.comments.destroy', ['comment' => $comment->id]) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost btn-sm text-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="mt-2 text-gray-700">
                                {{ $comment->content }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fi fi-rr-comment-alt text-3xl mb-2"></i>
                        <p>No comments yet</p>
                    </div>
                @endforelse
            </div>

            <!-- New Comment Form -->
            <form action="{{ route('teacher.announcements.comments.store', [
                'announcement' => $announcement->id,
                'type' => $announcement instanceof \App\Models\GeneralAnnouncement ? 'general' : 'classroom'
            ]) }}" method="POST" class="mt-8">
                @csrf
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Add a comment</span>
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
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="btn btn-accent">
                        <i class="fi fi-rr-comment mr-2"></i>
                        Post Comment
                    </button>
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
        </script>
    @endpush
</x-dashboard.teacher.base>
