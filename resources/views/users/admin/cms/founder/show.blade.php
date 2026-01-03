{{-- filepath: e:\Projects\Theos MIS\resources\views\users\admin\cms\founder\show.blade.php --}}
<x-dashboard.admin.base>
    <div class="w-full px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 break-words">Founder Details</h1>
                <p class="text-sm text-gray-600 break-words">{{ $founder->name }}</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.CMS.founders.index') }}" class="btn btn-ghost btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                    <i class="fi fi-rr-arrow-left"></i><span>Back</span>
                </a>
                <a href="{{ route('admin.CMS.founders.edit', $founder) }}" class="btn btn-accent btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                    <i class="fi fi-rr-edit"></i><span>Edit</span>
                </a>
                <form action="{{ route('admin.CMS.founders.destroy', $founder) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2"
                            onclick="return confirm('Delete this founder?')">
                        <i class="fi fi-rr-trash"></i><span>Delete</span>
                    </button>
                </form>
            </div>
        </div>

        <x-notification-message />

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-5">
                <div class="md:col-span-2 bg-gray-100">
                    <div class="aspect-square w-full">
                        @if($founder->image?->file_dir)
                            <img src="{{ asset($founder->image->file_dir) }}" alt="{{ $founder->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fi fi-rr-user text-5xl"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="md:col-span-3 p-4 sm:p-6 space-y-4">
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 break-words">{{ $founder->name }}</h2>
                        <span class="text-xs px-2 py-1 rounded-full {{ $founder->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                            {{ $founder->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="border-t pt-4">
                        <div class="text-sm font-semibold text-gray-700 mb-2">Bio</div>
                        <p class="text-sm text-gray-700 break-words leading-relaxed whitespace-pre-line">{{ $founder->bio ?? '—' }}</p>
                    </div>

                    <div class="border-t pt-4 text-xs text-gray-500">
                        Created {{ $founder->created_at->diffForHumans() }}
                        @if($founder->updated_at->ne($founder->created_at))
                            • Updated {{ $founder->updated_at->diffForHumans() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
