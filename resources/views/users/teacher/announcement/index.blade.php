<x-dashboard.teacher.base>
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <x-dashboard.page-title :title="_('Announcements')" />
            <div class="flex gap-2 items-center">
                @if (request()->query('type') === 'classroom')
                    @if (request()->has('classroom'))
                        <a href="{{ route('teacher.announcements.create', ['type' => 'classroom', 'classroom' => request('classroom')]) }}"
                            class="btn btn-accent">
                            <i class="fi fi-rr-plus mr-2"></i>
                            {{ __('Create Announcement') }}
                        </a>
                    @endif
                @endif
            </div>
        </div>

        <!-- Announcement Type Tabs -->
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('teacher.announcements.index', ['type' => 'general', 'classroom_id' => request('classroom')]) }}"
                class="px-3 py-2 font-semibold rounded-lg {{ request()->type === 'general' || !request()->type ? 'bg-accent text-white' : 'bg-gray-200 text-gray-700' }}">
                {{ __('General') }}
            </a>
            <a href="{{ route('teacher.announcements.index', ['type' => 'classroom', 'classroom_id' => request('classroom')]) }}"
                class="px-3 py-2 font-semibold rounded-lg {{ request()->type === 'classroom' ? 'bg-accent text-white' : 'bg-gray-200 text-gray-700' }}">
                {{ __('Classroom') }}
            </a>
        </div>

        @if (request()->type === 'classroom')
            <h1 class="text-lg font-semibold text-accent mb-4">
                Select Classroom First
            </h1>
            <div class="mb-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach ($classrooms as $classroom)
                    <a href="{{ route('teacher.announcements.index', ['type' => 'classroom', 'classroom' => $classroom->id]) }}"
                        class="block p-2 text-center rounded-lg text-sm {{ request('classroom') == $classroom->id ? 'bg-accent text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $classroom->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="overflow-x-auto">
            {{-- General announcements: desktop table + mobile cards --}}
            @if (request()->type === 'general' || !request()->type)
                <div class="hidden md:block">
                    <table class="table w-full table-zebra">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Attachments') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($announcements as $announcement)
                                <tr>
                                    <th>{{ $loop->index + 1 }}</th>
                                    <td>{{ $announcement->title }}</td>
                                    <td>{{ Str::limit($announcement->description, 50) }}</td>
                                    <td>
                                        <span class="badge badge-ghost">
                                            {{ $announcement->attachments->count() }} files
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $announcement->is_posted ? 'success' : 'warning' }}">
                                            {{ $announcement->is_posted ? 'Posted' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td>{{ $announcement->created_at->format('F j, Y') }}</td>
                                    <td>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('teacher.announcements.show', ['announcement' => $announcement->id, 'type' => 'general']) }}"
                                                class="btn btn-sm btn-outline btn-accent">
                                                <i class="fi fi-rr-eye mr-2"></i>
                                                {{ __('View') }}
                                            </a>

                                            @if ($announcement->posted_by === auth()->id())
                                                <a href="{{ route('teacher.announcements.edit', ['announcement' => $announcement->id, 'type' => 'general']) }}"
                                                    class="btn btn-sm btn-outline btn-warning">
                                                    <i class="fi fi-rr-edit mr-2"></i>
                                                    {{ __('Edit') }}
                                                </a>
                                                <button type="button"
                                                    onclick="confirmDelete('{{ $announcement->id }}', 'general')"
                                                    class="btn btn-sm btn-outline btn-error">
                                                    <i class="fi fi-rr-trash mr-2"></i>
                                                    {{ __('Delete') }}
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">{{ __('No Announcements Found') }}</td>
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
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h3 class="font-semibold text-sm">{{ $announcement->title }}</h3>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $announcement->created_at->format('M j, Y') }}</div>
                                        </div>
                                        <div class="text-right text-xs">
                                            <span
                                                class="badge badge-{{ $announcement->is_posted ? 'success' : 'warning' }}">
                                                {{ $announcement->is_posted ? 'Posted' : 'Draft' }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">
                                        {{ Str::limit($announcement->description, 120) }}</p>
                                    <div class="mt-3 text-xs text-gray-500">
                                        {{ __('Attachments') }}: {{ $announcement->attachments->count() }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <a href="{{ route('teacher.announcements.show', ['announcement' => $announcement->id, 'type' => 'general']) }}"
                                    class="btn btn-xs btn-outline btn-accent">
                                    <i class="fi fi-rr-eye mr-1"></i> {{ __('View') }}
                                </a>
                                @if ($announcement->posted_by === auth()->id())
                                    <a href="{{ route('teacher.announcements.edit', ['announcement' => $announcement->id, 'type' => 'general']) }}"
                                        class="btn btn-xs btn-outline btn-warning">
                                        <i class="fi fi-rr-edit mr-1"></i> {{ __('Edit') }}
                                    </a>
                                    <button type="button"
                                        onclick="confirmDelete('{{ $announcement->id }}', 'general')"
                                        class="btn btn-xs btn-outline btn-error">
                                        <i class="fi fi-rr-trash mr-1"></i> {{ __('Delete') }}
                                    </button>
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

            {{-- Classroom announcements: desktop table + mobile cards --}}
            @if (request()->type === 'classroom')
                <div class="hidden md:block">
                    <table class="table w-full table-zebra">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Classroom') }}</th>
                                <th>{{ __('Attachment') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($announcements as $announcement)
                                <tr>
                                    <th>{{ $loop->index + 1 }}</th>
                                    <td>{{ $announcement->title }}</td>
                                    <td>{{ Str::limit($announcement->description, 50) }}</td>
                                    <td>{{ $announcement->classroom->subject->name }}</td>
                                    <td>
                                        @if ($announcement->file_dir)
                                            <span class="badge badge-accent">Yes</span>
                                        @else
                                            <span class="badge badge-ghost">No</span>
                                        @endif
                                    </td>
                                    <td>{{ $announcement->created_at->format('F j, Y') }}</td>
                                    <td>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('teacher.announcements.show', ['announcement' => $announcement->id, 'type' => 'classroom']) }}"
                                                class="btn btn-sm btn-outline btn-accent">
                                                <i class="fi fi-rr-eye mr-2"></i>
                                                {{ __('View') }}
                                            </a>
                                            <a href="{{ route('teacher.announcements.edit', ['announcement' => $announcement->id, 'type' => 'classroom']) }}"
                                                class="btn btn-sm btn-outline btn-warning">
                                                <i class="fi fi-rr-edit mr-2"></i>
                                                {{ __('Edit') }}
                                            </a>
                                            <button type="button"
                                                onclick="confirmDelete('{{ $announcement->id }}', 'classroom')"
                                                class="btn btn-sm btn-outline btn-error">
                                                <i class="fi fi-rr-trash mr-2"></i>
                                                {{ __('Delete') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">{{ __('No Announcements Found') }}</td>
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
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="font-semibold text-sm">{{ $announcement->title }}</h3>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $announcement->created_at->format('M j, Y') }}</div>
                                        </div>
                                        <div class="text-right text-xs">
                                            <div class="text-xs text-gray-500">
                                                {{ $announcement->classroom->subject->name }}</div>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">
                                        {{ Str::limit($announcement->description, 120) }}</p>
                                    <div class="mt-3 text-xs text-gray-500">
                                        {{ __('Attachment') }}: @if ($announcement->file_dir)
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <a href="{{ route('teacher.announcements.show', ['announcement' => $announcement->id, 'type' => 'classroom']) }}"
                                    class="btn btn-xs btn-outline btn-accent">
                                    <i class="fi fi-rr-eye mr-1"></i> {{ __('View') }}
                                </a>
                                <a href="{{ route('teacher.announcements.edit', ['announcement' => $announcement->id, 'type' => 'classroom']) }}"
                                    class="btn btn-xs btn-outline btn-warning">
                                    <i class="fi fi-rr-edit mr-1"></i> {{ __('Edit') }}
                                </a>
                                <button type="button" onclick="confirmDelete('{{ $announcement->id }}', 'classroom')"
                                    class="btn btn-xs btn-outline btn-error">
                                    <i class="fi fi-rr-trash mr-1"></i> {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            {{ __('No Announcements Found') }}
                        </div>
                    @endforelse
                </div>
            @endif

            <!-- Pagination -->
            <div class="mt-4">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <form id="deleteForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
        <script>
            function confirmDelete(id, type) {
                if (confirm('Are you sure you want to delete this announcement?')) {
                    const form = document.getElementById('deleteForm');
                    form.action = `{{ route('teacher.announcements.destroy', '') }}/${id}?type=${type}`;
                    form.submit();
                }
            }
        </script>
    @endpush
</x-dashboard.teacher.base>
