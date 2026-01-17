{{-- filepath: e:\Projects\Theos MIS\resources\views\users\admin\cms\academic-program-label\index.blade.php --}}
<x-dashboard.admin.base>
    <div class="container mx-auto px-4 sm:px-6 py-4 sm:py-8">
        <x-dashboard.page-title :title="__('Academic Program Labels')">
            <x-slot name="other">
                <a href="{{ route('admin.CMS.academic-program-label.create') }}"
                   class="btn btn-accent btn-sm gap-2 w-full sm:w-auto justify-center">
                    <i class="fi fi-rr-plus hidden md:block"></i>
                    <span>Add New Label</span>
                </a>
            </x-slot>
        </x-dashboard.page-title>

        <x-notification-message />

        <!-- Mobile Cards (visible on mobile only) -->
        <div class="mt-6 space-y-3 md:hidden">
            @forelse($labels as $label)
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-gray-900 break-words">{{ $label->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1 break-words">{{ $label->subtitle }}</p>
                        </div>
                        <span class="flex-shrink-0 text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">
                            #{{ $loop->iteration }}
                        </span>
                    </div>

                    <div class="flex gap-2 pt-3 border-t">
                        <a href="{{ route('admin.CMS.academic-program-label.edit', $label->id) }}"
                           class="btn btn-ghost btn-sm flex-1 gap-2 justify-center">
                            <i class="fi fi-rr-edit"></i>
                            <span>Edit</span>
                        </a>
                        <form action="{{ route('admin.CMS.academic-program-label.destroy', $label->id) }}"
                              method="POST"
                              class="flex-1"
                              onsubmit="return confirm('Are you sure you want to delete this label?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-ghost btn-sm w-full gap-2 text-error justify-center">
                                <i class="fi fi-rr-trash"></i>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <i class="fi fi-rr-inbox text-4xl text-gray-400 mb-3"></i>
                    <p class="text-gray-500 mb-4">No labels found.</p>
                    <a href="{{ route('admin.CMS.academic-program-label.create') }}"
                       class="btn btn-accent btn-sm gap-2 w-full sm:w-auto justify-center">
                        <i class="fi fi-rr-plus"></i>
                        Add First Label
                    </a>
                </div>
            @endforelse

            <!-- Mobile Pagination -->
            @if ($labels->hasPages())
                <div class="pt-4">
                    {{ $labels->links() }}
                </div>
            @endif
        </div>

        <!-- Desktop Table (hidden on mobile) -->
        <div class="mt-6 bg-white rounded-lg shadow-lg hidden md:block">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th class="w-16">#</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th class="w-32 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($labels as $label)
                            <tr class="hover">
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-medium">{{ $label->title }}</td>
                                <td class="text-gray-600">{{ $label->subtitle }}</td>
                                <td>
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('admin.CMS.academic-program-label.edit', $label->id) }}"
                                            class="btn btn-ghost btn-xs">
                                            <i class="fi fi-rr-edit"></i>
                                        </a>
                                        <form
                                            action="{{ route('admin.CMS.academic-program-label.destroy', $label->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this label?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-ghost btn-xs text-error">
                                                <i class="fi fi-rr-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-500">
                                    <i class="fi fi-rr-inbox text-4xl mb-2"></i>
                                    <p>No labels found.</p>
                                    <a href="{{ route('admin.CMS.academic-program-label.create') }}"
                                        class="btn btn-accent btn-sm mt-4">
                                        <i class="fi fi-rr-plus"></i>
                                        Add First Label
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Desktop Pagination -->
            @if ($labels->hasPages())
                <div class="p-4 border-t">
                    {{ $labels->links() }}
                </div>
            @endif
        </div>
    </div>
</x-dashboard.admin.base>
