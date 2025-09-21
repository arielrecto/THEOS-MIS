<x-dashboard.teacher.base>
    <div class="w-full">
        <x-dashboard.page-title :title="_('Create New Task')" :back_url="route('teacher.tasks.index', ['classroom_id' => $classroom_id])" />
        <x-notification-message />

        <div class="p-6 bg-white rounded-lg shadow-lg">
            <form method="POST" action="{{ route('teacher.tasks.store') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                <input type="hidden" name="classroom_id" value="{{ $classroom_id }}">

                <!-- Task Basic Information -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
                    <div class="p-4 rounded-lg border border-gray-200">
                        <div class="flex flex-wrap gap-4">
                            <template x-for="file in files" :key="file.localId">
                                <div class="relative group">
                                    <div
                                        class="flex flex-col justify-center items-center p-3 w-32 h-32 bg-gray-50 rounded-lg border border-gray-200">
                                        <template x-if="file.type === 'url'">
                                            <div class="text-center">
                                                <i class="text-2xl fi fi-rr-link-alt text-accent"></i>
                                                <p class="mt-2 w-24 text-xs truncate">Link</p>
                                            </div>
                                        </template>
                                        <template x-if="file.type === 'file'">
                                            <div class="text-center">
                                                <i class="text-2xl fi fi-rr-document text-accent"></i>
                                                <p class="mt-2 w-24 text-xs truncate" x-text="file.name"></p>
                                            </div>
                                        </template>
                                        <button @click.prevent="removeFile(file.localId)"
                                            class="absolute -top-2 -right-2 p-1 text-white rounded-full opacity-0 transition-opacity bg-error group-hover:opacity-100">
                                            <i class="text-sm fi fi-rr-cross-small"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <button type="button" @click.prevent="toggleAction"
                                class="flex justify-center items-center w-32 h-32 rounded-lg border-2 border-dashed border-accent hover:bg-accent/10">
                                <i class="text-2xl fi fi-rr-add text-accent"></i>
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="attachments" x-model="JSON.stringify(files)" />

                    <!-- Attachment Modal -->
                    <div x-show="toggle" class="overflow-y-auto fixed inset-0 z-50" @click.outside="toggleAction">
                        <div class="px-4 min-h-screen text-center">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                            <div
                                class="inline-block overflow-hidden text-left align-bottom bg-white rounded-lg shadow-xl transition-all transform sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                                    <!-- Modal Content -->
                                    <template x-if="!fileType">
                                        <div class="grid grid-cols-2 gap-4">
                                            <button type="button" @click="selectFileType('url')"
                                                class="p-6 text-center rounded-lg border transition-colors hover:border-accent hover:text-accent">
                                                <i class="text-3xl fi fi-rr-link-alt"></i>
                                                <p class="mt-2">Add Link</p>
                                            </button>
                                            <button type="button" @click="selectFileType('file')"
                                                class="p-6 text-center rounded-lg border transition-colors hover:border-accent hover:text-accent">
                                                <i class="text-3xl fi fi-rr-document"></i>
                                                <p class="mt-2">Upload File</p>
                                            </button>
                                        </div>
                                    </template>

                                    <!-- File Upload Forms -->
                                    <template x-if="fileType">
                                        <div class="space-y-4">
                                            <template x-if="fileType === 'url'">
                                                <div class="space-y-4">
                                                    <label class="block text-sm font-medium text-gray-700">Link
                                                        URL</label>
                                                    <input type="text" x-model="url"
                                                        class="w-full input input-bordered"
                                                        placeholder="https://example.com">
                                                    <div class="flex justify-end space-x-2">
                                                        <button type="button" @click="addFileLink"
                                                            class="btn btn-accent">Add Link</button>
                                                        <button type="button" @click="fileType = null"
                                                            class="btn btn-ghost">Cancel</button>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="fileType === 'file'">
                                                <div class="space-y-4">
                                                    <label class="block text-sm font-medium text-gray-700">Upload
                                                        File</label>
                                                    <input type="file" @change="fileUploadHandler($event)"
                                                        class="w-full file-input file-input-bordered">
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
                    <div class="flex flex-col gap-2">
                        <input type="text" x-model="search" placeholder="Search Students"
                            class="w-full input input-bordered">


                        <template x-if="searchResults.length > 0">
                            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <template x-for="s_student in searchResults" :key="s_student.student.id">
                                    <div class="p-4 bg-white rounded-lg border shadow-sm transition hover:shadow-md">
                                        <div class="flex gap-3 items-center">
                                            <div class="flex justify-center items-center w-10 h-10 font-semibold text-white rounded-full bg-accent"
                                                 x-text="(s_student.student.name || '?').charAt(0).toUpperCase()"></div>
                                            <div>
                                                <div class="font-medium text-gray-800" x-text="s_student.student.name"></div>
                                                <div class="text-sm text-gray-500" x-text="s_student.student.email"></div>
                                            </div>
                                        </div>
                                        <div class="mt-4 text-right">
                                            <template x-if="checkStudentExists(s_student)">
                                                <button @click.prevent="removeStudent(s_student)"
                                                    class="btn btn-sm btn-error">Remove</button>
                                            </template>
                                            <template x-if="!checkStudentExists(s_student)">
                                                <button @click.prevent="selectStudent(s_student)"
                                                    class="btn btn-sm btn-accent">Assign</button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                         </template>
 
                        <template x-if="searchResults.length == 0 && search">
                            <div class="p-8 text-center text-gray-500 rounded-lg border bg-base-100">
                                <i class="mb-2 text-3xl fi fi-rr-search"></i>
                                <p class="font-medium">No results found</p>
                                <p class="text-sm">Try a different name or check your spelling.</p>
                            </div>
                        </template>
                    </div>
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-medium text-gray-700">Assign Students</label>
                        <button type="button" @click.prevent="selectAllStudent" class="btn btn-sm btn-accent">Assign
                            to All</button>
                    </div>

                    <div class="overflow-hidden rounded-lg border">
                        <div class="grid grid-cols-3 gap-4 px-4 py-2 text-white bg-accent">
                            <div class="font-medium">Name</div>
                            <div class="font-medium">Email</div>
                            <div class="font-medium text-right">Action</div>
                        </div>

                        <div class="divide-y">






                            <template x-for="c_student in students">
                                <div class="grid grid-cols-3 gap-4 px-4 py-3 hover:bg-gray-50">
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
