<x-dashboard.admin.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Academic Programs</h1>
                    <p class="text-gray-600">Manage school academic programs</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.CMS.academic-program-label.index') }}" class="btn btn-ghost gap-2">
                        <i class="fi fi-rr-tags"></i>
                        Manage Labels
                    </a>
                    <a href="{{ route('admin.CMS.programs.create') }}" class="btn btn-accent gap-2">
                        <i class="fi fi-rr-plus"></i>
                        Add Program
                    </a>
                </div>
            </div>
        </div>

        <!-- Programs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($programs as $program)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="aspect-video relative group">
                        <img src="{{ Storage::url($program->path) }}" alt="{{ $program->title }}"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="absolute inset-0 flex items-center justify-center gap-2">
                                <a href="{{ route('admin.CMS.programs.show', $program) }}"
                                    class="btn btn-sm btn-ghost text-white">
                                    <i class="fi fi-rr-eye"></i>
                                </a>
                                <form action="{{ route('admin.CMS.programs.toggle', $program) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="btn btn-sm {{ $program->is_active ? 'btn-success' : 'btn-ghost' }} text-white"
                                        title="{{ $program->is_active ? 'Set Inactive' : 'Set Active' }}">
                                        <i class="fi fi-rr-{{ $program->is_active ? 'check' : 'circle' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.CMS.programs.destroy', $program) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this program?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost text-white">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-medium truncate">{{ $program->title }}</h3>
                            <span class="badge badge-sm {{ $program->is_active ? 'badge-success' : 'badge-ghost' }}">
                                {{ $program->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 line-clamp-2">{{ $program->description }}</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="badge badge-sm">{{ $program->category }}</span>
                            <span class="text-xs text-gray-400">{{ $program->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-lg">
                    <div class="w-16 h-16 mb-4 text-gray-400">
                        <i class="fi fi-rr-graduation-cap text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No programs added</h3>
                    <p class="text-gray-500 mt-2">Get started by adding your first academic program</p>
                </div>
            @endforelse
        </div>
    </div>
</x-dashboard.admin.base>
