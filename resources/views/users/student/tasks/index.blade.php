<x-dashboard.student.base>
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-accent">My Tasks</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tasks as $task)
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex justify-between items-center">
                            <h2 class="card-title">{{ $task->name }}</h2>
                            <div class="badge badge-{{ $task->assignStudents[0]->status === 'submitted' ? 'success' : 'warning' }}">
                                {{ ucfirst($task->assignStudents[0]->status) }}
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">{{ $task->classroom->name }}</p>
                        <p class="line-clamp-2">{{ $task->description }}</p>

                        <div class="flex gap-2 mt-2">
                            <div class="badge badge-outline">
                                Due: {{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}
                            </div>
                            @if($task->attachments_count > 0)
                                <div class="badge badge-outline">
                                    {{ $task->attachments_count }} Attachments
                                </div>
                            @endif
                        </div>

                        <div class="card-actions justify-end mt-4">
                            <a href="{{ route('student.tasks.show', $task->id) }}"
                               class="btn btn-primary btn-sm">View Task</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <h3 class="text-lg font-medium text-gray-500">No tasks assigned yet</h3>
                </div>
            @endforelse
        </div>
    </div>
</x-dashboard.student.base>
