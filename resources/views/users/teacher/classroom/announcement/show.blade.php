<x-dashboard.teacher.base>

    <x-dashboard.page-title :title="_('Announcements')"
     :back_url="route('teacher.classrooms.show', ['classroom' => $classroom_id])"
       />
    <x-notification-message />
    <div class="panel min-h-96">


        <div class="flex flex-col gap-2">
            <h1 class="text-lg py-5 text-accent font-bold">{{$announcement->name}}</h1>
            <div class="w-full min-h-32 bg-gray-100 rounded-lg p-2">
                {{$announcement->description}}
            </div>


            @if ($announcement->file_dir)
                <a href="{{$announcement->file_dir}}" target="_blank" class="btn btn-sm btn-outline btn-accent">File</a>
                @else
                <div class="w-full min-h-32 bg-gray-100 rounded-lg p-2 flex justify-center items-center text-sm">
                   <h1>No Attachment</h1>
                </div>
            @endif
        </div>

    </div>
</x-dashboard.teacher.base>
