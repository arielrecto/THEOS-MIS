<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Create Announcement')" />

    <form action="{{ route('admin.general-announcements.store') }}" enctype="multipart/form-data" method="POST">
        @csrf


        <div x-data="imageHandler">

            <template x-if="imageSrc">
                <a :href="imageSrc" target="_blank"
                    class="flex justify-center items-center w-full rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <img :src="imageSrc" class="w-full h-64 object-cover">
                </a>
            </template>


            <div class="flex justify-center items-center w-full" x-show="!imageSrc">
                <label for="dropzone-file"
                    class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col justify-center items-center pt-5 pb-6">
                        <svg class="mb-4 w-8 h-8 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                to
                                upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)
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
                <input type="text" name="title" id="title" class="w-full input input-primary" required>
            </div>
            <div class="flex flex-col gap-2">
                <label for="description">{{ __('Description') }}</label>
                <textarea name="description" id="description" class="w-full textarea textarea-primary" required></textarea>
            </div>
        </div>

        <div class="flex flex-col gap-2 py-2">
            <label for="is_posted">{{ __('Is Posted') }}</label>
            <input class="checkbox checkbox-primary" type="checkbox" name="is_posted" id="is_posted">
        </div>

        <div class="flex flex-col gap-2 py-2">
            <label for="attachments">{{ __('Attachments') }}</label>
            <input type="file" class="file-input file-input-accent" name="attachments[]" id="attachments" multiple>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-accent">{{ __('Create') }}</button>
        </div>
    </form>

</x-dashboard.admin.base>
