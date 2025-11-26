<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('enrollments')" :create_url="route('registrar.enrollments.create')" />
    <div class="flex flex-col gap-2 panel min-h-96">
        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Academic Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                    @forelse ($enrollments as $enrollment)
                        <!-- row 1 -->
                        <tr class="hover:bg-gray-100 transition-colors">
                            <th></th>
                            <td>{{ $enrollment->name }}</td>
                            <td>{{ $enrollment->academicYear->name }}</td>
                            <td>{{ date('F d, Y', strtotime($enrollment->start_date)) }}</td>
                            <td>{{ date('F d, Y', strtotime($enrollment->end_date)) }}</td>
                            <td>{{ $enrollment->status }}</td>
                            <td class="flex gap-5 items-center">
                                <a href="{{ route('registrar.enrollments.show', ['enrollment' => $enrollment->id]) }}"
                                    class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <a href="{{ route('registrar.enrollments.edit', ['enrollment' => $enrollment->id]) }}"
                                    class="btn btn-xs btn-primary">
                                    <i class="fi fi-rr-edit"></i>
                                </a>

                                <form
                                    action="{{ route('registrar.enrollments.destroy', ['enrollment' => $enrollment->id]) }}"
                                    method="post">
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
                        <tr class="hover:bg-gray-100 transition-colors">
                            <th>No Enrollments</th>

                        </tr>
                    @endforelse


                </tbody>
            </table>


            {{ $enrollments->links() }}
        </div>
    </div>
</x-dashboard.registrar.base>
