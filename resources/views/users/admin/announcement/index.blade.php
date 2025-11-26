<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Announcements')" :create_url="route('admin.general-announcements.create')" />

    <div class="mt-4">
        <x-tab.tab :tabs="['General Announcements', 'Classroom Announcements']" :active="request()->get('activeTab')">
            @if (request()->get('activeTab') == 0)
                {{-- Desktop / Tablet Table --}}
                <div class="overflow-x-auto hidden md:block bg-white rounded-lg shadow-sm border">
                    <table class="table w-full table-fixed">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="w-12 text-left">#</th>
                                <th class="w-48 text-left">Title</th>
                                <th class="max-w-lg text-left">Description</th>
                                <th class="w-40 text-left">Posted By</th>
                                <th class="w-28 text-center">Is Posted</th>
                                <th class="w-40 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($announcements as $announcement)
                                <tr class="hover:bg-gray-50">
                                    <th class="align-top">{{ $loop->iteration }}</th>

                                    <td class="align-top">
                                        <div class="font-medium text-sm text-gray-800 truncate">
                                            {{ $announcement->title }}</div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $announcement->created_at->format('M d, Y') }}</div>
                                    </td>

                                    <td class="align-top">
                                        <div class="text-sm text-gray-600 max-w-lg truncate">
                                            {{ Str::limit($announcement->description, 200) }}</div>
                                    </td>

                                    <td class="align-top text-sm text-gray-700">
                                        {{ $announcement->postedBy->name }}
                                    </td>

                                    <td class="align-top text-center">
                                        <form
                                            action="{{ route('admin.general-announcements.toggle', $announcement->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="is_posted" value="1"
                                                    class="toggle toggle-accent"
                                                    {{ $announcement->is_posted ? 'checked' : '' }}
                                                    onchange="this.form.submit()">
                                            </label>
                                        </form>
                                    </td>

                                    <td class="align-top text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('admin.general-announcements.edit', $announcement->id) }}"
                                                class="btn btn-sm btn-outline btn-info">
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.general-announcements.destroy', $announcement->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this announcement?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline btn-error">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-gray-500">
                                        {{ __('No Announcements Found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card List --}}
                <div class="space-y-4 md:hidden">
                    @forelse ($announcements as $announcement)
                        <div class="bg-white rounded-lg shadow-sm p-4 border">
                            <div class="flex items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h3 class="text-sm font-semibold text-gray-800 truncate">
                                                {{ $announcement->title }}</h3>
                                            <p class="text-xs text-gray-500 mt-1 truncate">
                                                {{ Str::limit($announcement->description, 160) }}</p>
                                            <p class="text-xs text-gray-400 mt-2">Posted by:
                                                {{ $announcement->postedBy->name }}</p>
                                        </div>

                                        <div class="flex-shrink-0 text-right">
                                            <div class="text-xs text-gray-500">
                                                {{ $announcement->created_at->format('M d, Y') }}</div>

                                            <div class="mt-2">
                                                <form
                                                    action="{{ route('admin.general-announcements.toggle', $announcement->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <label class="inline-flex items-center gap-2">
                                                        <input type="checkbox" class="toggle toggle-accent"
                                                            {{ $announcement->is_posted ? 'checked' : '' }}
                                                            onchange="this.form.submit()">
                                                        <span class="text-xs text-gray-600">Posted</span>
                                                    </label>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 flex gap-2">
                                        <a href="{{ route('admin.general-announcements.edit', $announcement->id) }}"
                                            class="btn btn-xs btn-info flex-1">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.general-announcements.destroy', $announcement->id) }}"
                                            method="POST" class="flex-1"
                                            onsubmit="return confirm('Are you sure you want to delete this announcement?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-error w-full">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-sm p-6 text-center text-gray-500 border">
                            <i class="fi fi-rr-megaphone text-3xl mb-2"></i>
                            <p>{{ __('No Announcements Found') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $announcements->links() }}
                </div>
            @endif
        </x-tab.tab>
    </div>
</x-dashboard.admin.base>
