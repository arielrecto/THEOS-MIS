<x-dashboard.admin.base>
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Header Content Management</h1>
                <p class="text-sm text-gray-600 mt-1">Manage website header content and banners</p>
            </div>
            <a href="{{ route('admin.CMS.header-contents.create') }}" class="btn btn-primary btn-sm sm:btn-md">
                <i class="fi fi-rr-plus"></i>
                <span>Add New Content</span>
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-6">
                <i class="fi fi-rr-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-4">
            @forelse($headerContents as $content)
                <article class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 break-words">{{ $content->title }}</h3>
                            <p class="text-xs text-gray-500 mt-1 break-words">{{ Str::limit($content->subtitle, 60) }}
                            </p>
                        </div>
                        @if ($content->is_active)
                            <span class="badge badge-success badge-sm flex-shrink-0">Active</span>
                        @else
                            <span class="badge badge-ghost badge-sm flex-shrink-0">Inactive</span>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2 text-xs text-gray-600 mb-3">
                        <div class="flex items-center gap-1">
                            <i class="fi fi-rr-calendar"></i>
                            <span>{{ $content->created_at->format('M d, Y') }}</span>
                        </div>
                        @if ($content->show_button)
                            <div class="flex items-center gap-1">
                                <i class="fi fi-rr-cursor-finger"></i>
                                <span>Has Button</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.CMS.header-contents.show', $content) }}"
                            class="btn btn-ghost btn-xs flex-1 sm:flex-none">
                            <i class="fi fi-rr-eye"></i> View
                        </a>
                        <a href="{{ route('admin.CMS.header-contents.edit', $content) }}"
                            class="btn btn-primary btn-xs flex-1 sm:flex-none">
                            <i class="fi fi-rr-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.CMS.header-contents.toggle-active', $content) }}" method="POST"
                            class="flex-1 sm:flex-none">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning btn-xs w-full">
                                <i class="fi fi-rr-refresh"></i> Toggle
                            </button>
                        </form>
                        <form action="{{ route('admin.CMS.header-contents.destroy', $content) }}" method="POST"
                            class="flex-1 sm:flex-none"
                            onsubmit="return confirm('Are you sure you want to delete this content?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error btn-xs w-full">
                                <i class="fi fi-rr-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="bg-gray-50 rounded-lg p-8 text-center">
                    <i class="fi fi-rr-document text-4xl text-gray-400 mb-3 block"></i>
                    <p class="text-gray-600">No header content found</p>
                    <a href="{{ route('admin.CMS.header-contents.create') }}" class="btn btn-primary btn-sm mt-4">
                        Create First Content
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="whitespace-nowrap">Title</th>
                            <th class="whitespace-nowrap">Subtitle</th>
                            <th class="whitespace-nowrap">Button</th>
                            <th class="whitespace-nowrap">Status</th>
                            <th class="whitespace-nowrap">Created</th>
                            <th class="text-right whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($headerContents as $content)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="font-medium">
                                    <div class="max-w-xs truncate">{{ $content->title }}</div>
                                </td>
                                <td>
                                    <div class="max-w-xs truncate text-sm text-gray-600">
                                        {{ $content->subtitle ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    @if ($content->show_button)
                                        <span class="badge badge-info badge-sm">{{ $content->button_text }}</span>
                                    @else
                                        <span class="text-gray-400 text-sm">No button</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($content->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-ghost">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-sm text-gray-600">
                                    {{ $content->created_at->format('M d, Y') }}
                                </td>
                                <td>
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.CMS.header-contents.show', $content) }}"
                                            class="btn btn-ghost btn-xs" aria-label="View">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.CMS.header-contents.edit', $content) }}"
                                            class="btn btn-primary btn-xs" aria-label="Edit">
                                            <i class="fi fi-rr-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.CMS.header-contents.toggle-active', $content) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-warning btn-xs"
                                                aria-label="Toggle status">
                                                <i class="fi fi-rr-refresh"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.CMS.header-contents.destroy', $content) }}"
                                            method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error btn-xs" aria-label="Delete">
                                                <i class="fi fi-rr-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8">
                                    <i class="fi fi-rr-document text-4xl text-gray-400 mb-3 block"></i>
                                    <p class="text-gray-600">No header content found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($headerContents->hasPages())
            <div class="mt-6">
                {{ $headerContents->links() }}
            </div>
        @endif
    </div>
</x-dashboard.admin.base>
