<x-dashboard.teacher.base>
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <x-dashboard.page-title :title="_('Announcements')" />
            <div class="flex gap-2">

                @if (request()->query('type') === 'classroom')

                    @if (request()->has('classroom'))
                        <a href="{{ route('teacher.announcements.create', ['type' => 'classroom', 'classroom' => request('classroom')]) }}"
                            class="btn btn-accent">
                            <i class="fi fi-rr-plus mr-2"></i>
                            {{ __('Create Announcement') }}
                        </a>
                    @endif
                @else
                    <a href="{{ route('teacher.announcements.create', ['type' => 'general']) }}" class="btn btn-accent">
                        <i class="fi fi-rr-plus mr-2"></i>
                        {{ __('Create Announcement') }}
                    </a>
                @endif


            </div>
        </div>

        <!-- Announcement Type Tabs -->
        <div class="flex space-x-2 mb-6">
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
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">

                @foreach ($classrooms as $classroom)
                    <a href="{{ route('teacher.announcements.index', ['type' => 'classroom', 'classroom' => $classroom->id]) }}"
                        class="block p-2 rounded-lg {{ request('classroom') == $classroom->id ? 'bg-accent text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $classroom->name }}
                    </a>
                @endforeach

            </div>

        @endif

        <div class="overflow-x-auto">
            @if (request()->type === 'general' || !request()->type)
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
                                    <span class="badge badge-{{ $announcement->is_posted ? 'success' : 'warning' }}">
                                        {{ $announcement->is_posted ? 'Posted' : 'Draft' }}
                                    </span>
                                </td>
                                <td>{{ $announcement->created_at->format('F j, Y') }}</td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('teacher.announcements.show', ['announcement' => $announcement->id, 'type' => 'general']) }}"
                                            class="btn btn-sm btn-outline btn-accent">
                                            <i class="fi fi-rr-eye mr-2"></i>
                                            {{ __('View') }}
                                        </a>
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
            @endif

            @if (request()->type === 'classroom')
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
                                    <div class="flex gap-2">
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
