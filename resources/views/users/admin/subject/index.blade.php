<x-dashboard.admin.base>
    <x-dashboard.page-title  :title="_('Subjects')" :create_url="route('admin.subjects.create')"/>
    <div class="panel flex flex-col gap-2 min-h-96">
        <div class="overflow-x-auto">
            <table class="table">
              <!-- head -->
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Subject Code</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @forelse ($subjects as $subject)
                 <!-- row 1 -->
                 <tr>
                    <th></th>
                    <td>{{$subject->name}}</td>
                    <td>{{$subject->subject_code}}</td>
                    <td class="flex items-center gap-5">
                        <a href="{{route('admin.subjects.show', ['subject' => $subject->id])}}" class="btn btn-xs btn-accent">
                            <i class="fi fi-rr-eye"></i>
                        </a>

                        <a href="{{route('admin.subjects.edit', ['subject' => $subject->id])}}" class="btn btn-xs btn-primary">
                            <i class="fi fi-rr-edit"></i>
                        </a>

                        <form action="{{route('admin.subjects.destroy', ['subject' => $subject->id])}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-xs btn-error ">
                                <i class="fi fi-rr-trash"></i>
                            </button>
                        </form>
                    </td>
                  </tr>
                @empty
                 <!-- row 1 -->
                 <tr>
                    <th>No Subject</th>

                  </tr>

                @endforelse


              </tbody>
            </table>


            {{$subjects->links()}}
          </div>
    </div>
</x-dashboard.admin.base>
