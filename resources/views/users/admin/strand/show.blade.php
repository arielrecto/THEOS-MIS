<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('Grade Level')"  />
    <div class="panel flex flex-col gap-2 min-h-96">

        <h1 class="text-xl font-bold text-accent capitalize">{{$strand->acronym}} -  {{ $strand->name }}</h1>


        <div class="min-h-32 p-2 rounded-lg bg-gray-100 text-gray-500">
            {{$strand->descriptions}}
        </div>

        <div class="grid grid-cols-2 grid-flow-row  gap-2 h-32">
            <x-card label="Classrooms" total="{{$strand->classrooms()->count()}}" class="shadow-none border border-accent"/>
        </div>

        <h1 class="text-lg font-bold text-accent">Classrooms</h1>
        <div class="grid grid-cols-3 grid-flow-row gap-5 h-52 w-full">
            @forelse ($strand->classrooms as $classroom)
                <div class="h-full w-full rounded-lg border border-accent flex flex-col">
                    <a href="#"
                        class="bg-accent h-1/2 rounded-t-lg relative p-2 flex flex-col justify-between">
                        <h1 class="text-lg font-bold text-primary capitalize tracking-wider">
                            {{ $classroom->strand->name }}
                        </h1>

                        <p class="text-sm text-primary tracking-wide capitalize">
                            {{ $classroom->teacher->name }}
                        </p>
                        <img src="{{ $classroom->teacher->profile->image }}" alt="" srcset=""
                            class="absolute z-10 -bottom-5 right-5 h-16 w-16 object-cover rounded-full">
                    </a>
                    <div class="h-1/2 w-full p-2">
                        <h1 class="text-sm uppercase">{{ $classroom->name }} - {{ $classroom->strand->acronym }}
                        </h1>
                    </div>
                </div>
            @empty
                <div class="h-full w-full rounded-lg border border-accent flex justify-center items-center">
                    <p class="text-lg font-bold text-accent">
                        No Classrooms
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</x-dashboard.admin.base>
