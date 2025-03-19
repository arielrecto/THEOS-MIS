<x-dashboard.student.base>
    <div class="max-w-4xl mx-auto">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="card-title text-2xl">{{ $studentTask->task->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $studentTask->task->classroom->name }}</p>
                    </div>
                    <div class="badge badge-{{ $studentTask->status === 'submitted' ? 'success' : 'warning' }}">
                        {{ ucfirst($studentTask->status) }}
                    </div>
                </div>

                <div class="divider"></div>

                <div class="prose max-w-none">
                    <p>{{ $studentTask->task->description }}</p>
                </div>

                <div class="flex gap-4 my-4">
                    <div class="badge badge-outline">
                        Start: {{ \Carbon\Carbon::parse($studentTask->task->start_date)->format('M d, Y') }}
                    </div>
                    <div class="badge badge-outline">
                        Due: {{ \Carbon\Carbon::parse($studentTask->task->end_date)->format('M d, Y') }}
                    </div>
                </div>

                @if($studentTask->task->attachments->count() > 0)
                    <div class="bg-base-200 rounded-lg p-4">
                        <h3 class="font-medium mb-2">Task Attachments</h3>
                        <div class="flex flex-col gap-2">
                            @foreach($studentTask->task->attachments as $attachment)
                                <div class="flex items-center justify-between">
                                    <span>{{ $attachment->name }}</span>
                                    <a href="{{ $attachment->file_dir }}" class="btn btn-ghost btn-sm">Download</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($studentTask->status !== 'submitted')
                    <div class="mt-6">
                        <form action="{{ route('student.tasks.submit', $studentTask->id) }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="flex flex-col gap-4">
                            @csrf
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Upload Attachments</span>
                                </label>
                                <input type="file"
                                       name="attachments[]"
                                       multiple
                                       class="file-input file-input-bordered w-full" />
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Task</button>
                        </form>
                    </div>
                @else
                    <div class="bg-base-200 rounded-lg p-4 mt-6">
                        <h3 class="font-medium mb-2">Your Submissions</h3>
                        <div class="flex flex-col gap-2">
                            @foreach($studentTask->attachments as $attachment)
                                <div class="flex items-center justify-between">
                                    <span>{{ $attachment->name }}</span>
                                    <a href="{{ $attachment->file_dir }}" class="btn btn-ghost btn-sm">Download</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard.student.base>
