<x-landing-page.base>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            {{-- Header Section --}}
            <div class="mb-8">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">


                            <a href="/" class="link link-hover text-gray-600">
                                <i class="fi fi-rr-home mr-2"></i>
                                Home
                            </a>

                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fi fi-rr-angle-right mx-2 text-gray-400"></i>
                                <a href="{{ route('general-announcements.show', ['id' => $announcement->id]) }}"
                                    class="link link-hover text-gray-600">
                                    Announcements
                                </a>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $announcement->title }}</h1>
                <div class="flex items-center text-gray-600 gap-4">
                    <div class="flex items-center">
                        <i class="fi fi-rr-user mr-2"></i>
                        <span>{{ $announcement->postedBy->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fi fi-rr-calendar mr-2"></i>
                        <span>{{ $announcement->created_at->format('F d, Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                @if ($announcement->image)
                    <div class="w-full h-96 relative cursor-pointer"
                        onclick="document.getElementById('image_preview_modal').showModal()">
                        <img src="{{ $announcement->image }}" alt="{{ $announcement->title }}"
                            class="w-full h-full object-cover hover:opacity-95 transition-opacity">
                        <div
                            class="absolute inset-0 bg-black/0 hover:bg-black/10 flex items-center justify-center transition-colors">
                            <i class="fi fi-rr-zoom-in text-white text-2xl opacity-0 hover:opacity-100"></i>
                        </div>
                    </div>
                @endif

                <div class="p-6 space-y-6">
                    {{-- Description --}}
                    <div class="prose max-w-none">

                        {!! nl2br(e($announcement->description)) !!}
                    </div>

                    {{-- Attachments --}}
                    @if ($announcement->attachments->count() > 0)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4">Attachments</h3>
                            <div class="space-y-2">
                                @foreach ($announcement->attachments as $attachment)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <i class="fi fi-rr-document text-gray-400 text-xl"></i>
                                            <div>
                                                <p class="text-sm font-medium text-gray-700">
                                                    {{ $attachment->file_name }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ number_format($attachment->file_size / 1024, 2) }} KB
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ Storage::url($attachment->file_dir) }}"
                                            class="btn btn-sm btn-ghost text-accent" target="_blank">
                                            <i class="fi fi-rr-download mr-1"></i>
                                            Download
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        @else

                        <div class="border-t pt-6 bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-500">No attachments available for this announcement.</p>
                        </div>
                    @endif

                    {{-- Comments Section --}}
                    @if ($announcement->comments->count() > 0)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4">Comments</h3>
                            <div class="space-y-4">
                                @foreach ($announcement->comments as $comment)
                                    <div class="flex gap-4">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-10 h-10 rounded-full bg-accent/10 flex items-center justify-center">
                                                <i class="fi fi-rr-user text-accent"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-medium">{{ $comment->user->name }}</h4>
                                                <span class="text-sm text-gray-500">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-gray-600 mt-1">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <dialog id="image_preview_modal" class="modal">
        <div class="modal-box max-w-5xl h-auto p-0 bg-transparent shadow-none">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 text-white z-10">✕</button>
            </form>
            @if ($announcement->image)
                <img src="{{ $announcement->image }}"
                     alt="{{ $announcement->title }}"
                     class="w-full h-auto max-h-[80vh] object-contain rounded-lg">
            @endif
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</x-landing-page.base>
