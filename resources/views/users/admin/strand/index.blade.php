<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('strands')" :create_url="route('admin.strands.create')" />
    <div class="panel flex flex-col gap-2 min-h-96">
        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Acronym</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                    @forelse ($strands as $strand)
                        <!-- row 1 -->
                        <tr>
                            <th></th>
                            <td>{{ $strand->name }}</td>
                            <td>{{ $strand->acronym }}</td>
                            <td class="flex items-center gap-5">
                                <a href="{{ route('admin.strands.show', ['strand' => $strand->id]) }}"
                                    class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <a href="{{ route('admin.strands.edit', ['strand' => $strand->id]) }}"
                                    class="btn btn-xs btn-primary">
                                    <i class="fi fi-rr-edit"></i>
                                </a>

                                <form action="{{route('admin.strands.destroy', ['strand' => $strand->id])}}" method="post">
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
                            <th>No Strands</th>

                        </tr>
                    @endforelse


                </tbody>
            </table>


            {{ $strands->links() }}
        </div>
    </div>
</x-dashboard.admin.base>
