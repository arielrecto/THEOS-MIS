<x-dashboard.student.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Announcements')" />

    <div class="overflow-x-auto">
        <div class="flex space-x-2 mb-6">
            <a href="{{ route('student.announcements.index', ['type' => 'general']) }}"
                class="px-3 py-2 font-semibold rounded-lg {{ request()->type === 'general' || !request()->type ? 'bg-accent text-white' : 'bg-gray-200 text-gray-700' }}">
                {{ __('General') }}
            </a>
            <a href="{{ route('student.announcements.index', ['type' => 'classroom']) }}"
                class="px-3 py-2 font-semibold rounded-lg {{ request()->type === 'classroom' ? 'bg-accent text-white' : 'bg-gray-200 text-gray-700' }}">
                {{ __('Classroom') }}
            </a>
        </div>

        @if (request()->type === 'general' || !request()->type)
            <!-- Desktop table (md+) -->
            <div class="hidden md:block">
                <table class="table w-full table-zebra">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Posted By') }}</th>
                            <th>{{ __('Created At') }}</th>
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
                                <td>{{ $announcement->created_at->format('F j, Y') }}</td>
                                <td>
                                    <a href="{{ route('student.announcements.show', ['id' => $announcement->id, 'type' => 'general']) }}"
                                        class="btn btn-sm btn-outline btn-accent">
                                        <i class="fi fi-rr-eye mr-2"></i>
                                        {{ __('View') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('No Announcements Found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile cards -->
            <div class="md:hidden space-y-3">
                @forelse ($announcements as $announcement)
                    <div class="card bg-base-100 shadow-sm p-4">
                        <div class="flex justify-between items-start gap-3">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-sm">{{ $announcement->title }}</h3>
                                    <span
                                        class="text-xs text-gray-500">{{ $announcement->created_at->format('M j, Y') }}</span>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">{{ Str::limit($announcement->description, 120) }}
                                </p>
                                <div class="mt-3 text-xs text-gray-500">
                                    {{ __('Posted by') }}: {{ $announcement->postedBy->name }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <a href="{{ route('student.announcements.show', ['id' => $announcement->id, 'type' => 'general']) }}"
                                class="btn btn-xs btn-outline btn-accent">
                                <i class="fi fi-rr-eye mr-1"></i> {{ __('View') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        {{ __('No Announcements Found') }}
                    </div>
                @endforelse
            </div>
        @endif

        @if (request()->type === 'classroom')
            <!-- Desktop table (md+) -->
            <div class="hidden md:block">
                <table class="table w-full table-zebra">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Classroom') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($announcements as $announcement)
                            <tr>
                                <th>{{ $loop->index + 1 }}</th>
                                <td>{{ $announcement->title }}</td>
                                <td>{{ Str::limit($announcement->description, 50) }}</td>
                                <td>{{ $announcement->classroom->subject->name }}</td>
                                <td>{{ $announcement->created_at->format('F j, Y') }}</td>
                                <td class="space-x-2">
                                    <a href="{{ route('student.announcements.show', ['id' => $announcement->id, 'type' => 'classroom']) }}"
                                        class="btn btn-sm btn-outline btn-accent">
                                        <i class="fi fi-rr-eye mr-2"></i>
                                        {{ __('View') }}
                                    </a>
                                    @if ($announcement->file_dir)
                                        <a href="{{ asset($announcement->file_dir) }}" download
                                            class="btn btn-sm btn-ghost">
                                            <i class="fi fi-rr-download mr-2"></i>
                                            {{ __('Download') }}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('No Announcements Found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile cards -->
            <div class="md:hidden space-y-3">
                @forelse ($announcements as $announcement)
                    <div class="card bg-base-100 shadow-sm p-4">
                        <div class="flex justify-between items-start gap-3">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-sm">{{ $announcement->title }}</h3>
                                    <span
                                        class="text-xs text-gray-500">{{ $announcement->created_at->format('M j, Y') }}</span>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">{{ Str::limit($announcement->description, 120) }}
                                </p>
                                <div class="mt-3 text-xs text-gray-500">
                                    {{ __('Classroom') }}: {{ $announcement->classroom->subject->name }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <a href="{{ route('student.announcements.show', ['id' => $announcement->id, 'type' => 'classroom']) }}"
                                class="btn btn-xs btn-outline btn-accent">
                                <i class="fi fi-rr-eye mr-1"></i> {{ __('View') }}
                            </a>
                            @if ($announcement->file_dir)
                                <a href="{{ asset($announcement->file_dir) }}" download class="btn btn-xs btn-ghost">
                                    <i class="fi fi-rr-download mr-1"></i> {{ __('Download') }}
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        {{ __('No Announcements Found') }}
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</x-dashboard.student.base>
