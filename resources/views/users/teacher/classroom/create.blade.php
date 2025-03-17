<x-dashboard.teacher.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Classrooms Create')" :back_url="route('teacher.classrooms.index')"/>

    <div class="panel min-h-96">

        <form action="{{ route('teacher.classrooms.store') }}" method="post" class="flex flex-col gap-5"
            enctype="multipart/form-data">

            @csrf
            <h1 class="form-title">Classroom Form</h1>
            <div class="flex justify-center w-full" x-data="imageHandler">

                <template x-if="imageSrc !== null">

                    <div class="w-1/2 h-auto">
                        <img :src="imageSrc" alt="" srcset="" class="object-cover w-full h-full">
                    </div>

                </template>
                <div class="flex justify-center items-center w-full" x-show="imageSrc === null">
                    <label for="dropzone-file"
                        class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer hover:bg-gray-100">
                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                            <svg class="mb-4 w-8 h-8 text-gray-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click
                                    to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">JPG
                            </p>
                        </div>
                        <input id="dropzone-file" type="file" @change="uploadHandler($event)" class="hidden"
                            name="image" />
                    </label>
                </div>

            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">name</label>
                <input type="text" name="name" class="input-generic">
                @if ($errors->has('name'))
                    <p class="text-xs text-error">{{ $errors->first('name') }}</p>
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
                <label for="" class="input-generic-label">Subject</label>
                <select name="subject" class="w-full text-sm select select-accent select-sm">
                    <option disabled selected>Select Subject</option>

                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('subject'))
                    <p class="text-xs text-error">{{ $errors->first('subject') }}</p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Strand</label>
                <select name="strand" class="w-full text-sm select select-accent select-sm">
                    <option disabled selected>Select Subject</option>

                    @foreach ($strands as $strand)
                        <option value="{{ $strand->id }}">{{ $strand->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('strand'))
                    <p class="text-xs text-error">{{ $errors->first('strand') }}</p>
                @endif
            </div>


            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Academic Year</label>
                <select name="academic_year" class="w-full text-sm select select-accent select-sm">
                    <option selected value="{{ $academicYear->id }}">{{ $academicYear->name }}</option>
                </select>
                @if ($errors->has('academic_year'))
                    <p class="text-xs text-error">{{ $errors->first('academic_year') }}</p>
                @endif
            </div>


            <button class="btn btn-sm btn-accent">Submit</button>
        </form>

    </div>
</x-dashboard.teacher.base>
