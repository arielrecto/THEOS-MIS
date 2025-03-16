<x-dashboard.teacher.base>

    <x-dashboard.page-title :back_url="route('teacher.tasks.show', ['task' => $studentTask->task->id])"  :title="_('Student Tasks')" />
    <x-notification-message />
    <div class="panel min-h-96">
        <div class="flex items-center justify-between p-2 capitalize text-accent">
            <div class="flex  items-center gap-2">
                <h1>Status : {{$studentTask->status}}</h1>
            </div>
            <div class="flex  items-center gap-2">
                <h1>Score : {{$studentTask->score ?? 0}} / {{$studentTask->task->max_score}}</h1>
            </div>
        </div>

        <div class="overflow-x-auto flex flex-col gap-2">
            <div x-data="{ toggle: false, isDisable : false, maxScore: {{$studentTask->task->max_score}}}" class="flex flex-col gap-2">
                <div>
                    <button @click="toggle =  !toggle" class="btn btn-sm btn-accent">
                        <span x-text="toggle ? 'Close' : 'Add Score' "></span>
                    </button>
                </div>

                <div class="min-h-32 bg-gray-100 rounded-lg p-2 flex flex-col gap-2" x-show="toggle" x-transition.duration.700ms>

                    <form action="{{route('teacher.studentTask.addScore', ['student_task' => $studentTask->id])}}" method="post" class="h-full w-full flex flex-col gap-2">

                        @csrf
                        <div class="flex  flex-col gap-2">
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



            <div class="flex items-center justify-between">

                <h1 class="text-lg py-5 text-accent font-bold capitalize">Tasks - {{ $studentTask->task->name }}</h1>

                <p class="text-xs text-gray-500">
                    Date Submitted : {{ date('F d, Y h:s A', strtotime($studentTask->updated_at)) }}
                </p>
            </div>
            <div class="flex flex-col gap-5">

                <h1 class="text-lg font-bold text-accent">Attachments</h1>
                <div class="flex flex-wrap gap-2 w-full">
                    @forelse ($studentTask->attachments as $attachment)
                        <a href="{{ $attachment->file_dir }}" target="_blank" data-preview="{{ $attachment->file_dir }}"
                            class=" border rounded-lg">
                            <div class="flex items-center justify-center h-32 w-32 rounded-lg bg-white"
                                x-data="generateThumbnail">
                                <img class="h-16 w-16" :src="getThumbnail(`{{ $attachment->extension }}`)" />
                            </div>
                        </a>
                    @empty

                        <div class="w-full h-32 rounded-lg flex items-center justify-center bg-gray-100 text-sm">
                            <h1>No Attachment</h1>
                        </div>
                    @endforelse
                </div>

            </div>

        </div>

    </div>


</x-dashboard.teacher.base>
