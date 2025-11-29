<x-dashboard.admin.base>
    <x-dashboard.page-title :back_url="route('admin.users.index')" :title="_('Teachers')" :create_url="route('admin.users.teacher.create')" />
    <div class="panel flex flex-col gap-2">

        <!-- Mobile: stacked card / "stack view" (visible on xs, hidden on sm+) -->
        <div class="block sm:hidden space-y-3">
            @forelse ($teachers as $teacher)
                <div class="bg-white rounded-lg border shadow-sm p-3">
                    <div class="flex items-start gap-3">
                        <img
                            src="{{ optional($teacher->profile)->image ?? 'https://ui-avatars.com/api/?name='.urlencode($teacher->name).'&size=128' }}"
                            alt="{{ $teacher->name }}"
                            class="w-12 h-12 rounded-full object-cover flex-shrink-0" />

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $teacher->name }}</h3>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($teacher->created_at)->format('M d, Y') }}</div>
                            </div>

                            <p class="text-xs text-gray-600 mt-1 truncate break-words">{{ $teacher->email }}</p>
                        </div>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                        <a href="{{route('admin.users.teacher.show', ['teacher' => $teacher->id])}}"
                           class="btn btn-ghost btn-sm flex-1 min-w-[90px] text-xs flex items-center justify-center gap-2">
                            <i class="fi fi-rr-eye"></i> View
                        </a>

                        <a href="{{route('admin.users.teacher.edit', ['teacher' => $teacher->id])}}"
                           class="btn btn-ghost btn-sm flex-1 min-w-[90px] text-xs flex items-center justify-center gap-2">
                            <i class="fi fi-rr-edit"></i> Edit
                        </a>

                        <form action="{{route('admin.users.teacher.destroy', ['teacher' => $teacher->id ])}}"
                              method="post"
                              class="flex-1 min-w-[90px]"
                              onsubmit="return confirm('Are you sure you want to delete this teacher?')">
                            @csrf
                            @method('delete')
                            <button class="btn btn-ghost btn-sm text-error w-full text-xs flex items-center justify-center gap-2">
                                <i class="fi fi-rr-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm p-4 text-center text-gray-500 border">
                    <i class="fi fi-rr-user text-2xl mb-2"></i>
                    <p class="text-sm">No Teachers</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop / Tablet: regular table (hidden on xs) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="table w-full">
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
                    @forelse ($teachers as $teacher)
                        <tr>
                            <th></th>
                            <td class="align-middle">{{ $teacher->name }}</td>
                            <td class="align-middle truncate">{{ $teacher->email }}</td>
                            <td class="align-middle">{{ \Carbon\Carbon::parse($teacher->created_at)->format('F d, Y') }}</td>
                            <td class="align-middle text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{route('admin.users.teacher.show', ['teacher' => $teacher->id])}}" class="btn btn-xs btn-accent" title="View">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    <a href="{{route('admin.users.teacher.edit', ['teacher' => $teacher->id])}}" class="btn btn-xs btn-primary" title="Edit">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>
                                    <form action="{{route('admin.users.teacher.destroy', ['teacher' => $teacher->id ])}}"
                                          method="post" class="inline-block" onsubmit="return confirm('Delete teacher?')">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-xs btn-error" title="Delete">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">No Teacher</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {!! $teachers->links() !!}
            </div>
        </div>

        <!-- Pagination for mobile (keeps consistent UX) -->
        <div class="mt-4 block sm:hidden">
            {!! $teachers->links() !!}
        </div>
    </div>
</x-dashboard.admin.base>
