<x-dashboard.teacher.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Classrooms Create')" />

    <div class="panel min-h-96">

        <form action="{{ route('teacher.announcements.store') }}" method="post" class="flex flex-col gap-5"
            enctype="multipart/form-data">

            @csrf
            <h1 class="form-title">Announcement</h1>
            {{-- <div class="w-full flex justify-center" x-data="imageHandler">

                <template x-if="imageSrc !== null">

                    <div class="w-1/2 h-auto">
                        <img :src="imageSrc" alt="" srcset="" class="object-cover h-full w-full">
                    </div>

                </template>
                <div class="flex items-center justify-center w-full" x-show="imageSrc === null">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2
                        border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50  hover:bg-gray-100 ">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 " aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click
                                    to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 ">JPG
                            </p>
                        </div>
                        <input id="dropzone-file" type="file" @change="uploadHandler($event)" class="hidden"
                            name="image" />
                    </label>
                </div>

            </div> --}}
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">title</label>
                <input type="text" name="title" class="input-generic">
                @if ($errors->has('title'))
                    <p class="text-xs text-error">{{ $errors->first('title') }}</p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Description</label>
                <textarea class="textarea textarea-accent min-h-32" name="description" placeholder="description"></textarea>
                @if ($errors->has('description'))
                    <p class="text-xs text-error">{{ $errors->first('description') }}</p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Description</label>
                <input type="file" name="attachment" class="file-input file-input-accent">
            </div>

            <input type="hidden" name="classroom_id" value="{{ request('classroom_id') }}">



            <button class="btn btn-sm btn-accent">Submit</button>
        </form>

    </div>
</x-dashboard.teacher.base>
