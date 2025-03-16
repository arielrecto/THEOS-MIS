<x-dashboard.student.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Announcements')" />



    <div class="overflow-x-auto">

        <div class="flex space-x-2">
            <a href="{{ route('student.announcements.index', ['type' => 'general']) }}"
                class="px-3 py-2 font-semibold rounded-lg {{ request()->type === 'general' || !request()->type ? 'bg-accent text-white' : 'bg-gray-200 text-gray-700' }}">{{ __('General') }}</a>
            <a href="{{ route('student.announcements.index', ['type' => 'classroom']) }}"
                class="px-3 py-2 font-semibold rounded-lg {{ request()->type === 'classroom' ? 'bg-accent text-white' : 'bg-gray-200 text-gray-700' }}">{{ __('Classroom') }}</a>
        </div>



        @if (request()->type === 'general' || !request()->type)
            <table class="table w-full table-zebra">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Posted By') }}</th>

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

                            <td>
                                <a href="{{ route('student.announcements.show', $announcement->id) }}"
                                    class="btn btn-sm btn-outline btn-accent">{{ __('View') }}</a>
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

        @if (request()->type === 'classroom')
            <table class="table w-full table-zebra">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Classroom') }}</th>
                        <th>{{ __('File') }}</th>
                        <th>{{ __('Created At') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($announcements as $announcement)
                        <tr>
                            <th>{{ $loop->index + 1 }}</th>
                            <td>{{ $announcement->title }}</td>
                            <td>{{ Str::limit($announcement->description, 50) }}</td>
                            <td>{{ $announcement->classroom->name }}</td>
                            <td>
                                @if ($announcement->file_dir)
                                    <a href="{{ $announcement->file_dir }}" target="_blank" class="btn btn-sm btn-outline btn-accent">{{ __('View File') }}</a>
                                @else
                                    <span class="text-sm text-gray-600">{{ __('No File Attached') }}</span>
                                @endif
                            </td>
                            <td>{{ $announcement->created_at->format('F j, Y') }}</td>
                            <td>
                                <a href="{{ route('student.announcements.show', $announcement->id) }}"
                                    class="btn btn-sm btn-outline btn-accent">{{ __('View') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">{{ __('No Announcements Found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>

</x-dashboard.student.base>
