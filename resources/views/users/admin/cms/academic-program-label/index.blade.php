<x-dashboard.admin.base>
    <div class="container px-4 py-8 mx-auto">
        <x-dashboard.page-title :title="__('Academic Program Labels')">
            <x-slot name="other">
                <a href="{{ route('admin.CMS.academic-program-label.create') }}" class="btn btn-accent btn-sm gap-2">
                    <i class="fi fi-rr-plus"></i>
                    <span>Add New Label</span>
                </a>
            </x-slot>
        </x-dashboard.page-title>

        <x-notification-message />

        <!-- Labels Table -->
        <div class="mt-6 bg-white rounded-lg shadow-lg">
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

            <!-- Pagination -->
            @if ($labels->hasPages())
                <div class="p-4 border-t">
                    {{ $labels->links() }}
                </div>
            @endif
        </div>
    </div>
</x-dashboard.admin.base>
