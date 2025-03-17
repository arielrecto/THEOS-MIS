<x-dashboard.teacher.base>

    <x-dashboard.page-title :title="_('Classrooms')" :create_url="route('teacher.classrooms.create')"/>
    <x-notification-message />
    <div class="panel min-h-96">

        <div class="grid grid-cols-4 grid-flow-row gap-5 w-full h-52">
            @forelse ($classrooms as $classroom)
            <div class="flex flex-col w-full h-full rounded-lg border border-accent">
                <a href="{{route('teacher.classrooms.show', ['classroom' => $classroom->id])}}" class="flex relative flex-col justify-between p-2 h-1/2 rounded-t-lg bg-accent">
                    <h1 class="text-lg font-bold tracking-wider capitalize text-primary">
                       {{$classroom->subject->name}}
                    </h1>

                    <p class="text-sm tracking-wide capitalize text-primary">
                        {{$classroom->teacher->name}}
                    </p>
                    <img src="{{$classroom->teacher->profile->image}}" alt="" srcset=""
                     class="object-cover absolute right-5 -bottom-5 z-10 w-16 h-16 rounded-full">
                </a>
                <div class="p-2 w-full h-1/2">
                    <h1 class="text-sm uppercase">{{$classroom->name}} - {{$classroom->strand->acronym}}</h1>
                </div>
                <p class="p-2 text-sm tracking-wide capitalize text-accent">
                    {{$classroom->academicYear->name}}
                </p>
             </div>
            @empty
                <div class="flex justify-center items-center w-full h-full rounded-lg border border-accent">
                   <p class="text-lg font-bold text-accent">
                    No Classrooms
                   </p>
                </div>
            @endforelse
        </div>
        {!! $classrooms->links() !!}
    </div>
</x-dashboard.teacher.base>
