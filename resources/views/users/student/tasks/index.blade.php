<x-dashboard.student.base>
    <div class="flex flex-col gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h1 class="text-xl sm:text-2xl font-bold text-accent">My Tasks</h1>
            <p class="text-xs sm:text-sm text-gray-500">Tasks assigned to you are shown below. Tap a card to view details.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tasks as $task)
                <div class="card bg-base-100 shadow-md rounded-lg overflow-hidden flex flex-col">
                    <div class="card-body p-4 sm:p-5 flex flex-col h-full">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h2 class="card-title text-sm sm:text-base font-semibold text-gray-900 truncate">
                                    {{ $task->name }}
                                </h2>
                                <p class="mt-1 text-xs sm:text-sm text-gray-500 truncate">
                                    {{ $task->classroom->name }}
                                </p>
                            </div>

                            <div class="ml-2 flex-shrink-0">
                                <div class="badge badge-{{ $task->assignStudents[0]->status === 'submitted' ? 'success' : 'warning' }} text-xs sm:text-sm">
                                    {{ ucfirst($task->assignStudents[0]->status) }}
                                </div>
                            </div>
                        </div>

                        <p class="mt-3 text-sm sm:text-base text-gray-700 line-clamp-3">
                            {{ Str::limit(strip_tags($task->description), 220) }}
                        </p>

                        <div class="flex flex-wrap items-center gap-2 mt-3 text-xs sm:text-sm text-gray-500">
                            <div class="badge badge-outline px-2 py-1 text-xs sm:text-sm">
                                Due: {{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}
                            </div>

                            @if($task->attachments_count > 0)
                                <div class="badge badge-outline px-2 py-1 text-xs sm:text-sm">
                                    {{ $task->attachments_count }} {{ Str::plural('Attachment', $task->attachments_count) }}
                                </div>
                            @endif

                            <div class="ml-auto text-xs sm:text-sm text-gray-400">
                                <span class="hidden sm:inline">Posted </span>{{ $task->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="card-actions justify-end mt-4">
                            <a href="{{ route('student.tasks.show', $task->id) }}"
                               class="btn btn-primary btn-sm sm:btn-sm w-full sm:w-auto text-sm sm:text-base">
                                View Task
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <h3 class="text-base sm:text-lg font-medium text-gray-500">No tasks assigned yet</h3>
                    <p class="text-xs sm:text-sm text-gray-400 mt-2">Tasks will appear here when your teacher assigns them.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-dashboard.student.base>
