<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Announcements')" :create_url="route('admin.general-announcements.create')" />



    <div class="overflow-x-auto">


        <x-tab.tab :tabs="['General Announcements', 'Classroom Announcements']" :active="request()->get('activeTab')">
            @if (request()->get('activeTab') == 0)

                <table class="table w-full table-zebra">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Posted By') }}</th>
                            <th>{{ __('Is Posted') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($announcements as $announcement)
                            <tr>
                                <th>{{ $loop->index + 1 }}</th>
                                <td>{{ $announcement->title }}</td>
                                <td>{{ Str::limit($announcement->description, 50) }}</td>
                                <td>{{ $announcement->postedBy->name }}</td>
                                <td x-data="{ isPosted: @js($announcement->is_posted) }">
                                    <label class="flex gap-2">
                                        <input type="checkbox" @click="isPosted = ! isPosted; $refs.form.submit()"
                                            class="toggle toggle-accent" x-bind:checked="isPosted" />
                                    </label>
                                    <form action="{{ route('admin.general-announcements.toggle', $announcement->id) }}"
                                        method="POST" x-ref="form">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.general-announcements.edit', $announcement->id) }}"
                                        class="btn btn-sm btn-outline btn-info">{{ __('Edit') }}</a>
                                    <a href="{{ route('admin.general-announcements.destroy', $announcement->id) }}"
                                        class="btn btn-sm btn-outline btn-error"
                                        onclick="event.preventDefault(); document.getElementById('delete-announcement-form-{{ $announcement->id }}').submit();">{{ __('Delete') }}</a>
                                    <form id="delete-announcement-form-{{ $announcement->id }}"
                                        action="{{ route('admin.general-announcements.destroy', $announcement->id) }}"
                                        method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('No Announcements Found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </x-tab.tab>

    </div>

</x-dashboard.admin.base>
