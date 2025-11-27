@props(['announcements' => []])

<x-slot name="stream">
    <div class="space-y-4">
        @if (count($announcements) > 0)
            @foreach ($announcements as $announcement)
                <article class="bg-white shadow-md rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="flex items-start sm:items-center justify-between gap-4 p-4 sm:p-5">
                        <div class="flex items-start sm:items-center gap-3 min-w-0">
                            <div class="avatar flex-shrink-0">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full overflow-hidden bg-gray-100">
                                    <img
                                        src="{{ $announcement->classroom->teacher->profile->image ?? '' }}"
                                        alt="{{ $announcement->classroom->teacher->name ?? 'Teacher' }}"
                                        class="object-cover w-full h-full">
                                </div>
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-semibold leading-tight text-gray-900 truncate">
                                    {{ $announcement->classroom->teacher->name }}
                                </h3>
                                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                                    {{ $announcement->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn btn-ghost btn-circle btn-sm" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 5v.01M12 12v.01M12 19v.01" />
                                    </svg>
                                </label>
                                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-40">
                                    <li>
                                        <a href="{{ route('student.announcements.show', ['id' => $announcement->id, 'type' => 'classroom']) }}" class="text-sm">
                                            View
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="px-4 pb-4 sm:px-5 sm:pb-5">
                        <h4 class="text-base sm:text-lg font-semibold text-gray-900 leading-tight mb-2 truncate">
                            {{ $announcement->title }}
                        </h4>

                        {{-- Responsive description: clamped on small screens, full on larger --}}
                        <div class="text-sm sm:text-base text-gray-700">
                            <p class="hidden sm:block">
                                {!! nl2br(e(Str::limit(strip_tags($announcement->description), 800))) !!}
                            </p>

                            <details class="sm:hidden">
                                <summary class="text-sm font-medium text-accent mb-2 cursor-pointer">Details</summary>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    {!! nl2br(e(Str::limit(strip_tags($announcement->description), 400))) !!}
                                </p>
                            </details>

                            {{-- For very short descriptions show inline on all breakpoints --}}
                            @if(strlen(strip_tags($announcement->description)) < 120)
                                <p class="sm:hidden mt-2 text-sm text-gray-700">
                                    {!! nl2br(e(strip_tags($announcement->description))) !!}
                                </p>
                            @endif
                        </div>

                        {{-- Attachment --}}
                        @if ($announcement->file_dir)
                            <div class="mt-4 bg-gray-50 border border-gray-100 rounded-md p-3 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">Attachment</p>
                                        <p class="text-xs text-gray-500 truncate">{{ basename($announcement->file_dir) }}</p>
                                    </div>
                                </div>

                                <a href="{{ asset($announcement->file_dir) }}" target="_blank" rel="noopener noreferrer"
                                   class="btn btn-ghost btn-sm whitespace-nowrap">
                                    Download
                                </a>
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        @else
            <div class="text-center py-10">
                <h3 class="text-base sm:text-lg font-medium text-gray-500">No announcements yet</h3>
                <p class="text-xs sm:text-sm text-gray-400 mt-2">Check back later for updates from your teacher.</p>
            </div>
        @endif
    </div>
</x-slot>
