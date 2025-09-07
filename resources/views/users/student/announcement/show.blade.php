<x-dashboard.student.base>
    <div class="w-full">
        <x-dashboard.page-title :title="_('Announcement Details')" :back_url="route('student.announcements.index')" />
        <x-notification-message />

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Announcement Header -->
            <div class="border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="avatar">
                                <div class="w-12 h-12 rounded-full">
                                    @if($announcement instanceof \App\Models\GeneralAnnouncement)
                                        <img src="{{ $announcement->postedBy->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($announcement->postedBy->name) }}"
                                             alt="Profile">
                                    @else
                                        <img src="{{ $announcement->classroom->teacher->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($announcement->classroom->teacher->name) }}"
                                             alt="Profile">
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h3 class="font-medium text-lg">
                                    @if($announcement instanceof \App\Models\GeneralAnnouncement)
                                        {{ $announcement->postedBy->name }}
                                    @else
                                        {{ $announcement->classroom->teacher->name }}
                                        <span class="text-sm text-gray-500">
                                            {{ $announcement->classroom->subject->name }} Class
                                        </span>
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Posted {{ $announcement->created_at->format('F j, Y \a\t g:i A') }}
                                </p>
                            </div>
                        </div>
                        <div class="badge badge-accent">
                            {{ $announcement instanceof \App\Models\GeneralAnnouncement ? 'General' : 'Classroom' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Announcement Content -->
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">{{ $announcement->title }}</h2>
                <div class="prose max-w-none">
                    <p>{{ $announcement->description }}</p>
                </div>

                @if($announcement instanceof \App\Models\GeneralAnnouncement)
                    @if($announcement->attachments->count() > 0)
                        <div class="mt-6 space-y-4">
                            <h4 class="font-medium text-gray-900">Attachments</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($announcement->attachments as $attachment)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0" x-data="generateThumbnail">
                                                <img :src="getThumbnail('{{ $attachment->file_extension }}')"
                                                     class="w-8 h-8" alt="File">
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $attachment->name }}
                                                </p>
                                                <p class="text-xs text-gray-500" x-data="formFileSize">
                                                    <span x-text="format({{ $attachment->file_size }})"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ asset($attachment->file_dir) }}"
                                           class="btn btn-sm btn-accent"
                                           download>
                                            Download
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    @if($announcement->file_dir)
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
                                <a href="{{ asset($announcement->file_dir) }}"
                                   class="btn btn-sm btn-accent"
                                   download>
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

            <!-- New Comment Form -->
            <form action="{{ route('student.announcements.comments.store', [
                'announcement' => $announcement->id,
                'type' => $announcement instanceof \App\Models\GeneralAnnouncement ? 'general' : 'classroom'
            ]) }}" method="POST" class="mb-8">
                @csrf
                <div class="form-control">
                    <textarea name="content"
                             class="textarea textarea-bordered min-h-[100px] w-full @error('content') textarea-error @enderror"
                             placeholder="Write a comment..."></textarea>
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
                                          action="{{ route('student.announcements.comments.destroy', ['comment' => $comment->id]) }}"
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
        </div>
    </div>
</x-dashboard.student.base>
