<x-dashboard.admin.base>
    <div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-5xl">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.CMS.core-values.index') }}" class="btn btn-ghost btn-sm">
                    <i class="fi fi-rr-arrow-left"></i>
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Create Core Value</h1>
            </div>
            <p class="text-sm text-gray-600 ml-12">Add new core value with items</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <form action="{{ route('admin.CMS.core-values.store') }}" method="POST" class="space-y-6"
                x-data="coreValueForm()">
                @csrf

                <!-- Title -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-semibold">Title <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="input input-bordered w-full @error('title') input-error @enderror"
                        placeholder="e.g., Our Core Values" required>
                    @error('title')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-semibold">Description <span class="text-error">*</span></span>
                    </label>
                    <textarea name="description" rows="4"
                        class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                        placeholder="Enter core value description" required>{{ old('description') }}</textarea>
                    @error('description')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-success"
                            {{ old('is_active') ? 'checked' : '' }}>
                        <div>
                            <span class="label-text font-semibold">Set as Active</span>
                            <p class="text-xs text-gray-500 mt-1">Only one core value can be active at a time</p>
                        </div>
                    </label>
                </div>

                <div class="divider"></div>

                <!-- Core Value Items -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Core Value Items</h3>
                        <button type="button" @click="addItem()" class="btn btn-sm btn-secondary">
                            <i class="fi fi-rr-plus"></i>
                            Add Item
                        </button>
                    </div>

                    <div class="space-y-4" x-show="items.length > 0">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-start justify-between mb-3">
                                    <h4 class="font-medium text-gray-700">Item <span x-text="index + 1"></span></h4>
                                    <button type="button" @click="removeItem(index)"
                                        class="btn btn-ghost btn-xs text-error">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </div>

                                <div class="space-y-3">
                                    <!-- Item Name -->
                                    <div class="form-control w-full">
                                        <label class="label">
                                            <span class="label-text text-sm">Item Name <span
                                                    class="text-error">*</span></span>
                                        </label>
                                        <input type="text" :name="`items[${index}][item_name]`"
                                            x-model="item.item_name" class="input input-bordered input-sm w-full"
                                            placeholder="e.g., Academic Excellence" required>
                                    </div>

                                    <!-- Item Description -->
                                    <div class="form-control w-full">
                                        <label class="label">
                                            <span class="label-text text-sm">Item Description <span
                                                    class="text-error">*</span></span>
                                        </label>
                                        <textarea :name="`items[${index}][item_description]`" x-model="item.item_description" rows="2"
                                            class="textarea textarea-bordered textarea-sm w-full" placeholder="Enter item description" required></textarea>
                                    </div>

                                    <!-- Item Active Status -->
                                    <div class="form-control">
                                        <label class="label cursor-pointer justify-start gap-2">
                                            <input type="checkbox" :name="`items[${index}][is_active]`" value="1"
                                                x-model="item.is_active" class="checkbox checkbox-xs checkbox-success">
                                            <span class="label-text text-sm">Active</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="items.length === 0" class="text-center py-8 bg-gray-50 rounded-lg">
                        <i class="fi fi-rr-list text-3xl text-gray-400 mb-2 block"></i>
                        <p class="text-gray-500 text-sm">No items added yet. Click "Add Item" to get started.</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="btn btn-primary flex-1 sm:flex-none">
                        <i class="fi fi-rr-check"></i>
                        Create Core Value
                    </button>
                    <a href="{{ route('admin.CMS.core-values.index') }}" class="btn btn-ghost flex-1 sm:flex-none">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function coreValueForm() {
                return {
                    items: [],
                    addItem() {
                        this.items.push({
                            item_name: '',
                            item_description: '',
                            is_active: true
                        });
                    },
                    removeItem(index) {
                        if (confirm('Are you sure you want to remove this item?')) {
                            this.items.splice(index, 1);
                        }
                    }
                }
            }
        </script>
    @endpush
</x-dashboard.admin.base>
