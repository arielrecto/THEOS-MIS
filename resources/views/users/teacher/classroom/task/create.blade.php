<x-dashboard.teacher.base>
    <div class="w-full">
        <x-dashboard.page-title :title="_('Create New Task')" :back_url="route('teacher.tasks.index', ['classroom_id' => $classroom_id])" />
        <x-notification-message />

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form method="POST" action="{{ route('teacher.tasks.store') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                <input type="hidden" name="classroom_id" value="{{ $classroom_id }}">

                <!-- Task Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Task Name</label>
                        <input type="text" name="name"
                            class="input input-bordered w-full @error('name') input-error @enderror"
                            placeholder="Enter task name">
                        @error('name')
                            <p class="text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Max Score</label>
                        <input type="number" name="max_score"
                            class="input input-bordered w-full @error('max_score') input-error @enderror"
                            placeholder="Enter maximum score">
                        @error('max_score')
                            <p class="text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Task Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date"
                            class="input input-bordered w-full @error('start_date') input-error @enderror">
                        @error('start_date')
                            <p class="text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Due Date</label>
                        <input type="date" name="end_date"
                            class="input input-bordered w-full @error('end_date') input-error @enderror">
                        @error('end_date')
                            <p class="text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Task Description -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description"
                        class="textarea textarea-bordered w-full h-32 @error('description') textarea-error @enderror"
                        placeholder="Enter task description"></textarea>
                    @error('description')
                        <p class="text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Attachments Section -->
                <div class="space-y-2" x-data="attachmentUpload">
                    <label class="block text-sm font-medium text-gray-700">Attachments</label>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex flex-wrap gap-4">
                            <template x-for="file in files" :key="file.localId">
                                <div class="relative group">
                                    <div class="w-32 h-32 rounded-lg bg-gray-50 border border-gray-200 p-3 flex flex-col items-center justify-center">
                                        <template x-if="file.type === 'url'">
                                            <div class="text-center">
                                                <i class="fi fi-rr-link-alt text-2xl text-accent"></i>
                                                <p class="text-xs mt-2 truncate w-24">Link</p>
                                            </div>
                                        </template>
                                        <template x-if="file.type === 'file'">
                                            <div class="text-center">
                                                 <i class="fi fi-rr-document text-2xl text-accent"></i>
                                                <p class="text-xs mt-2 truncate w-24" x-text="file.name"></p>
                                            </div>
                                        </template>
                                        <button @click.prevent="removeFile(file.localId)"
                                            class="absolute -top-2 -right-2 bg-error text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fi fi-rr-cross-small text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <button type="button" @click.prevent="toggleAction"
                                class="w-32 h-32 rounded-lg border-2 border-dashed border-accent hover:bg-accent/10 flex items-center justify-center">
                                <i class="fi fi-rr-add text-2xl text-accent"></i>
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="attachments" x-model="JSON.stringify(files)" />

                    <!-- Attachment Modal -->
                    <div x-show="toggle" class="fixed inset-0 z-50 overflow-y-auto" @click.outside="toggleAction">
                        <div class="min-h-screen px-4 text-center">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <!-- Modal Content -->
                                    <template x-if="!fileType">
                                        <div class="grid grid-cols-2 gap-4">
                                            <button type="button" @click="selectFileType('url')"
                                                class="p-6 text-center border rounded-lg hover:border-accent hover:text-accent transition-colors">
                                                <i class="fi fi-rr-link-alt text-3xl"></i>
                                                <p class="mt-2">Add Link</p>
                                            </button>
                                            <button type="button" @click="selectFileType('file')"
                                                class="p-6 text-center border rounded-lg hover:border-accent hover:text-accent transition-colors">
                                                <i class="fi fi-rr-document text-3xl"></i>
                                                <p class="mt-2">Upload File</p>
                                            </button>
                                        </div>
                                    </template>

                                    <!-- File Upload Forms -->
                                    <template x-if="fileType">
                                        <div class="space-y-4">
                                            <template x-if="fileType === 'url'">
                                                <div class="space-y-4">
                                                    <label class="block text-sm font-medium text-gray-700">Link URL</label>
                                                    <input type="text" x-model="url"
                                                        class="input input-bordered w-full"
                                                        placeholder="https://example.com">
                                                    <div class="flex justify-end space-x-2">
                                                        <button type="button"  @click="addFileLink"
                                                            class="btn btn-accent">Add Link</button>
                                                        <button type="button" @click="fileType = null"
                                                            class="btn btn-ghost">Cancel</button>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="fileType === 'file'">
                                                <div class="space-y-4">
                                                    <label class="block text-sm font-medium text-gray-700">Upload File</label>
                                                    <input type="file" @change="fileUploadHandler($event)"
                                                        class="file-input file-input-bordered w-full">
                                                    <div class="flex justify-end space-x-2">
                                                        <button type="button" @click="addFileData"
                                                            class="btn btn-accent">Upload</button>
                                                        <button type="button" @click="fileType = null"
                                                            class="btn btn-ghost">Cancel</button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Students Selection -->
                <div x-data="studentSelection" x-init="initStudentData({{ $students }})" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-medium text-gray-700">Assign Students</label>
                        <button type="button" @click.prevent="selectAllStudent"
                            class="btn btn-sm btn-accent">Assign to All</button>
                    </div>

                    <div class="border rounded-lg overflow-hidden">
                        <div class="bg-accent text-white px-4 py-2 grid grid-cols-3 gap-4">
                            <div class="font-medium">Name</div>
                            <div class="font-medium">Email</div>
                            <div class="font-medium text-right">Action</div>
                        </div>

                        <div class="divide-y">
                            <template x-for="c_student in students">
                                <div class="px-4 py-3 grid grid-cols-3 gap-4 hover:bg-gray-50">
                                    <div x-text="c_student.student.name"></div>
                                    <div x-text="c_student.student.email"></div>
                                    <div class="text-right">
                                        <template x-if="checkStudentExists(c_student)">
                                            <button @click.prevent="removeStudent(c_student)"
                                                class="btn btn-sm btn-error">Remove</button>
                                        </template>
                                        <template x-if="!checkStudentExists(c_student)">
                                            <button @click.prevent="selectStudent(c_student)"
                                                class="btn btn-sm btn-accent">Assign</button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <input type="hidden" name="students" x-model="JSON.stringify(selectedStudents)">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-accent">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.teacher.base>
