<x-dashboard.teacher.base>

    <x-dashboard.page-title :title="_('Announcements')"
     :back_url="route('teacher.classrooms.show', ['classroom' => $classroom_id])"
       />
    <x-notification-message />
    <div class="panel min-h-96">


        <div class="flex flex-col gap-2">
            <h1 class="py-5 text-lg font-bold text-accent">{{$announcement->name}}</h1>
            <div class="p-2 w-full bg-gray-100 rounded-lg min-h-32">
                {{$announcement->description}}
            </div>


            @if ($announcement->file_dir)
                <a href="{{$announcement->file_dir}}" target="_blank" class="btn btn-sm btn-outline btn-accent">File</a>
                @else
                <div class="flex justify-center items-center p-2 w-full text-sm bg-gray-100 rounded-lg min-h-32">
                   <h1>No Attachment</h1>
                </div>
            @endif
        </div>




        


    </div>
</x-dashboard.teacher.base>
