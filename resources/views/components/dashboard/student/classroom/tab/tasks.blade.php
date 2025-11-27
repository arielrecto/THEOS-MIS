@props(['tasks' => []])

<x-slot name="tasks">
    <div class="grid grid-cols-1 gap-6">
        @if (count($tasks) > 0)
            @foreach ($tasks as $task)
                <article class="card bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="card-body p-4 md:p-5 flex flex-col md:flex-row gap-4">
                        <div class="flex items-start gap-4 w-full md:w-2/5">
                            <div class="avatar flex-shrink-0">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full overflow-hidden bg-gray-100">
                                    <img src="{{ $task->classroom->teacher->profile->image ?? '' }}"
                                         alt="{{ $task->classroom->teacher->name ?? 'Teacher' }}"
                                         class="object-cover w-full h-full" />
                                </div>
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base md:text-lg font-semibold leading-tight truncate">
                                    {{ $task->classroom->teacher->name }}
                                </h3>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                    Posted {{ $task->created_at->diffForHumans() }}
                                </p>
                                <div class="mt-2 flex flex-wrap items-center gap-2">
                                    <span class="badge badge-accent text-xs sm:text-sm">Score: {{ $task->max_score }}</span>
                                    <span class="text-xs sm:text-sm text-gray-500">•</span>
                                    <span class="text-xs sm:text-sm text-gray-500">
                                        Start: {{ \Carbon\Carbon::parse($task->start_date)->format('M d, Y') }}
                                    </span>
                                    <span class="text-xs sm:text-sm text-gray-500">•</span>
                                    <span class="text-xs sm:text-sm text-gray-500">
                                        Due: {{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col justify-between gap-3 w-full md:w-3/5">
                            <div>
                                <h2 class="card-title text-base sm:text-lg md:text-xl font-bold text-gray-900 truncate">
                                    {{ $task->name }}
                                </h2>

                                <p class="mt-2 text-sm sm:text-base text-gray-700 leading-relaxed line-clamp-3 sm:line-clamp-5">
                                    {!! nl2br(e(Str::limit(strip_tags($task->description), 800))) !!}
                                </p>

                                @if ($task->attachments->count() > 0)
                                    <div class="mt-4 bg-gray-50 border border-gray-100 rounded-md p-3">
                                        <h4 class="text-sm sm:text-base font-medium text-gray-800 mb-2">Attachments</h4>
                                        <div class="flex flex-wrap gap-3">
                                            @foreach($task->attachments as $attachment)
                                                <div class="flex items-center gap-3 bg-white rounded-lg p-2 shadow-sm hover:shadow-md transition w-full sm:w-auto">
                                                    <a href="{{ $attachment->file }}" target="_blank" rel="noopener noreferrer"
                                                       class="flex items-center gap-2">
                                                        <div class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded">
                                                            <img src="{{ asset('images/file-icons/' . ($attachment->extension ?? 'file') . '.svg') }}"
                                                                 alt="{{ $attachment->extension ?? 'file' }}"
                                                                 class="w-4 h-4 object-contain" />
                                                        </div>
                                                        <div class="min-w-0">
                                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $attachment->name }}</p>
                                                            <p class="text-xs text-gray-500 truncate">{{ strtoupper($attachment->extension) }}</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="card-actions justify-end">
                                <a href="{{ route('student.tasks.show', ['id' => $task->id]) }}"
                                   class="btn btn-primary w-full sm:w-auto text-sm sm:text-base">
                                    Submit Work
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        @else
            <div class="text-center py-10">
                <h3 class="text-base sm:text-lg font-medium text-gray-500">No tasks assigned yet</h3>
                <p class="text-xs sm:text-sm text-gray-400 mt-2">Tasks will appear here when your teacher assigns them.</p>
            </div>
        @endif
    </div>
</x-slot>
