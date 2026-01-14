<x-dashboard.admin.base>
    <div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-5xl">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.CMS.core-values.index') }}" class="btn btn-ghost btn-sm">
                    <i class="fi fi-rr-arrow-left"></i>
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Core Value Details</h1>
            </div>
            <p class="text-sm text-gray-600 ml-12">View core value information and items</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Header Info -->
            <div class="p-6 border-b">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $coreValue->title }}</h2>
                    @if ($coreValue->is_active)
                        <span class="badge badge-success badge-lg">Active</span>
                    @else
                        <span class="badge badge-ghost badge-lg">Inactive</span>
                    @endif
                </div>
                <p class="text-gray-600 leading-relaxed">{{ $coreValue->description }}</p>
            </div>

            <!-- Details -->
            <div class="p-6 space-y-6">
                <!-- Information Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg">
                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-1">Total Items</label>
                        <p class="text-gray-900">{{ $coreValue->items->count() }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-1">Created At</label>
                        <p class="text-gray-900">{{ $coreValue->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-1">Last Updated</label>
                        <p class="text-gray-900">{{ $coreValue->updated_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>

                <div class="divider"></div>

                <!-- Core Value Items -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Core Value Items
                        ({{ $coreValue->items->count() }})</h3>

                    @forelse($coreValue->items as $item)
                        <div class="bg-gray-50 p-4 rounded-lg mb-3 border border-gray-200">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $item->item_name }}</h4>
                                @if ($item->is_active)
                                    <span class="badge badge-success badge-sm">Active</span>
                                @else
                                    <span class="badge badge-ghost badge-sm">Inactive</span>
                                @endif
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $item->item_description }}</p>
                            <div class="mt-3 flex gap-2">
                                <form action="{{ route('admin.CMS.core-value-items.toggle-active', $item) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-xs btn-warning">
                                        <i class="fi fi-rr-refresh"></i>
                                        {{ $item->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.CMS.core-value-items.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-error">
                                        <i class="fi fi-rr-trash"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <i class="fi fi-rr-list text-4xl text-gray-400 mb-2 block"></i>
                            <p class="text-gray-500">No items added yet</p>
                            <a href="{{ route('admin.CMS.core-values.edit', $coreValue) }}"
                                class="btn btn-sm btn-primary mt-3">
                                <i class="fi fi-rr-plus"></i>
                                Add Items
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t">
                    <a href="{{ route('admin.CMS.core-values.edit', $coreValue) }}"
                        class="btn btn-primary flex-1 sm:flex-none">
                        <i class="fi fi-rr-edit"></i>
                        Edit Core Value
                    </a>
                    <form action="{{ route('admin.CMS.core-values.toggle-active', $coreValue) }}" method="POST"
                        class="flex-1 sm:flex-none">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning w-full">
                            <i class="fi fi-rr-refresh"></i>
                            {{ $coreValue->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.CMS.core-values.destroy', $coreValue) }}" method="POST"
                        class="flex-1 sm:flex-none"
                        onsubmit="return confirm('Are you sure you want to delete this core value and all its items?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-error w-full">
                            <i class="fi fi-rr-trash"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
