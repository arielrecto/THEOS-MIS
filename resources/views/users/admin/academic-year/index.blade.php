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
                        <span class="px-2 py-1 rounded text-white {{ $academicYear->status === 'active' ? 'bg-green-500' : 'bg-red-400' }}">
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

                        <form action="{{route('admin.academic-year.destroy', ['academic_year' => $academicYear->id])}}"
                              method="post"
                              id="deleteForm{{$academicYear->id}}">
                            @csrf
                            @method('delete')
                            <button type="button"
                                    class="btn btn-xs btn-error"
                                    onclick="document.getElementById('delete_modal_{{$academicYear->id}}').showModal()">
                                <i class="fi fi-rr-trash"></i>
                            </button>
                        </form>

                        <!-- Delete Confirmation Modal -->
                        <dialog id="delete_modal_{{$academicYear->id}}" class="modal modal-bottom sm:modal-middle">
                            <div class="modal-box">
                                <h3 class="font-bold text-lg">Confirm Deletion</h3>
                                <p class="py-4">
                                    Are you sure you want to delete academic year "{{$academicYear->name}}"?
                                    This action cannot be undone.
                                </p>
                                <div class="modal-action">
                                    <form method="dialog">
                                        <button class="btn btn-ghost">Cancel</button>
                                    </form>
                                    <button class="btn btn-error"
                                            onclick="document.getElementById('deleteForm{{$academicYear->id}}').submit()">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </dialog>
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
