<x-dashboard.teacher.base>

    <x-dashboard.page-title :title="_('Classrooms')" :create_url="route('teacher.classrooms.create')"/>
    <x-notification-message />
    <div class="panel min-h-96">

        <div class="grid grid-cols-4 grid-flow-row gap-5 h-52 w-full">
            @forelse ($classrooms as $classroom)
            <div class="h-full w-full rounded-lg border border-accent flex flex-col">
                <a href="{{route('teacher.classrooms.show', ['classroom' => $classroom->id])}}" class="bg-accent h-1/2 rounded-t-lg relative p-2 flex flex-col justify-between">
                    <h1 class="text-lg font-bold text-primary capitalize tracking-wider">
                       {{$classroom->subject->name}}
                    </h1>

                    <p class="text-sm text-primary tracking-wide capitalize">
                        {{$classroom->teacher->name}}
                    </p>
                    <img src="{{$classroom->teacher->profile->image}}" alt="" srcset=""
                     class="absolute z-10 -bottom-5 right-5 h-16 w-16 object-cover rounded-full">
                </a>
                <div class="h-1/2 w-full p-2">
                    <h1 class="text-sm uppercase">{{$classroom->name}} - {{$classroom->strand->acronym}}</h1>
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
        {!! $classrooms->links() !!}
    </div>
</x-dashboard.teacher.base>
