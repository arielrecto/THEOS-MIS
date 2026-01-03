<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 break-words">Campus Details</h1>
                <p class="text-sm text-gray-600 break-words">{{ $campus->name }}</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.CMS.campuses.index') }}" class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                    <i class="fi fi-rr-arrow-left"></i><span>Back</span>
                </a>
                <a href="{{ route('admin.CMS.campuses.edit', $campus) }}" class="btn btn-accent btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                    <i class="fi fi-rr-edit"></i><span>Edit</span>
                </a>
                <form action="{{ route('admin.CMS.campuses.destroy', $campus) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2"
                            onclick="return confirm('Delete this campus?')">
                        <i class="fi fi-rr-trash"></i><span>Delete</span>
                    </button>
                </form>
            </div>
        </div>

        <x-notification-message />

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-5">
                <div class="md:col-span-2 bg-gray-100">
                    <div class="aspect-video md:aspect-square w-full">
                        @if($campus->image?->file_dir)
                            <img src="{{ asset($campus->image->file_dir) }}" alt="{{ $campus->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fi fi-rr-school text-5xl"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-3 p-4 sm:p-6 space-y-4">
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 break-words">{{ $campus->name }}</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div class="bg-gray-50 p-3 rounded">
                            <div class="text-xs text-gray-500">Email</div>
                            <div class="font-medium text-gray-800 break-words">{{ $campus->email ?? '—' }}</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <div class="text-xs text-gray-500">Phone</div>
                            <div class="font-medium text-gray-800 break-words">{{ $campus->phone ?? '—' }}</div>
                        </div>
                        <div class="sm:col-span-2 bg-gray-50 p-3 rounded">
                            <div class="text-xs text-gray-500">Address</div>
                            <div class="font-medium text-gray-800 break-words">{{ $campus->address ?? '—' }}</div>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <div class="text-sm font-semibold text-gray-700 mb-2">Description</div>
                        <p class="text-sm text-gray-700 break-words leading-relaxed whitespace-pre-line">{{ $campus->description ?? '—' }}</p>
                    </div>

                    <div class="border-t pt-4 text-xs text-gray-500">
                        Created {{ $campus->created_at->diffForHumans() }}
                        @if($campus->updated_at->ne($campus->created_at))
                            • Updated {{ $campus->updated_at->diffForHumans() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
