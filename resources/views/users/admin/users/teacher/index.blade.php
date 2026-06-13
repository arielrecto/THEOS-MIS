<x-dashboard.admin.base>
    <x-dashboard.page-title :back_url="route('admin.users.index')" :title="_('Teachers')" :create_url="route('admin.users.teacher.create')" />

    <x-notification-message />

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.users.teacher.index') }}"
          class="flex flex-wrap items-end gap-3 mb-4">
        <div class="flex-1 min-w-[180px]">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search name or email..."
                   class="input input-bordered input-sm w-full" />
        </div>
        <div class="min-w-[150px]">
            <select name="grade_level" class=" text-xs select select-bordered select-sm w-full">
                <option value="">All Grade Levels</option>
                @foreach($gradeLevels as $level)
                    <option value="{{ $level }}" {{ request('grade_level') === $level ? 'selected' : '' }}>
                        {{ $level }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-accent btn-sm gap-2 text-white">
            <i class="fi fi-rr-search"></i> Filter
        </button>
        @if(request()->hasAny(['search', 'grade_level']))
            <a href="{{ route('admin.users.teacher.index') }}" class="btn btn-ghost btn-sm gap-2">
                <i class="fi fi-rr-cross-small"></i> Clear
            </a>
        @endif
    </form>

    {{-- Result count --}}
    @if($teachers->total())
        <p class="text-sm text-gray-500 mb-3">
            Showing {{ $teachers->firstItem() }}–{{ $teachers->lastItem() }} of {{ $teachers->total() }} teacher(s)
        </p>
    @endif

    {{-- Mobile Cards --}}
    <div class="block sm:hidden space-y-3">
        @forelse ($teachers as $teacher)
            @php $grades = $teacher->teacherClassrooms->pluck('strand.name')->unique()->filter()->values(); @endphp
            <div class="bg-base-100 rounded-lg shadow-lg p-4">
                <div class="flex items-start gap-3">
                    <div class="avatar placeholder shrink-0">
                        <div class="bg-accent text-white rounded-full w-12 h-12">
                            <span class="text-lg font-bold">{{ strtoupper(substr($teacher->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 truncate">{{ $teacher->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $teacher->email }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Joined {{ \Carbon\Carbon::parse($teacher->created_at)->format('M d, Y') }}
                        </p>
                        @if($grades->count())
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach($grades as $grade)
                                    <span class="badge badge-accent badge-sm">{{ $grade }}</span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-xs text-gray-400 mt-1 block">No classrooms assigned</span>
                        @endif
                    </div>
                </div>
                <div class="mt-3 flex flex-wrap gap-2">
                    <a href="{{ route('admin.users.teacher.show', $teacher->id) }}"
                       class="btn btn-ghost btn-sm flex-1 min-w-[80px] gap-1 text-xs">
                        <i class="fi fi-rr-eye"></i> View
                    </a>
                    <a href="{{ route('admin.users.teacher.edit', $teacher->id) }}"
                       class="btn btn-ghost btn-sm flex-1 min-w-[80px] gap-1 text-xs">
                        <i class="fi fi-rr-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.users.teacher.destroy', $teacher->id) }}" method="post"
                          class="flex-1 min-w-[80px]"
                          onsubmit="return confirm('Are you sure you want to delete this teacher?')">
                        @csrf @method('delete')
                        <button class="btn btn-ghost btn-sm text-error w-full gap-1 text-xs">
                            <i class="fi fi-rr-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-base-100 rounded-lg shadow-lg p-8 text-center text-gray-400">
                <i class="fi fi-rr-users block text-3xl mb-2"></i>
                <p class="text-sm">No teachers found</p>
            </div>
        @endforelse
    </div>

    {{-- Desktop Table --}}
    <div class="hidden sm:block overflow-x-auto rounded-lg border border-base-200">
        <table class="table table-zebra w-full text-sm">
            <thead>
                <tr class="bg-base-200 text-gray-600 uppercase text-xs tracking-wide">
                    <th>Teacher</th>
                    <th>Email</th>
                    <th>Grade Levels Handled</th>
                    <th>Classrooms</th>
                    <th>Date Joined</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($teachers as $teacher)
                    @php $grades = $teacher->teacherClassrooms->pluck('strand.name')->unique()->filter()->values(); @endphp
                    <tr class="hover">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar placeholder shrink-0">
                                    <div class="bg-accent/20 text-accent rounded-full w-9 h-9">
                                        <span class="font-bold text-sm">{{ strtoupper(substr($teacher->name, 0, 1)) }}</span>
                                    </div>
                                </div>
                                <span class="font-semibold text-gray-800">{{ $teacher->name }}</span>
                            </div>
                        </td>
                        <td class="text-gray-500">{{ $teacher->email }}</td>
                        <td>
                            @if($grades->count())
                                <div class="flex flex-wrap gap-1">
                                    @foreach($grades as $grade)
                                        <span class="badge badge-accent badge-sm">{{ $grade }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-ghost badge-sm">
                                {{ $teacher->teacherClassrooms->count() }}
                            </span>
                        </td>
                        <td class="text-gray-500 text-xs">
                            {{ \Carbon\Carbon::parse($teacher->created_at)->format('F d, Y') }}
                        </td>
                        <td class="text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.users.teacher.show', $teacher->id) }}"
                                   class="btn btn-ghost btn-xs gap-1" title="View">
                                    <i class="fi fi-rr-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.teacher.edit', $teacher->id) }}"
                                   class="btn btn-ghost btn-xs gap-1" title="Edit">
                                    <i class="fi fi-rr-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.teacher.destroy', $teacher->id) }}" method="post"
                                      class="inline-block" onsubmit="return confirm('Delete this teacher?')">
                                    @csrf @method('delete')
                                    <button class="btn btn-ghost btn-xs text-error" title="Delete">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-gray-400">
                            <i class="fi fi-rr-users block text-3xl mb-2"></i>
                            No teachers found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {!! $teachers->links() !!}
    </div>

</x-dashboard.admin.base>
