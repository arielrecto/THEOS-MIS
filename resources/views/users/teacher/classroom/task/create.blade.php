<x-dashboard.teacher.base>

    <x-dashboard.page-title :title="_('tasks')" :back_url="route('teacher.tasks.index', ['classroom_id' => $classroom_id])" />
    <x-notification-message />
    <div class="panel min-h-96">


        <div class="overflow-x-auto">
            <h1 class="text-lg py-5 text-accent font-bold">Tasks - Create</h1>
            <form method="POST" action="{{ route('teacher.tasks.store') }}" enctype="multipart/form-data"
                class="flex flex-col gap-2">
                @csrf
                <input type="hidden" name="classroom_id" value="{{ $classroom_id }}">
                <div class="flex flex-col gap-2">
                    <label for="" class="input-generic-label">name</label>
                    <input type="text" name="name" class="input-generic">
                    @if ($errors->has('name'))
                        <p class="text-xs text-error">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                <div class="grid grid-cols-2 grid-flow-row gap-2">
                    <div class="flex flex-col gap-2">
                        <label for="" class="input-generic-label">Start Date</label>
                        <input type="date" name="start_date" class="input-generic">
                        @if ($errors->has('start_date'))
                            <p class="text-xs text-error">{{ $errors->first('start_date') }}</p>
                        @endif
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="" class="input-generic-label">End Date</label>
                        <input type="date" name="end_date" class="input-generic">
                        @if ($errors->has('end_date'))
                            <p class="text-xs text-error">{{ $errors->first('end_date') }}</p>
                        @endif
                    </div>
                </div>


                <div class="flex flex-col gap-2">
                    <label for="" class="input-generic-label">Description</label>
                    <textarea name="description" class="textarea textarea-accent h-32" placeholder="description"></textarea>
                    @if ($errors->has('description'))
                        <p class="text-xs text-error">{{ $errors->first('description') }}</p>
                    @endif
                </div>




                <div class="flex flex-col gap-2">
                    <label for="" class="input-generic-label">Max Score</label>
                    <input type="number" name="max_score" class="input-generic">
                    @if ($errors->has('max_score'))
                        <p class="text-xs text-error">{{ $errors->first('max_score') }}</p>
                    @endif
                </div>

                <div class="flex flex-col gap-2 relative" x-data="attachmentUpload">
                    <label for="" class="input-generic-label">Attachment</label>
                    <div class="w-full h-32 rounded-lg border border-accent p-2 flex flex-wrap overflow-y-auto gap-2">

                        <template x-for="file in files" :key="file.localId">
                            <div class="w-32 h-full rounded-lg bg-white shadow-lg">
                                <template x-if="file.type === 'url'">
                                    <a :href="file.data" target="_blank"
                                        class="flex justify-center items-center bg-gray-100 rounded-lg h-full relative">
                                        <h1 class="flex gap-2">
                                            <i class="fi fi-rr-link-alt"></i>
                                            <span>Link</span>
                                        </h1>
                                        <button @click.prevent="removeFile(file.localId)"
                                            class="absolute z-10 top-2 right-2">
                                            <i class="fi fi-rr-circle-xmark"></i>
                                        </button>
                                    </a>
                                </template>
                                <template x-if="file.type === 'file'">
                                    <a target="_blank"
                                        class="flex justify-center items-center bg-gray-100 rounded-lg h-full relative">
                                        <div class="flex flex-col gap-2 items-center">
                                            <h1 class="flex gap-2">
                                                <i class="fi fi-rr-document"></i>
                                                <span>
                                                    <h1>File</h1>
                                                </span>
                                            </h1>
                                            <p class="text-xs truncate" x-text="file.name"></p>
                                        </div>

                                        <button @click.prevent="removeFile(file.localId)"
                                            class="absolute z-10 top-2 right-2">
                                            <i class="fi fi-rr-circle-xmark"></i>
                                        </button>
                                    </a>
                                </template>
                            </div>
                        </template>

                        <button @click.prevent="toggleAction"
                            class="btn btn-outline btn-accent hover:btn-accent h-full flex justify-center items-center w-32">
                            <i class="fi fi-rr-add"></i>
                        </button>
                    </div>

                    <input type="hidden" name="attachments" x-model="JSON.stringify(files)" />

                    <div x-show="toggle" class="w-full h-full absolute z-10" @click.outside="toggleAction">
                        <div class="backdrop-blur-sm bg-white/30 flex justify-center items-center h-full w-full">
                            <div class="bg-white shadow-lg rouned-lg p-2 w-1/2 min-h-32">
                                <template x-if="!fileType">
                                    <div class="grid grid-cols-2 grid-flow-row gap-2 hg-32">
                                        <button @click.prevent="selectFileType('url')"
                                            class="btn btn-accent btn-outline h-32 w-full">
                                            <h1 class="flex gap-2">
                                                <i class="fi fi-rr-link-alt"></i>
                                                <span>Link</span>
                                            </h1>
                                        </button>
                                        <button @click.prevent="selectFileType('file')"
                                            class="btn btn-accent btn-outline h-32 w-full">
                                            <h1>
                                                <i class="fi fi-rr-document"></i>
                                                <span>File</span>
                                            </h1>
                                        </button>
                                </template>
                                <template x-if="fileType">
                                    <div class="w-full flex flex-col gap-2">
                                        <template x-if="fileType === 'url'">
                                            <div class="flex flex-col gap-2">
                                                <label for="" class="input-generic-label">Link</label>
                                                <input type="text" x-model="url" class="input-generic">
                                                <div class="flex gap-2">
                                                    <button @click.prevent="addFileLink"
                                                        class="btn btn-sm btn-accent">Add</button>
                                                    <button @click.prevent="fileType = null"
                                                        class="btn btn-error btn-sm">Close</button>
                                                </div>

                                            </div>
                                        </template>
                                        <template x-if="fileType === 'file'">
                                            <div class="flex flex-col gap-2">
                                                <label for="" class="input-generic-label">file</label>
                                                <input type="file" @change="fileUploadHandler($event)"
                                                    class="file-input file-input-accent file-input-sm">
                                                <div class="flex gap-2">
                                                    <button @click.prevent="addFileData"
                                                        class="btn btn-sm btn-accent">Add</button>
                                                    <button
                                                        @click.prevent="fileType = null"class="btn btn-error btn-sm">Close</button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                            </div>
                        </div>
                    </div>
                </div>




                <div x-data="studentSelection" x-init="initStudentData({{ $students }})" class="flex flex-col gap-2">
                    <label for="" class="input-generic-label">Students</label>
                    <div class="p-2 rounded-lg bg-accent  text-white grid grid-cols-3 grid-flow-row gap-2 text-sm">
                        <h1>Name</h1>
                        <h1>Email</h1>
                        <h1>Assign to</h1>
                    </div>
                    <div class="w-full flex justify-end">
                        <button class="btn btn-accent btn-sm" @click.prevent="selectAllStudent">Assign to All</button>
                    </div>
                    <template x-for="c_student in students">
                        <div class="p-2 rounded-lg border border-accent grid grid-cols-3 grid-flow-row gap-2">
                            <h1><span x-text="c_student.student.name"></span></h1>
                            <h1><span x-text="c_student.student.email"></span></h1>
                            <h1>
                                <template x-if="checkStudentExists(c_student)">
                                    <button @click.prevent="removeStudent(c_student)"
                                        class="btn btn-sm btn-error">Remove</button>
                                </template>
                                <template x-if="!checkStudentExists(c_student)">
                                    <button @click.prevent="selectStudent(c_student)"
                                        class="btn btn-sm btn-accent">Assign</button>
                                </template>
                            </h1>
                        </div>
                    </template>
                    <input type="hidden" name="students" x-model="JSON.stringify(selectedStudents)">
                </div>


                <button class="btn btn-accent btn-sm">Save</button>
            </form>
        </div>

    </div>
</x-dashboard.teacher.base>
