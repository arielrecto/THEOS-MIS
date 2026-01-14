<x-dashboard.admin.base>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm breadcrumbs mb-4">
                <a href="{{ route('admin.CMS.campus-content.index') }}" class="text-gray-600 hover:text-primary">
                    Campus Content
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900">View Details</span>
            </div>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Campus Content Details</h1>
                    <p class="text-sm text-gray-600 mt-1">View campus content information</p>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <a href="{{ route('admin.CMS.campus-content.edit', $campusContent) }}"
                        class="btn btn-primary gap-2 flex-1 sm:flex-none">
                        <i class="fi fi-rr-edit"></i>
                        Edit
                    </a>
                    <form action="{{ route('admin.CMS.campus-content.destroy', $campusContent) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this campus content?');"
                        class="flex-1 sm:flex-none">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-error gap-2 w-full">
                            <i class="fi fi-rr-trash"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success mb-6">
                <i class="fi fi-rr-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Content Card -->
        <div class="bg-white rounded-lg shadow-sm">
            <!-- Status Banner -->
            <div class="p-4 border-b {{ $campusContent->is_active ? 'bg-success/10' : 'bg-gray-50' }}">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if ($campusContent->is_active)
                            <span class="badge badge-success badge-lg gap-2">
                                <i class="fi fi-rr-check"></i>
                                Active Content
                            </span>
                        @else
                            <span class="badge badge-ghost badge-lg gap-2">
                                <i class="fi fi-rr-cross"></i>
                                Inactive
                            </span>
                        @endif
                    </div>
                    <span class="text-sm text-gray-500">
                        Updated {{ $campusContent->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            <!-- Content Details -->
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Title</label>
                        <div class="text-lg font-semibold text-gray-900">
                            {{ $campusContent->title }}
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Description -->
                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Description</label>
                        <div class="text-gray-700 whitespace-pre-line leading-relaxed bg-gray-50 p-4 rounded-lg">
                            {{ $campusContent->description }}
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Metadata -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-600 block mb-2">Created At</label>
                            <div class="text-gray-700">
                                {{ $campusContent->created_at->format('F j, Y \a\t g:i A') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $campusContent->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600 block mb-2">Last Updated</label>
                            <div class="text-gray-700">
                                {{ $campusContent->updated_at->format('F j, Y \a\t g:i A') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $campusContent->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Footer -->
            <div class="p-4 border-t bg-gray-50">
                <a href="{{ route('admin.CMS.campus-content.index') }}" class="btn btn-ghost gap-2">
                    <i class="fi fi-rr-arrow-left"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
