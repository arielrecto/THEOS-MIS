<x-dashboard.admin.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Gallery Management</h1>
                    <p class="text-gray-600">Manage website gallery images</p>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Filter Dropdown -->
                    <select class="select select-bordered" x-data x-on:change="window.location.href = $event.target.value">
                        <option value="{{ route('admin.CMS.gallery.index') }}" {{ request('filter') === null ? 'selected' : '' }}>
                            All Images
                        </option>
                        <option value="{{ route('admin.CMS.gallery.index', ['filter' => 'active']) }}" {{ request('filter') === 'active' ? 'selected' : '' }}>
                            Active Only
                        </option>
                        <option value="{{ route('admin.CMS.gallery.index', ['filter' => 'inactive']) }}" {{ request('filter') === 'inactive' ? 'selected' : '' }}>
                            Inactive Only
                        </option>
                    </select>

                    <a href="{{ route('admin.CMS.gallery.create') }}" class="btn btn-accent gap-2">
                        <i class="fi fi-rr-plus"></i>
                        Add Image
                    </a>
                </div>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($galleries as $gallery)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="aspect-video relative group">
                        <img src="{{ Storage::url($gallery->path) }}"
                             alt="{{ $gallery->name }}"
                             class="w-full h-full object-cover">
                        <!-- Overlay Controls -->
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <!-- Toggle Active Status -->
                            <form action="{{ route('admin.CMS.gallery.toggle', $gallery) }}"
                                  method="POST"
                                  x-data="{ submitting: false }"
                                  @submit="submitting = true">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                        class="btn btn-sm {{ $gallery->is_active ? 'btn-success' : 'btn-ghost' }} text-white"
                                        :disabled="submitting"
                                        title="{{ $gallery->is_active ? 'Set Inactive' : 'Set Active' }}">
                                    <template x-if="submitting">
                                        <span class="loading loading-spinner loading-xs"></span>
                                    </template>
                                    <template x-if="!submitting">
                                        <i class="fi fi-rr-{{ $gallery->is_active ? 'check' : 'circle' }}"></i>
                                    </template>
                                </button>
                            </form>

                            <!-- Delete Image -->
                            <form action="{{ route('admin.CMS.gallery.destroy', $gallery) }}"
                                  method="POST"
                                  x-data="{ submitting: false }"
                                  @submit.prevent="if(confirm('Are you sure you want to delete this image?')) { submitting = true; $el.submit(); }">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-ghost text-white"
                                        :disabled="submitting">
                                    <template x-if="submitting">
                                        <span class="loading loading-spinner loading-xs"></span>
                                    </template>
                                    <template x-if="!submitting">
                                        <i class="fi fi-rr-trash"></i>
                                    </template>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-medium truncate">{{ $gallery->name }}</h3>
                            <span class="badge badge-sm {{ $gallery->is_active ? 'badge-success' : 'badge-ghost' }}">
                                {{ $gallery->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 line-clamp-2">{{ $gallery->description }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xs text-gray-400">{{ $gallery->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-lg">
                    <div class="w-16 h-16 mb-4 text-gray-400">
                        <i class="fi fi-rr-picture text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No images uploaded</h3>
                    <p class="text-gray-500 mt-2">Get started by adding some images to your gallery</p>
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('imageToggle', () => ({
                    submitting: false
                }))
            })
        </script>
    @endpush
</x-dashboard.admin.base>
