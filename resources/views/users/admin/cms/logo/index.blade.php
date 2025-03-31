<x-dashboard.admin.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Logo Management</h1>
            <p class="text-gray-600">Manage website logos and favicons</p>
        </div>

        <!-- Upload Form -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Upload New Logo</h2>
            <form action="{{ route('admin.CMS.logos.store') }}" method="POST" enctype="multipart/form-data"
                  class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label">Name</label>
                        <input type="text" name="name" class="input input-bordered" required>
                    </div>
                    <div class="form-control">
                        <label class="label">Type</label>
                        <select name="type" class="select select-bordered" required>
                            <option value="">Select Type</option>
                            <option value="main">Main Logo</option>
                            <option value="favicon">Favicon</option>
                            <option value="footer">Footer Logo</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label">Logo File</label>
                        <input type="file" name="logo" class="file-input file-input-bordered" required
                               accept="image/*">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">Upload Logo</button>
                </div>
            </form>
        </div>

        <!-- Logo Gallery -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($logos->groupBy('type') as $type => $typeLogos)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold mb-4 capitalize">{{ $type }} Logos</h3>
                    <div class="space-y-4">
                        @foreach($typeLogos as $logo)
                            <div class="border rounded-lg p-4 {{ $logo->is_active ? 'border-accent' : '' }}">
                                <div class="aspect-video relative rounded-lg overflow-hidden bg-gray-100 mb-3">
                                    <img src="{{ Storage::url($logo->path) }}"
                                         alt="{{ $logo->name }}"
                                         class="w-full h-full object-contain">
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium">{{ $logo->name }}</h4>
                                        <p class="text-sm text-gray-500">
                                            Added {{ $logo->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.CMS.logos.toggle', $logo) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="btn btn-sm {{ $logo->is_active ? 'btn-accent' : 'btn-ghost' }}"
                                                    title="{{ $logo->is_active ? 'Active' : 'Inactive' }}">
                                                <i class="fi fi-rr-{{ $logo->is_active ? 'check' : 'circle' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.CMS.logos.destroy', $logo) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this logo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-ghost btn-sm text-error">
                                                <i class="fi fi-rr-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-lg">
                    <div class="flex flex-col items-center gap-3">
                        <i class="fi fi-rr-picture text-4xl text-gray-400"></i>
                        <p class="text-gray-500">No logos uploaded yet</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <x-notification-message/>
</x-dashboard.admin.base>
