<x-dashboard.student.base>
    <div class="w-full">
        <!-- Task Header -->
        <div class="overflow-hidden bg-white rounded-xl shadow-lg">
            <div class="p-6 border-b">
                <div class="flex gap-4 justify-between items-start">
                    <div class="flex-1">
                        <div class="flex gap-2 items-center mb-2 text-sm text-gray-600">
                            <i class="fi fi-rr-book-alt"></i>
                            <span>{{ $studentTask->task->classroom->name }}</span>
                            <i class="fi fi-rr-angle-right"></i>
                            <span>Tasks</span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $studentTask->task->name }}</h1>
                    </div>
                    <div class="flex flex-col gap-2 items-end">
                        <div class="badge badge-lg {{ $studentTask->status === 'submitted' ? 'badge-success' : 'badge-warning' }}">
                            {{ ucfirst($studentTask->status) }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $studentTask->score ?? '0' }}/{{ $studentTask->task->points ?? '100' }} points
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task Details -->
            <div class="p-6">
                <!-- Due Dates -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <div class="flex gap-2 items-center text-sm">
                        <i class="fi fi-rr-calendar text-accent"></i>
                        <span class="text-gray-600">Posted:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($studentTask->task->created_at)->format('M d, Y') }}</span>
                    </div>
                    <div class="flex gap-2 items-center text-sm">
                        <i class="fi fi-rr-hourglass-end text-accent"></i>
                        <span class="text-gray-600">Due:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($studentTask->task->end_date)->format('M d, Y g:i A') }}</span>
                    </div>
                </div>

                <!-- Task Description -->
                <div class="mb-8 max-w-none prose">
                    {{ $studentTask->task->description }}
                </div>

                <!-- Task Attachments -->
                @if($studentTask->task->attachments->count() > 0)
                    <div class="mb-8">
                        <h3 class="mb-3 text-sm font-medium text-gray-500">Task Materials</h3>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2" x-data="generateThumbnail">
                            @foreach($studentTask->task->attachments as $attachment)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg transition-colors hover:bg-gray-100">
                                    <div class="flex flex-1 gap-3 items-center min-w-0">
                                        <img :src="getThumbnail('{{ $attachment->extension }}')" class="w-8 h-8" alt="File icon">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $attachment->name }}</p>
                                            {{-- <p class="text-xs text-gray-500">{{ human_filesize($attachment->size) }}</p> --}}
                                        </div>
                                    </div>
                                    <a href="{{ asset($attachment->file_dir) }}"
                                       class="gap-2 btn btn-ghost btn-sm"
                                       download>
                                        <i class="fi fi-rr-download text-accent"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Submission Section -->
                @if($studentTask->status !== 'submitted')
                    <div class="p-6 bg-white rounded-lg border">
                        <h3 class="mb-4 text-lg font-semibold">Your Work</h3>
                        <form action="{{ route('student.tasks.submit', $studentTask->id) }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="space-y-4">
                            @csrf
                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">Add or Create</span>
                                </label>
                                <div class="flex gap-4 items-center">
                                    <input type="file"
                                           name="attachments[]"
                                           multiple
                                           class="w-full max-w-xs file-input file-input-bordered file-input-accent" />
                                    <button type="submit" class="btn btn-accent">
                                        <i class="mr-2 fi fi-rr-upload"></i>
                                        Turn in
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="p-6 bg-white rounded-lg border">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Submitted Work</h3>
                            <div class="text-sm text-gray-500">
                                Turned in {{ $studentTask->created_at->format('M d, Y g:i A') }}
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2" x-data="generateThumbnail">
                            @foreach($studentTask->attachments as $attachment)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg transition-colors hover:bg-gray-100">
                                    <div class="flex flex-1 gap-3 items-center min-w-0">
                                        <img :src="getThumbnail('{{ $attachment->extension }}')" class="w-8 h-8" alt="File icon">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $attachment->name }}</p>
                                            {{-- <p class="text-xs text-gray-500">{{ human_filesize($attachment->size) }}</p> --}}
                                        </div>
                                    </div>
                                    <a href="{{ asset($attachment->file_dir) }}"
                                       class="gap-2 btn btn-ghost btn-sm"
                                       download>
                                        <i class="fi fi-rr-download text-accent"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <form action="{{ route('student.tasks.unsubmit', $studentTask->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-error">Unsubmit</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard.student.base>
