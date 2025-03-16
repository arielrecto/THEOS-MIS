<x-dashboard.teacher.base>

    <x-dashboard.page-title :title="_('Announcements')"
     :back_url="route('teacher.classrooms.show', ['classroom' => $classroom_id])"
     :create_url="route('teacher.announcements.create', ['classroom_id' => $classroom_id])"  />
    <x-notification-message />
    <div class="panel min-h-96">


        <div class="overflow-x-auto">
            <h1 class="text-lg py-5 text-accent font-bold">Announcements</h1>
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="bg-accent text-white">
                        <th></th>
                        <th>Name</th>
                        <th>Date Posted</th>
                        <th>Action</th>
                        {{-- <th>Job</th>
                            <th>Favorite Color</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->

                    @forelse ($announcements as $announcement)
                        <tr>
                            <th></th>
                            <td>{{ $announcement->title }}</td>
                            <td>{{ date('F d, Y H:s A', strtotime($announcement->created_at))}}</td>
                            <td class="flex items-center gap-2">
                                <a href="{{route('teacher.announcements.show', ['announcement' => $announcement->id, 'classroom_id' => $classroom_id])}}" class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <form action="" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-error ">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th>No Announcement</th>

                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        {!! $announcements->links() !!}
    </div>
</x-dashboard.teacher.base>
