<x-dashboard.admin.base>
    <x-dashboard.page-title  :title="_('Academic Year')" :create_url="route('admin.academic-year.create')"/>

    <div class="flex flex-col gap-4 panel min-h-96">
        {{-- Desktop / Tablet: Table --}}
        <div class="overflow-x-auto hidden md:block">
            <table class="table w-full">
              <thead>
                <tr>
                  <th></th>
                  <th>Academic Year</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                  <th class="text-right">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($academicYears as $academicYear)
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
                    <td class="flex gap-3 items-center justify-end">
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

                        {{-- Delete Confirmation Modal --}}
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
                 <tr>
                    <td colspan="6" class="text-center py-6">
                        <div class="flex flex-col items-center text-gray-500">
                            <i class="fi fi-rr-calendar text-3xl mb-2"></i>
                            <p>No Academic Year</p>
                        </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
        </div>

        {{-- Mobile: Card list --}}
        <div class="space-y-4 md:hidden">
            @forelse ($academicYears as $academicYear)
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <div class="flex flex-col items-start">
                        <div class="w-full">
                            <div class="flex items-center gap-2 justify-between">
                                <p class="text-sm text-gray-500">Academic Year</p>
                                 <span class="px-2 py-1 rounded text-white text-sm {{ $academicYear->status === 'active' ? 'bg-green-500' : 'bg-red-400' }}">
                                {{ ucfirst($academicYear->status) }}
                            </span>

                            </div>

                            <h3 class="font-semibold text-lg">{{ $academicYear->name }}</h3>
                            <p class="text-xs md:text-sm text-gray-500 mt-2">
                                <span class="block">Start: {{ $academicYear->start_date }}</span>
                                <span class="block">End: {{ $academicYear->end_date }}</span>
                            </p>
                        </div>

                        <div class="w-full">

                            <div class="flex flex-col gap-2 mt-3">
                                <a href="{{route('admin.academic-year.show', ['academic_year' => $academicYear->id])}}" class="btn btn-xs btn-accent w-full">
                                    <i class="fi fi-rr-eye"></i> View
                                </a>

                                <a href="{{route('admin.academic-year.edit', ['academic_year' => $academicYear->id])}}" class="btn btn-xs btn-primary w-full">
                                    <i class="fi fi-rr-edit"></i> Edit
                                </a>

                                <form action="{{route('admin.academic-year.destroy', ['academic_year' => $academicYear->id])}}"
                                      method="post"
                                      class="w-full"
                                      id="mobileDeleteForm{{$academicYear->id}}">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-xs btn-error w-full"
                                            onclick="document.getElementById('mobile_delete_modal_{{$academicYear->id}}').showModal()">
                                        <i class="fi fi-rr-trash"></i> Delete
                                    </button>
                                </form>

                                {{-- Mobile Delete Modal --}}
                                <dialog id="mobile_delete_modal_{{$academicYear->id}}" class="modal">
                                    <div class="modal-box">
                                        <h3 class="font-bold text-lg">Confirm Deletion</h3>
                                        <p class="py-4">
                                            Delete academic year "{{ $academicYear->name }}"? This action cannot be undone.
                                        </p>
                                        <div class="modal-action">
                                            <form method="dialog">
                                                <button class="btn btn-ghost">Cancel</button>
                                            </form>
                                            <button class="btn btn-error"
                                                    onclick="document.getElementById('mobileDeleteForm{{$academicYear->id}}').submit()">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </dialog>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white shadow-sm rounded-lg p-6 text-center text-gray-500">
                    <i class="fi fi-rr-calendar text-3xl mb-2"></i>
                    <p>No Academic Year</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-2">
            {{ $academicYears->links() }}
        </div>
    </div>
</x-dashboard.admin.base>
