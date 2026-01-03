<x-dashboard.admin.base>
    <div class="container mx-auto p-4 sm:p-6">
            <x-notification-message/>
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-lg sm:text-2xl font-bold text-gray-800">Logo Management</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Manage website logos and favicons</p>
        </div>

        <!-- Upload Form -->
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-6">
            <h2 class="text-base sm:text-lg font-semibold mb-4">Upload New Logo</h2>

            <!-- form stacks on mobile, grid on md+ -->
            <form action="{{ route('admin.CMS.logos.store') }}" method="POST" enctype="multipart/form-data"
                  class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label text-xs sm:text-sm">Name</label>
                        <input type="text" name="name" class="input input-bordered w-full" required>
                    </div>

                    <div class="form-control">
                        <label class="label text-xs sm:text-sm">Type</label>
                        <select name="type" class="select select-bordered w-full" required>
                            <option value="">Select Type</option>
                            <option value="main">Main Logo</option>
                            <option value="favicon">Favicon</option>
                            <option value="footer">Footer Logo</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label text-xs sm:text-sm">Logo File</label>
                        <input type="file" name="logo" class="file-input file-input-bordered w-full" required accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">PNG/SVG recommended for logos. Max 5MB.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-2">
                    <button type="submit" class="btn btn-primary w-full sm:w-auto">Upload Logo</button>
                </div>
            </form>
        </div>

        <!-- Logo Gallery -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($logos->groupBy('type') as $type => $typeLogos)
                <div class="bg-white rounded-lg shadow-sm p-4 flex flex-col">
                    <h3 class="text-base sm:text-lg font-semibold mb-3 capitalize">{{ $type }} Logos</h3>

                    <div class="space-y-4">
                        @foreach($typeLogos as $logo)
                            <div class="border rounded-lg p-3 flex flex-col sm:flex-row items-start gap-3">
                                <div class="w-full sm:w-36 flex-shrink-0">
                                    <div class="aspect-[4/3] sm:aspect-video bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                                        <img src="{{ Storage::url($logo->path) }}"
                                             alt="{{ $logo->name }}"
                                             class="w-full h-full object-contain" />
                                    </div>
                                </div>

                                <div class="flex-1 w-0">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h4 class="font-medium text-sm sm:text-base truncate">{{ $logo->name }}</h4>
                                            <p class="text-xs text-gray-500 mt-1 truncate">Added {{ $logo->created_at->diffForHumans() }}</p>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('admin.CMS.logos.destroy', $logo) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this logo?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-ghost text-error" title="Delete">
                                                    <i class="fi fi-rr-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    @if($logo->description)
                                        <p class="text-xs text-gray-600 mt-2 line-clamp-2">{{ $logo->description }}</p>
                                    @endif

                                    <div class="mt-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <div>
                                            {{-- Toggle Active/Inactive --}}
                                            <form action="{{ route('admin.CMS.logos.toggle', $logo) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit"
                                                        title="Click to toggle status"
                                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap border
                                                               {{ $logo->is_active
                                                                    ? 'bg-green-100 text-green-800 border-green-200 hover:bg-green-200'
                                                                    : 'bg-gray-100 text-gray-700 border-gray-200 hover:bg-gray-200' }}">
                                                    <span class="w-2 h-2 rounded-full {{ $logo->is_active ? 'bg-green-600' : 'bg-gray-500' }}"></span>
                                                    {{ $logo->is_active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            {{-- <a href="{{ Storage::url($logo->path) }}" target="_blank" class="text-xs text-primary underline">Open</a> --}}
                                            {{-- <a href="{{ route('admin.CMS.logos.edit', $logo) }}" class="hidden sm:inline text-xs text-primary">Edit</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-lg">
                    <div class="flex flex-col items-center gap-3">
                        <i class="fi fi-rr-picture text-4xl text-gray-400"></i>
                        <p class="text-gray-500">No logos uploaded yet</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>


</x-dashboard.admin.base>
