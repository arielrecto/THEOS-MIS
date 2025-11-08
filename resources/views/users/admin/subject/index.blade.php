<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('Subjects')" :create_url="route('admin.subjects.create')"/>
    <div class="panel flex flex-col gap-2 min-h-96">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Subject Code</th>
                        <th>Assigned Strands</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subjects as $subject)
                        <tr>
                            <th></th>
                            <td>{{$subject->name}}</td>
                            <td>{{$subject->subject_code}}</td>
                            <td>
                                <div class="flex flex-wrap gap-1">
                                    @forelse($subject->gradeLevels as $gradeLevel)
                                        <span class="badge badge-sm">
                                            {{ $gradeLevel->strand->name}}
                                        </span>
                                    @empty
                                        <span class="text-gray-400 text-sm">
                                            No Grade Level assigned
                                        </span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="flex items-center gap-5">
                                <a href="{{route('admin.subjects.show', ['subject' => $subject->id])}}" 
                                   class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <a href="{{route('admin.subjects.edit', ['subject' => $subject->id])}}" 
                                   class="btn btn-xs btn-primary">
                                    <i class="fi fi-rr-edit"></i>
                                </a>

                                <form action="{{route('admin.subjects.destroy', ['subject' => $subject->id])}}" 
                                      method="post" 
                                      onsubmit="return confirm('Are you sure you want to delete this subject?')">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-error">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fi fi-rr-book text-3xl mb-2"></i>
                                    <p>No subjects found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{$subjects->links()}}
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
