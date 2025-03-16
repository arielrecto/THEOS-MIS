<x-dashboard.admin.base>
    <x-dashboard.page-title :back_url="route('admin.users.index')" :title="_('Teachers')" :create_url="route('admin.users.teacher.create')" />
    <div class="panel flex flex-col gap-2">
        <div class="overflow-x-auto min-h-96">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>email</th>
                        <th>Date Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->

                    @forelse ($teachers as $teacher)
                        <tr>
                            <th></th>
                            <td>{{$teacher->name}}</td>
                            <td>{{$teacher->email}}</td>
                            <td>{{date('F d, Y', strtotime($teacher->created_at))}}</td>
                            <td class="flex items-center gap-2">
                                <a href="{{route('admin.users.teacher.show', ['teacher' => $teacher->id])}}" class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>
                                <a href="{{route('admin.users.teacher.edit', ['teacher' => $teacher->id])}}" class="btn btn-xs btn-primary">
                                    <i class="fi fi-rr-edit"></i>
                                </a>

                                <form action="{{route('admin.users.teacher.destroy', ['teacher' => $teacher->id ])}}" method="post">
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
                            <th>No Teacher</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {!! $teachers->links() !!}
        </div>
    </div>
</x-dashboard.admin.base>
