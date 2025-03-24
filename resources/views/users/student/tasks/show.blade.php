<x-dashboard.student.base>
    <div class="w-full ">
        <!-- Task Header -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 text-gray-600 text-sm mb-2">
                            <i class="fi fi-rr-book-alt"></i>
                            <span>{{ $studentTask->task->classroom->name }}</span>
                            <i class="fi fi-rr-angle-right"></i>
                            <span>Tasks</span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $studentTask->task->name }}</h1>
                    </div>
                    <div class="flex flex-col items-end gap-2">
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
                    <div class="flex items-center gap-2 text-sm">
                        <i class="fi fi-rr-calendar text-accent"></i>
                        <span class="text-gray-600">Posted:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($studentTask->task->created_at)->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <i class="fi fi-rr-hourglass-end text-accent"></i>
                        <span class="text-gray-600">Due:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($studentTask->task->end_date)->format('M d, Y g:i A') }}</span>
                    </div>
                </div>

                <!-- Task Description -->
                <div class="prose max-w-none mb-8">
                    {{ $studentTask->task->description }}
                </div>

                <!-- Task Attachments -->
                @if($studentTask->task->attachments->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-sm font-medium text-gray-500 mb-3">Task Materials</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" x-data="generateThumbnail">
                            @foreach($studentTask->task->attachments as $attachment)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center flex-1 min-w-0 gap-3">
                                        <img :src="getThumbnail('{{ $attachment->extension }}')" class="w-8 h-8" alt="File icon">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $attachment->name }}</p>
                                            {{-- <p class="text-xs text-gray-500">{{ human_filesize($attachment->size) }}</p> --}}
                                        </div>
                                    </div>
                                    <a href="{{ asset($attachment->file_dir) }}"
                                       class="btn btn-ghost btn-sm gap-2"
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
                    <div class="bg-white rounded-lg border p-6">
                        <h3 class="text-lg font-semibold mb-4">Your Work</h3>
                        <form action="{{ route('student.tasks.submit', $studentTask->id) }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="space-y-4">
                            @csrf
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Add or Create</span>
                                </label>
                                <div class="flex items-center gap-4">
                                    <input type="file"
                                           name="attachments[]"
                                           multiple
                                           class="file-input file-input-bordered file-input-accent w-full max-w-xs" />
                                    <button type="submit" class="btn btn-accent">
                                        <i class="fi fi-rr-upload mr-2"></i>
                                        Turn in
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-white rounded-lg border p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Submitted Work</h3>
                            <div class="text-sm text-gray-500">
                                Turned in {{ $studentTask->created_at->format('M d, Y g:i A') }}
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" x-data="generateThumbnail">
                            @foreach($studentTask->attachments as $attachment)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center flex-1 min-w-0 gap-3">
                                        <img :src="getThumbnail('{{ $attachment->extension }}')" class="w-8 h-8" alt="File icon">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $attachment->name }}</p>
                                            {{-- <p class="text-xs text-gray-500">{{ human_filesize($attachment->size) }}</p> --}}
                                        </div>
                                    </div>
                                    <a href="{{ asset($attachment->file_dir) }}"
                                       class="btn btn-ghost btn-sm gap-2"
                                       download>
                                        <i class="fi fi-rr-download text-accent"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard.student.base>
