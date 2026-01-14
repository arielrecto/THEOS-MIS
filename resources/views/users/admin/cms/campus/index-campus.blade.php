<x-dashboard.admin.base>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Campus Content Management</h1>
                <p class="text-sm text-gray-600 mt-1">Manage campus section title and description</p>
            </div>
            <a href="{{ route('admin.CMS.campus-content.create') }}"
                class="btn btn-primary gap-2 w-full sm:w-auto">
                <i class="fi fi-rr-plus"></i>
                <span>Add Campus Content</span>
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success mb-6">
                <i class="fi fi-rr-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Campus Content List -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            @if ($campusContents->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th class="bg-gray-50">Title</th>
                                <th class="bg-gray-50 hidden md:table-cell">Description</th>
                                <th class="bg-gray-50">Status</th>
                                <th class="bg-gray-50">Last Updated</th>
                                <th class="bg-gray-50 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($campusContents as $content)
                                <tr class="hover:bg-gray-50">
                                    <td>
                                        <div class="font-medium text-gray-900">{{ $content->title }}</div>
                                        <div class="text-sm text-gray-500 md:hidden">
                                            {{ Str::limit($content->description, 50) }}
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell">
                                        <div class="text-sm text-gray-600">
                                            {{ Str::limit($content->description, 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($content->is_active)
                                            <span
                                                class="badge badge-success gap-1">
                                                <i class="fi fi-rr-check text-xs"></i>
                                                Active
                                            </span>
                                        @else
                                            <span class="badge badge-ghost gap-1">
                                                <i class="fi fi-rr-cross text-xs"></i>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-sm text-gray-500">
                                            {{ $content->updated_at->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.CMS.campus-content.show', $content) }}"
                                                class="btn btn-sm btn-ghost gap-1"
                                                title="View">
                                                <i class="fi fi-rr-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.CMS.campus-content.edit', $content) }}"
                                                class="btn btn-sm btn-primary gap-1"
                                                title="Edit">
                                                <i class="fi fi-rr-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.CMS.campus-content.destroy', $content) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this campus content?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-error gap-1"
                                                    title="Delete">
                                                    <i class="fi fi-rr-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-t">
                    {{ $campusContents->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fi fi-rr-info-circle text-4xl text-gray-400 mb-4 block"></i>
                    <p class="text-gray-500 mb-4">No campus content available</p>
                    <a href="{{ route('admin.CMS.campus-content.create') }}"
                        class="btn btn-primary gap-2">
                        <i class="fi fi-rr-plus"></i>
                        Create First Campus Content
                    </a>
                </div>
            @endif
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i class="fi fi-rr-info-circle text-xl text-blue-600 mt-0.5"></i>
                <div>
                    <h3 class="font-semibold text-blue-900 mb-1">About Campus Content</h3>
                    <p class="text-sm text-blue-800">
                        Campus content manages the title and description shown in the campus section of your landing page.
                        Only one content can be active at a time. Setting a new content as active will automatically
                        deactivate others.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>