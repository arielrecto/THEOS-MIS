<x-dashboard.teacher.base>

    <x-dashboard.page-title :title="_('Announcements')"
     :back_url="route('teacher.classrooms.show', ['classroom' => $classroom_id])"
       />
    <x-notification-message />

    <div class="max-w-3xl mx-auto p-4 sm:p-6">
        <!-- Header: title + meta -->
        <header class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-2xl font-bold text-accent leading-tight truncate">
                    {{ $announcement->name }}
                </h1>
                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500">
                    <span class="whitespace-nowrap">{{ $announcement->created_at->format('M d, Y h:i A') }}</span>
                    <span class="inline-block px-2 py-0.5 rounded bg-gray-100 text-gray-700 text-xs">
                        {{ $announcement->type ?? 'General' }}
                    </span>
                    @if(!empty($announcement->author_name ?? null))
                        <span class="text-xs text-gray-400">•</span>
                        <span class="text-xs text-gray-500">By {{ $announcement->author_name }}</span>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('teacher.classrooms.show', ['classroom' => $classroom_id]) }}"
                   class="btn btn-ghost btn-sm">
                    <i class="fi fi-rr-arrow-left mr-1"></i>
                    Back
                </a>
                @if($announcement->file_dir)
                    <a href="{{ $announcement->file_dir }}" target="_blank" rel="noopener"
                       class="btn btn-sm btn-accent hidden sm:inline-flex items-center gap-2">
                        <i class="fi fi-rr-paperclip"></i>
                        View Attachment
                    </a>
                @endif
            </div>
        </header>

        <!-- Content + Attachment -->
        <main class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Description -->
            <section class="md:col-span-2 bg-white border rounded-lg p-4 sm:p-5 shadow-sm">
                <h2 class="sr-only">Announcement</h2>
                <div class="prose prose-sm sm:prose md:prose-lg max-w-none text-gray-800 whitespace-pre-wrap">
                    {!! nl2br(e($announcement->description ?? '')) !!}
                </div>
            </section>

            <!-- Attachment / Actions -->
            <aside class="bg-white border rounded-lg p-3 sm:p-4 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-semibold mb-2">Attachment</h3>

                    @if ($announcement->file_dir)
                        @php
                            $fileName = basename($announcement->file_dir);
                        @endphp

                        <div class="flex flex-col md:flex-row md:items-center gap-3">
                            <div class="w-12 h-12 flex items-center justify-center rounded bg-gray-50 text-accent">
                                <i class="fi fi-rr-paperclip text-lg"></i>
                            </div>

                            <div class="min-w-0">
                                <div class="text-sm font-medium truncate">{{ $fileName }}</div>
                                <div class="text-xs text-gray-500 truncate">
                                    Click to view or download
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 grid grid-cols-1 gap-2">
                            <a href="{{ $announcement->file_dir }}" target="_blank" rel="noopener"
                               class="btn btn-accent btn-sm w-full inline-flex items-center justify-center gap-2">
                                <i class="fi fi-rr-eye"></i>
                                View
                            </a>

                            <a href="{{ $announcement->file_dir }}" download
                               class="btn btn-outline btn-sm w-full inline-flex items-center justify-center gap-2">
                                <i class="fi fi-rr-download"></i>
                                Download
                            </a>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-6 text-sm text-gray-500">
                            <i class="fi fi-rr-document-times text-2xl mb-2"></i>
                            <div>No Attachment</div>
                        </div>
                    @endif
                </div>

                <!-- Small action area (visible on mobile) -->
                <div class="mt-4 sm:hidden">
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('teacher.classrooms.show', ['classroom' => $classroom_id]) }}"
                           class="btn btn-ghost btn-sm w-full">
                            Back
                        </a>

                        @if ($announcement->file_dir)
                            <a href="{{ $announcement->file_dir }}" target="_blank" rel="noopener"
                               class="btn btn-accent btn-sm w-full">
                                View
                            </a>
                        @endif
                    </div>
                </div>
            </aside>
        </main>

        <!-- Optional: additional metadata or actions -->
        <footer class="mt-4 text-xs text-gray-400">
            <div>Posted: {{ $announcement->created_at->toDayDateTimeString() }}</div>
        </footer>
    </div>
</x-dashboard.teacher.base>
