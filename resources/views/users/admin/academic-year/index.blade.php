<x-dashboard.admin.base>
    <x-dashboard.page-title  :title="_('Academic Year')" :create_url="route('admin.academic-year.create')"/>

    <div class="flex flex-col gap-2 panel min-h-96">
        <div class="overflow-x-auto">
            <table class="table">
              <!-- head -->
              <thead>
                <tr>
                  <th></th>
                  <th>Academic Year</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @forelse ($academicYears as $academicYear)
                 <!-- row 1 -->
                 <tr>
                    <th></th>
                    <td>{{$academicYear->name}}</td>
                    <td>{{$academicYear->start_date}}</td>
                    <td>{{$academicYear->end_date}}</td>
                    <td>
                        <span class="px-2 py-1 rounded text-white {{ $academicYear->status === 'active' ? 'bg-green-500' : 'bg-gray-400' }}">
                            {{ ucfirst($academicYear->status) }}
                        </span>
                    </td>
                    <td class="flex gap-5 items-center">
                        <a href="{{route('admin.academic-year.show', ['academic_year' => $academicYear->id])}}" class="btn btn-xs btn-accent">
                            <i class="fi fi-rr-eye"></i>
                        </a>

                        <a href="{{route('admin.academic-year.edit', ['academic_year' => $academicYear->id])}}" class="btn btn-xs btn-primary">
                            <i class="fi fi-rr-edit"></i>
                        </a>

                        <form action="{{route('admin.academic-year.destroy', ['academic_year' => $academicYear->id])}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-xs btn-error">
                                <i class="fi fi-rr-trash"></i>
                            </button>
                        </form>
                    </td>
                  </tr>
                @empty
                 <!-- row 1 -->
                 <tr>
                    <th>No Academic Year</th>

                  </tr>

                @endforelse


              </tbody>
            </table>


            {{$academicYears->links()}}
          </div>
    </div>
</x-dashboard.admin.base>
