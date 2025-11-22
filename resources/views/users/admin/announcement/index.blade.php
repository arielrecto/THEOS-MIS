<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Announcements')" :create_url="route('admin.general-announcements.create')" />

    <div class="mt-4">
        <x-tab.tab :tabs="['General Announcements', 'Classroom Announcements']" :active="request()->get('activeTab')">
            @if (request()->get('activeTab') == 0)
                {{-- Desktop / Tablet Table --}}
                <div class="overflow-x-auto hidden md:block">
                    <table class="table w-full table-zebra">
                        <thead>
                            <tr>
                                <th class="w-12">#</th>
                                <th>Title</th>
                                <th class="max-w-xs">Description</th>
                                <th>Posted By</th>
                                <th>Is Posted</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($announcements as $announcement)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td class="font-medium">{{ $announcement->title }}</td>
                                    <td class="max-w-xs truncate">{{ Str::limit($announcement->description, 100) }}</td>
                                    <td>{{ $announcement->postedBy->name }}</td>
                                    <td x-data="{ isPosted: @js($announcement->is_posted) }">
                                        <label class="flex items-center">
                                            <input type="checkbox"
                                                   @click="isPosted = ! isPosted; $refs.form.submit()"
                                                   class="toggle toggle-accent"
                                                   x-bind:checked="isPosted" />
                                        </label>

                                        <form action="{{ route('admin.general-announcements.toggle', $announcement->id) }}"
                                              method="POST"
                                              x-ref="form"
                                              class="hidden">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.general-announcements.edit', $announcement->id) }}"
                                               class="btn btn-sm btn-outline btn-info">
                                                {{ __('Edit') }}
                                            </a>

                                            <button type="button"
                                                    class="btn btn-sm btn-outline btn-error"
                                                    onclick="event.preventDefault(); document.getElementById('delete-announcement-form-{{ $announcement->id }}').submit();">
                                                {{ __('Delete') }}
                                            </button>

                                            <form id="delete-announcement-form-{{ $announcement->id }}"
                                                  action="{{ route('admin.general-announcements.destroy', $announcement->id) }}"
                                                  method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6">{{ __('No Announcements Found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Card List --}}
                <div class="space-y-4 md:hidden">
                    @forelse ($announcements as $announcement)
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <div class="flex items-start justify-between">
                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $announcement->title }}</h3>
                                    <p class="text-xs text-gray-500 mt-1 truncate">{{ Str::limit($announcement->description, 150) }}</p>
                                    <p class="text-xs text-gray-400 mt-2">Posted by: {{ $announcement->postedBy->name }}</p>
                                </div>

                                <div class="ml-3 flex flex-col items-end gap-2">
                                    <div x-data="{ isPosted: @js($announcement->is_posted) }" class="flex items-center">
                                        <form action="{{ route('admin.general-announcements.toggle', $announcement->id) }}" method="POST" x-ref="form_mobile_{{ $announcement->id }}">
                                            @csrf
                                            @method('PUT')
                                            <label class="flex items-center gap-2">
                                                <input type="checkbox"
                                                       @click="isPosted = ! isPosted; $refs.form_mobile_{{ $announcement->id }}.submit()"
                                                       class="toggle toggle-accent"
                                                       x-bind:checked="isPosted" />
                                            </label>
                                        </form>
                                    </div>

                                    <div class="flex flex-col sm:flex-row gap-2 w-full">
                                        <a href="{{ route('admin.general-announcements.edit', $announcement->id) }}"
                                           class="btn btn-xs btn-outline btn-info w-24">
                                            {{ __('Edit') }}
                                        </a>

                                        <form id="mobile-delete-form-{{ $announcement->id }}"
                                              action="{{ route('admin.general-announcements.destroy', $announcement->id) }}"
                                              method="POST"
                                              class="w-24">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="btn btn-xs btn-outline btn-error w-full"
                                                    onclick="if(confirm('Are you sure you want to delete this announcement?')){ this.form.submit(); }">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-sm p-6 text-center text-gray-500">
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
