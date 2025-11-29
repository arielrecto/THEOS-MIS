<x-dashboard.teacher.base>

    <x-dashboard.page-title :title="_('Announcements')"
     :back_url="route('teacher.classrooms.show', ['classroom' => $classroom_id])"
     :create_url="route('teacher.announcements.create', ['classroom_id' => $classroom_id])"  />
    <x-notification-message />

    <div class="panel min-h-96 p-4">
        <h1 class="text-lg py-2 text-accent font-bold">Announcements</h1>

        <!-- Mobile: stacked cards -->
        <div class="space-y-3 md:hidden">
            @forelse ($announcements as $announcement)
                <article class="bg-white border rounded-lg p-3 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="font-semibold text-sm truncate">{{ $announcement->title }}</h2>
                            <p class="text-xs text-gray-500 mt-1 truncate">{{ Str::limit($announcement->body ?? '', 120) }}</p>
                        </div>

                        <div class="text-xs text-gray-500 text-right whitespace-nowrap">
                            {{ $announcement->created_at->format('M d, Y h:i A') }}
                        </div>
                    </div>

                    <div class="mt-3 flex items-center justify-between gap-2">
                        <div class="text-xs text-gray-600">
                            <span class="badge badge-sm">{{ $announcement->type ?? 'General' }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{route('teacher.announcements.show', ['announcement' => $announcement->id, 'classroom_id' => $classroom_id])}}"
                               class="btn btn-xs btn-accent">
                                <i class="fi fi-rr-eye"></i>
                                <span class="sr-only">View</span>
                            </a>

                            <form action="" method="post" class="inline-block" onsubmit="return confirm('Delete this announcement?');">
                                @csrf
                                @method('delete')
                                <button class="btn btn-xs btn-error" type="submit" aria-label="Delete">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center text-gray-500 py-6">No Announcements</div>
            @endforelse
        </div>

        <!-- Desktop / Tablet: table -->
        <div class="overflow-x-auto hidden md:block">
            <table class="table w-full">
                <thead>
                    <tr class="bg-accent text-white">
                        <th class="w-12"></th>
                        <th class="text-left">Name</th>
                        <th class="text-left">Date Posted</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($announcements as $announcement)
                        <tr class="hover:bg-gray-50">
                            <th></th>
                            <td class="max-w-xl truncate">{{ $announcement->title }}</td>
                            <td class="whitespace-nowrap">{{ $announcement->created_at->format('F d, Y h:i A') }}</td>
                            <td class="text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{route('teacher.announcements.show', ['announcement' => $announcement->id, 'classroom_id' => $classroom_id])}}"
                                       class="btn btn-xs btn-accent">
                                        <i class="fi fi-rr-eye"></i>
                                        <span class="hidden lg:inline">View</span>
                                    </a>

                                    <form action="" method="post" class="inline-block" onsubmit="return confirm('Delete this announcement?');">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-xs btn-error" type="submit">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">No Announcement</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {!! $announcements->links() !!}
        </div>
    </div>
</x-dashboard.teacher.base>
