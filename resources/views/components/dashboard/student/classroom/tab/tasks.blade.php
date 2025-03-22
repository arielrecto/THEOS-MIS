@props(['tasks' => []])

<x-slot name="tasks">
    <div class="grid grid-cols-1 gap-6">
        @if (count($tasks) > 0)
            @foreach ($tasks as $task)
                <div class="shadow-xl card bg-base-100">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="avatar">
                                    <div class="w-10 rounded-full">
                                        <img src="{{ $task->classroom->teacher->profile->image ?? '' }}"
                                            alt="Teacher Profile" />
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-medium">{{ $task->classroom->teacher->name }}</h3>
                                    <p class="text-xs opacity-50">Posted {{ $task->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="badge badge-accent">Score: {{ $task->score ?? 0 }}/{{ $task->max_score }}</div>
                        </div>

                        <h2 class="card-title">{{ $task->name }}</h2>
                        <p>{{ $task->description }}</p>

                        <div class="flex gap-4 mt-4">
                            <div class="badge badge-outline">
                                Start: {{ \Carbon\Carbon::parse($task->start_date)->format('M d, Y') }}
                            </div>
                            <div class="badge badge-outline">
                                Due: {{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}
                            </div>
                        </div>

                        @if ($task->attachments->count() > 0)
                            <div class="mt-4 p-3 bg-base-200 rounded-lg">
                                <div class="flex flex-col gap-2">
                                    <h4 class="font-medium">Attachments</h4>
                                    @foreach($task->attachments as $attachment)
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-5 h-5 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-sm">{{ $attachment->name }}</span>
                                            </div>
                                            <a href="{{ asset($attachment->file_dir) }}" class="btn btn-ghost btn-sm">Download</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="card-actions justify-end mt-4">
                            <a href="{{route('student.tasks.show', ['id' => $task->id])}}" class="btn btn-primary">Submit Work</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-10">
                <h3 class="text-lg font-medium text-gray-500">No tasks assigned yet</h3>
            </div>
        @endif
    </div>
</x-slot>
