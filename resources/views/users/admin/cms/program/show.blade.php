<x-dashboard.admin.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Program Details</h1>
                    <p class="text-gray-600">View academic program information</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.CMS.programs.index') }}" class="btn btn-ghost gap-2">
                        <i class="fi fi-rr-arrow-left"></i>
                        Back to Programs
                    </a>
                    <form action="{{ route('admin.CMS.programs.toggle', $program) }}"
                          method="POST"
                          class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="btn {{ $program->is_active ? 'btn-success' : 'btn-ghost' }}"
                                title="{{ $program->is_active ? 'Set Inactive' : 'Set Active' }}">
                            <i class="fi fi-rr-{{ $program->is_active ? 'check' : 'circle' }}"></i>
                            {{ $program->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="aspect-video relative">
                <img src="{{ Storage::url($program->path) }}"
                     alt="{{ $program->title }}"
                     class="w-full h-full object-cover">
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold">{{ $program->title }}</h2>
                    <span class="badge">{{ $program->category }}</span>
                </div>
                <div class="prose max-w-none">
                    <p>{{ $program->description }}</p>
                </div>
                <div class="flex items-center justify-between mt-6 pt-6 border-t">
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <div class="flex items-center gap-1">
                            <i class="fi fi-rr-calendar"></i>
                            <span>Created {{ $program->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fi fi-rr-clock"></i>
                            <span>Last updated {{ $program->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
