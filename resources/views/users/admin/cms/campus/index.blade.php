<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 break-words">Campuses</h1>
                <p class="text-sm text-gray-600">Manage campus information</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.CMS.programs.index') }}"
                   class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                    <i class="fi fi-rr-arrow-left"></i>
                    <span class="text-xs sm:text-sm">Back</span>
                </a>

                <a href="{{ route('admin.CMS.campuses.create') }}"
                   class="btn btn-accent btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                    <i class="fi fi-rr-plus"></i>
                    <span class="text-xs sm:text-sm">Add Campus</span>
                </a>
            </div>
        </div>

        <x-notification-message />

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 sm:p-6">
                <!-- Mobile cards -->
                <div class="md:hidden space-y-3">
                    @forelse($campuses as $campus)
                        <article class="border rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-14 h-14 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                    @if($campus->image?->file_dir)
                                        <img src="{{ asset($campus->image->file_dir) }}" alt="{{ $campus->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <i class="fi fi-rr-school text-2xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="font-semibold text-gray-800 truncate">{{ $campus->name }}</div>
                                    <div class="text-xs text-gray-500 mt-1 break-words line-clamp-2">{{ $campus->address ?? '—' }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $campus->email ?? '—' }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('admin.CMS.campuses.show', $campus) }}" class="btn btn-ghost btn-sm flex-1 justify-center gap-2">
                                    <i class="fi fi-rr-eye"></i><span class="text-xs">View</span>
                                </a>
                                <a href="{{ route('admin.CMS.campuses.edit', $campus) }}" class="btn btn-accent btn-sm flex-1 justify-center gap-2">
                                    <i class="fi fi-rr-edit"></i><span class="text-xs">Edit</span>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="py-10 text-center text-gray-500">No campuses found.</div>
                    @endforelse
                </div>

                <!-- Desktop table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Campus</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($campuses as $campus)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100">
                                                @if($campus->image?->file_dir)
                                                    <img src="{{ asset($campus->image->file_dir) }}" alt="{{ $campus->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <i class="fi fi-rr-school"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="font-medium text-gray-800">{{ $campus->name }}</div>
                                        </div>
                                    </td>
                                    <td class="max-w-[360px]">
                                        <div class="truncate text-gray-700">{{ $campus->address ?? '—' }}</div>
                                    </td>
                                    <td class="text-gray-700">{{ $campus->email ?? '—' }}</td>
                                    <td class="text-gray-700">{{ $campus->phone ?? '—' }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.CMS.campuses.show', $campus) }}" class="btn btn-ghost btn-sm">View</a>
                                        <a href="{{ route('admin.CMS.campuses.edit', $campus) }}" class="btn btn-accent btn-sm">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-gray-500">No campuses found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $campuses->links() }}
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
