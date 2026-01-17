<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 break-words">Login Content</h1>
                <p class="text-sm text-gray-600">Manage login page backgrounds and content</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.CMS.index') }}"
                   class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                    <i class="fi fi-rr-arrow-left"></i>
                    <span class="text-xs sm:text-sm">Back</span>
                </a>

                <a href="{{ route('admin.CMS.login-contents.create') }}"
                   class="btn btn-accent btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                    <i class="fi fi-rr-plus"></i>
                    <span class="text-xs sm:text-sm">Add Content</span>
                </a>
            </div>
        </div>

        <x-notification-message />

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 sm:p-6">
                <!-- Mobile cards -->
                <div class="md:hidden space-y-3">
                    @forelse($loginContents as $content)
                        <article class="border rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-20 h-14 rounded overflow-hidden bg-gray-100 flex-shrink-0">
                                    @if($content->backgroundImage?->file_dir)
                                        <img src="{{ asset($content->backgroundImage->file_dir) }}" alt="{{ $content->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <i class="fi fi-rr-picture text-xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold text-gray-800 truncate">{{ $content->title }}</div>
                                        <span class="text-xs px-2 py-0.5 rounded-full {{ $content->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                            {{ $content->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1 line-clamp-2 break-words">{{ $content->description ?? '—' }}</div>
                                </div>
                            </div>

                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('admin.CMS.login-contents.show', $content) }}" class="btn btn-ghost btn-sm flex-1 justify-center gap-2">
                                    <i class="fi fi-rr-eye"></i><span class="text-xs">View</span>
                                </a>
                                <a href="{{ route('admin.CMS.login-contents.edit', $content) }}" class="btn btn-accent btn-sm flex-1 justify-center gap-2">
                                    <i class="fi fi-rr-edit"></i><span class="text-xs">Edit</span>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="py-10 text-center text-gray-500">No login content found.</div>
                    @endforelse
                </div>

                <!-- Desktop table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Content</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loginContents as $content)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-16 h-12 rounded overflow-hidden bg-gray-100">
                                                @if($content->backgroundImage?->file_dir)
                                                    <img src="{{ asset($content->backgroundImage->file_dir) }}" alt="{{ $content->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <i class="fi fi-rr-picture"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="font-medium text-gray-800">{{ $content->title }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-xs px-2 py-1 rounded-full {{ $content->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                            {{ $content->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="max-w-[420px]">
                                        <div class="truncate text-gray-700">{{ $content->description ?? '—' }}</div>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.CMS.login-contents.show', $content) }}" class="btn btn-ghost btn-sm">View</a>
                                        <a href="{{ route('admin.CMS.login-contents.edit', $content) }}" class="btn btn-accent btn-sm">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-gray-500">No login content found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $loginContents->links() }}
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
