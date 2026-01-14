<x-dashboard.admin.base>
    <div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-4xl">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.CMS.header-contents.index') }}" class="btn btn-ghost btn-sm">
                    <i class="fi fi-rr-arrow-left"></i>
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Header Content Details</h1>
            </div>
            <p class="text-sm text-gray-600 ml-12">View header content information</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Preview Banner -->
            <div class="bg-gradient-to-r from-primary to-accent p-8 sm:p-12 text-white">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">
                        {{ $headerContent->title }}
                    </h1>
                    @if ($headerContent->subtitle)
                        <p class="text-lg sm:text-xl mb-6 opacity-90">
                            {{ $headerContent->subtitle }}
                        </p>
                    @endif
                    @if ($headerContent->show_button && $headerContent->button_text)
                        <a href="{{ $headerContent->button_url }}" class="btn btn-lg btn-white">
                            {{ $headerContent->button_text }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Details -->
            <div class="p-6 space-y-6">
                <!-- Status Badge -->
                <div class="flex items-center gap-2">
                    @if ($headerContent->is_active)
                        <span class="badge badge-success badge-lg">Active</span>
                    @else
                        <span class="badge badge-ghost badge-lg">Inactive</span>
                    @endif
                </div>

                <!-- Information Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Title</label>
                        <p class="text-gray-900 break-words">{{ $headerContent->title }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Status</label>
                        <p class="text-gray-900">
                            {{ $headerContent->is_active ? 'Active' : 'Inactive' }}
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Subtitle</label>
                        <p class="text-gray-900 break-words">
                            {{ $headerContent->subtitle ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Show Button</label>
                        <p class="text-gray-900">
                            {{ $headerContent->show_button ? 'Yes' : 'No' }}
                        </p>
                    </div>

                    @if ($headerContent->show_button)
                        <div>
                            <label class="text-sm font-semibold text-gray-600 block mb-2">Button Text</label>
                            <p class="text-gray-900">{{ $headerContent->button_text ?? '-' }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm font-semibold text-gray-600 block mb-2">Button URL</label>
                            <p class="text-gray-900 break-all">
                                @if ($headerContent->button_url)
                                    <a href="{{ $headerContent->button_url }}" target="_blank"
                                        class="link link-primary">
                                        {{ $headerContent->button_url }}
                                    </a>
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    @endif

                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Created At</label>
                        <p class="text-gray-900">{{ $headerContent->created_at->format('F d, Y h:i A') }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-600 block mb-2">Last Updated</label>
                        <p class="text-gray-900">{{ $headerContent->updated_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t">
                    <a href="{{ route('admin.CMS.header-contents.edit', $headerContent) }}"
                        class="btn btn-primary flex-1 sm:flex-none">
                        <i class="fi fi-rr-edit"></i>
                        Edit Content
                    </a>
                    <form action="{{ route('admin.CMS.header-contents.toggle-active', $headerContent) }}"
                        method="POST" class="flex-1 sm:flex-none">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning w-full">
                            <i class="fi fi-rr-refresh"></i>
                            {{ $headerContent->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.CMS.header-contents.destroy', $headerContent) }}" method="POST"
                        class="flex-1 sm:flex-none"
                        onsubmit="return confirm('Are you sure you want to delete this header content?')">
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
