<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 break-words">Login Content Details</h1>
                <p class="text-sm text-gray-600 break-words">{{ $loginContent->title }}</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.CMS.login-contents.index') }}" class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                    <i class="fi fi-rr-arrow-left"></i><span>Back</span>
                </a>
                <a href="{{ route('admin.CMS.login-contents.edit', $loginContent) }}" class="btn btn-accent btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                    <i class="fi fi-rr-edit"></i><span>Edit</span>
                </a>
                <form action="{{ route('admin.CMS.login-contents.destroy', $loginContent) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2"
                            onclick="return confirm('Delete this content?')">
                        <i class="fi fi-rr-trash"></i><span>Delete</span>
                    </button>
                </form>
            </div>
        </div>

        <x-notification-message />

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            @if($loginContent->backgroundImage?->file_dir)
                <div class="w-full h-64 sm:h-80 bg-gray-100">
                    <img src="{{ asset($loginContent->backgroundImage->file_dir) }}" alt="{{ $loginContent->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-4 sm:p-6 space-y-4">
                <div class="flex items-center gap-2">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 break-words">{{ $loginContent->title }}</h2>
                    <span class="text-xs px-2 py-1 rounded-full {{ $loginContent->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                        {{ $loginContent->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                @if($loginContent->description)
                    <div class="border-t pt-4">
                        <div class="text-sm font-semibold text-gray-700 mb-2">Description</div>
                        <p class="text-sm text-gray-700 break-words leading-relaxed whitespace-pre-line">{{ $loginContent->description }}</p>
                    </div>
                @endif

                <div class="border-t pt-4 text-xs text-gray-500">
                    Created {{ $loginContent->created_at->diffForHumans() }}
                    @if($loginContent->updated_at->ne($loginContent->created_at))
                        • Updated {{ $loginContent->updated_at->diffForHumans() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
