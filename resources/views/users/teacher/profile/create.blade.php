<x-dashboard.teacher.base>
    <div class="panel flex flex-col gap-2">
        <form action="{{route('teacher.profile.store')}}" method="post" class="w-full h-full min-h-96 flex flex-col gap-5" enctype="multipart/form-data">
            <h1 class="form-title">Profile</h1>
            <p class="text-xs text-gray-500 whitespace-pre-line">
                <span class="font-bold"> Note:</span> you must setup your profile before accessing the system this is
                required for profiling of the users used in the system,
                the system prevent you to access all features unless you finish setting up your profile.
            </p>
            <h1 class="w-full bg-gray-100 p-2 font-semibold border-y border-gray-500">
                Profile
            </h1>
            <p class="text-xs text-gray-500">Instructions: the field contain ("<span class="text-error">*</span>") is
                required</p>

                @csrf

            <div class="w-full flex justify-center" x-data="imageHandler">

                <template x-if="imageSrc !== null" >

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
                        <input id="dropzone-file" type="file" @change="uploadHandler($event)" class="hidden" name="image" />
                    </label>
                </div>

            </div>

            <div class="grid grid-cols-3 grid-flow-row gap-5">
                <div class="flex flex-col gap-2">
                    <label for="" class="input-generic-label">Last Name <span
                            class="text-error">*</span></label>
                    <input type="text" name="last_name" class="input-generic">

                    @if ($errors->has('last_name'))
                        <p class="text-xs text-error">{{ $errors->first('last_name') }}</p>
                    @endif
                </div>
                <div class="flex flex-col gap-2">
                    <label for="" class="input-generic-label">first Name <span
                            class="text-error">*</span></label>
                    <input type="text" name="first_name" class="input-generic">

                    @if ($errors->has('first_name'))
                        <p class="text-xs text-error">{{ $errors->first('first_name') }}</p>
                    @endif
                </div>
                <div class="flex flex-col gap-2">
                    <label for="" class="input-generic-label">middle Name (optional)</label>
                    <input type="text" name="middle_name" class="input-generic">

                </div>
                <div class="flex flex-col gap-2">
                    <label for="" class="input-generic-label">sex <span class="text-error">*</span></label>
                    <select name="sex" class="select select-accent w-full select-sm text-sm">
                        <option disabled selected>select sex</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>


                    @if ($errors->has('sex'))
                        <p class="text-xs text-error">{{ $errors->first('sex') }}</p>
                    @endif
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Address <span class="text-error">*</span></label>
                <input type="text" name="address" class="input-generic">

                @if ($errors->has('address'))
                    <p class="text-xs text-error">{{ $errors->first('address') }}</p>
                @endif

            </div>

            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Contact Number(optional)</label>
                <input type="text" name="contact_no" class="input-generic max-w-lg">
            </div>
            <button class="btn btn-sm btn-accent">Submit</button>
        </form>
    </div>
</x-dashboard.teacher.base>
