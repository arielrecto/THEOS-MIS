<x-dashboard.teacher.base>

    <x-dashboard.page-title :back_url="route('teacher.tasks.show', ['task' => $studentTask->task->id])"  :title="_('Student Tasks')" />
    <x-notification-message />
    <div class="panel min-h-96">
        <div class="flex justify-between items-center p-2 capitalize text-accent">
            <div class="flex gap-2 items-center">
                <h1>Status : {{$studentTask->status}}</h1>
            </div>
            <div class="flex gap-2 items-center">
                <h1>Score : {{$studentTask->score ?? 0}} / {{$studentTask->task->max_score}}</h1>
            </div>
        </div>

        <div class="flex overflow-x-auto flex-col gap-2">
            <div x-data="{ toggle: false, isDisable : false, maxScore: {{$studentTask->task->max_score}}}" class="flex flex-col gap-2">
                <div>
                    <button @click="toggle =  !toggle" class="btn btn-sm btn-accent">
                        <span x-text="toggle ? 'Close' : 'Add Score' "></span>
                    </button>
                </div>

                <div class="flex flex-col gap-2 p-2 bg-gray-100 rounded-lg min-h-32" x-show="toggle" x-transition.duration.700ms>

                    <form action="{{route('teacher.studentTask.addScore', ['student_task' => $studentTask->id])}}" method="post" class="flex flex-col gap-2 w-full h-full">

                        @csrf
                        <div class="flex flex-col gap-2">
                            <h1 class="text-accent">Max Score : {{ $studentTask->task->max_score }}</h1>
                        </div>
                        <template x-if="isDisable">
                            <p class="text-xs text-error">Invalid input max score : <span x-text="maxScore"></span> </p>
                        </template>
                        <input type="number" @input="isDisable = parseInt($event.target.value) > maxScore" name="score" class="input-generic">
                        <button :disabled="isDisable" class="btn btn-sm btn-accent">Save</button>
                    </form>

                </div>
            </div>



            <div class="flex justify-between items-center">

                <h1 class="py-5 text-lg font-bold capitalize text-accent">Tasks - {{ $studentTask->task->name }}</h1>

                <p class="text-xs text-gray-500">
                    Date Submitted : {{ date('F d, Y h:s A', strtotime($studentTask->updated_at)) }}
                </p>
            </div>
            <div class="flex flex-col gap-5">

                <h1 class="text-lg font-bold text-accent">Attachments</h1>
                <div class="flex flex-wrap gap-2 w-full">
                    @forelse ($studentTask->attachments as $attachment)
                        <a href="{{ $attachment->file_dir }}" target="_blank" data-preview="{{ $attachment->file_dir }}"
                            class="rounded-lg border">
                            <div class="flex justify-center items-center w-32 h-32 bg-white rounded-lg"
                                x-data="generateThumbnail">
                                <img class="w-16 h-16" :src="getThumbnail(`{{ $attachment->extension }}`)" />
                            </div>
                        </a>
                    @empty

                        <div class="flex justify-center items-center w-full h-32 text-sm bg-gray-100 rounded-lg">
                            <h1>No Attachment</h1>
                        </div>
                    @endforelse
                </div>

            </div>



            <form action="{{ route('teacher.studentTask.comments.store') }}" method="POST" class="mt-8">
                @csrf
                <div class="form-control">
                    <label class="label">
                        <span class="font-medium label-text">Add a comment</span>
                    </label>
                    <input type="hidden" name="student_task_id" value="{{ $studentTask->id }}">
                    <textarea name="content"
                             class="textarea textarea-bordered min-h-[100px] w-full @error('content') textarea-error @enderror"
                             placeholder="Write your comment here..."></textarea>
                    @error('content')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="btn btn-accent">
                        <i class="mr-2 fi fi-rr-comment"></i>
                        Post Comment
                    </button>
                </div>
            </form>



            <div class="space-y-6">
                @forelse($studentTask->comments->sortByDesc('created_at') as $comment)

                <x-commentThread :comment="$comment" :url="route('student.tasks.comments.reply', $comment->id)" />
                   
                @empty
                    <div class="py-8 text-center text-gray-500">
                        <i class="mb-2 text-3xl fi fi-rr-comment-alt"></i>
                        <p>No comments yet</p>
                    </div>
                @endforelse
            </div>

        </div>

    </div>


</x-dashboard.teacher.base>
