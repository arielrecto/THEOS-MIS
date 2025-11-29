<x-dashboard.admin.base>
    <div class="container mx-auto p-4 sm:p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-lg sm:text-2xl font-bold text-gray-800">Gallery Management</h1>
                    <p class="text-sm sm:text-gray-600 mt-1">Manage website gallery images</p>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <!-- Filter Dropdown -->
                    <select class="select select-bordered w-full sm:w-auto" x-data x-on:change="window.location.href = $event.target.value">
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

                    <a href="{{ route('admin.CMS.gallery.create') }}" class="btn btn-accent gap-2 whitespace-nowrap">
                        <i class="fi fi-rr-plus"></i>
                        <span class="hidden sm:inline">Add Image</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Gallery Grid: responsive -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($galleries as $gallery)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="relative group">
                        <!-- Maintain aspect ratio on all viewports -->
                        <div class="aspect-video w-full bg-gray-100 overflow-hidden">
                            <img src="{{ Storage::url($gallery->path) }}"
                                 alt="{{ $gallery->name }}"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>

                        <!-- Overlay Controls: visible on hover for pointer devices, always visible (small) on touch/mobile -->
                        <div
                            class="absolute inset-0 flex flex-col justify-end p-3 pointer-events-none">
                            <!-- Mobile toolbar (always visible, small) -->
                            <div class="flex items-center justify-between gap-2 sm:hidden bg-black/30 rounded px-2 py-1 w-full pointer-events-auto">
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.CMS.gallery.toggle', $gallery) }}"
                                          method="POST" class="inline" x-data="{ submitting: false }" @submit="submitting = true">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="btn btn-xs {{ $gallery->is_active ? 'btn-success' : 'btn-ghost' }} text-white"
                                                :disabled="submitting"
                                                title="{{ $gallery->is_active ? 'Set Inactive' : 'Set Active' }}">
                                            <i class="fi fi-rr-{{ $gallery->is_active ? 'check' : 'circle' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.CMS.gallery.destroy', $gallery) }}"
                                          method="POST"
                                          x-data="{ submitting: false }"
                                          @submit.prevent="if(confirm('Are you sure you want to delete this image?')) { submitting = true; $el.submit(); }">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-xs btn-ghost text-white"
                                                :disabled="submitting"
                                                title="Delete">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                </div>

                                <a href="{{ Storage::url($gallery->path) }}" target="_blank" class="text-xs text-white underline">Open</a>
                            </div>

                            <!-- Desktop / larger devices: hover overlay -->
                            <div class="hidden sm:flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-auto">
                                <form action="{{ route('admin.CMS.gallery.toggle', $gallery) }}"
                                      method="POST" x-data="{ submitting: false }" @submit="submitting = true">
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

                                <form action="{{ route('admin.CMS.gallery.destroy', $gallery) }}"
                                      method="POST"
                                      x-data="{ submitting: false }"
                                      @submit.prevent="if(confirm('Are you sure you want to delete this image?')) { submitting = true; $el.submit(); }">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-ghost text-white"
                                            :disabled="submitting"
                                            title="Delete">
                                        <template x-if="submitting">
                                            <span class="loading loading-spinner loading-xs"></span>
                                        </template>
                                        <template x-if="!submitting">
                                            <i class="fi fi-rr-trash"></i>
                                        </template>
                                    </button>
                                </form>

                                <a href="{{ Storage::url($gallery->path) }}" target="_blank" class="btn btn-sm btn-ghost text-white">
                                    <i class="fi fi-rr-expand"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 sm:p-4">
                        <div class="flex items-start justify-between gap-3">
                            <h3 class="font-medium text-sm sm:text-base truncate">{{ $gallery->name }}</h3>
                            <span class="text-xs">
                                <span class="badge badge-sm {{ $gallery->is_active ? 'badge-success' : 'badge-ghost' }}">
                                    {{ $gallery->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </span>
                        </div>

                        <p class="text-xs sm:text-sm text-gray-500 mt-2 line-clamp-2">{{ $gallery->description }}</p>

                        <div class="flex items-center justify-between mt-3 text-xs sm:text-sm text-gray-400">
                            <span>{{ $gallery->created_at->diffForHumans() }}</span>
                            <a href="{{ route('admin.CMS.gallery.edit', $gallery) }}" class="hidden sm:inline text-primary text-xs">Edit</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-lg">
                    <div class="w-16 h-16 mb-4 text-gray-400">
                        <i class="fi fi-rr-picture text-4xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-medium text-gray-900">No images uploaded</h3>
                    <p class="text-sm sm:text-gray-500 mt-2 text-center">Get started by adding some images to your gallery</p>
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
