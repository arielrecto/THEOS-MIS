<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Edit Announcement')" />

    <form action="{{ route('admin.general-announcements.update', $announcement->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')

        <div x-data="imageHandler">
            <template x-if="imageSrc">
                <a :href="imageSrc" target="_blank"
                    class="flex justify-center items-center w-full rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <img :src="imageSrc" class="w-full h-64 object-cover">
                </a>
            </template>

            {{-- Show existing image if available --}}
            @if($announcement->file_dir)
                <div class="mb-4">
                    <img src="{{ Storage::url($announcement->file_dir) }}"
                         class="w-full h-64 object-cover rounded-lg"
                         alt="Current announcement image">
                </div>
            @endif

            <div class="flex justify-center items-center w-full" x-show="!imageSrc">
                <label for="dropzone-file"
                    class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col justify-center items-center pt-5 pb-6">
                        <svg class="mb-4 w-8 h-8 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="font-semibold">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            SVG, PNG, JPG or GIF (MAX. 800x400px)
                        </p>
                    </div>
                    <input id="dropzone-file" type="file" name="image" @change="uploadHandler($event)"
                        class="hidden" />
                </label>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <div class="form-control">
                <label for="title">{{ __('Title') }}</label>
                <input type="text"
                       name="title"
                       id="title"
                       class="w-full input input-primary"
                       value="{{ old('title', $announcement->title) }}"
                       required>
            </div>
            <div class="flex flex-col gap-2">
                <label for="description">{{ __('Description') }}</label>
                <textarea name="description"
                          id="description"
                          class="w-full textarea textarea-primary"
                          required>{{ old('description', $announcement->description) }}</textarea>
            </div>
        </div>

        <div class="flex flex-col gap-2 py-2">
            <label for="is_posted">{{ __('Is Posted') }}</label>
            <input class="checkbox checkbox-primary"
                   type="checkbox"
                   name="is_posted"
                   id="is_posted"
                   {{ $announcement->is_posted ? 'checked' : '' }}>
        </div>

        <div class="flex flex-col gap-2 py-2">
            <label for="attachments">{{ __('Attachments') }}</label>

            {{-- Show existing attachments if any --}}
            @if($announcement->attachments->count() > 0)
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Current Attachments:</h3>
                    <div class="space-y-2">
                        @foreach($announcement->attachments as $attachment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <i class="fi fi-rr-document text-gray-400 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">
                                            {{ $attachment->file_name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ number_format($attachment->file_size / 1024, 2) }} KB
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ Storage::url($attachment->file_dir) }}"
                                       class="btn btn-sm btn-ghost text-accent hover:text-accent-focus"
                                       target="_blank">
                                        <i class="fi fi-rr-eye"></i>
                                        <span class="ml-1">View</span>
                                    </a>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Upload new attachments --}}
            <div class="flex items-center justify-center w-full">
                <label for="attachments"
                       class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <i class="fi fi-rr-upload text-2xl text-gray-400 mb-2"></i>
                        <p class="mb-2 text-sm text-gray-500">
                            <span class="font-semibold">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500">
                            PDF, DOC, DOCX, XLS, XLSX up to 10MB
                        </p>
                    </div>
                    <input type="file"
                           class="hidden"
                           name="attachments[]"
                           id="attachments"
                           multiple
                           accept=".pdf,.doc,.docx,.xls,.xlsx">
                </label>
            </div>
        </div>

        <div class="card-footer flex justify-between items-center">
            <button type="submit" class="btn btn-accent">{{ __('Update') }}</button>
            <a href="{{ route('admin.general-announcements.index') }}"
               class="btn btn-ghost">
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</x-dashboard.admin.base>
