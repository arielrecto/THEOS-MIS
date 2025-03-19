@props(['announcements' => []])

<x-slot name="stream">
    <div class="grid grid-cols-1 gap-6">
        @if (count($announcements) > 0)
            @foreach ($announcements as $announcement)
                <div class="shadow-xl card bg-base-100">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="avatar">
                                    <div class="w-10 rounded-full">
                                        <img src="{{ $announcement->classroom->teacher->profile->image ?? '' }}"
                                            alt="Teacher Profile" />
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-medium">{{ $announcement->classroom->teacher->name }}</h3>
                                    <p class="text-xs opacity-50">{{ $announcement->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn btn-ghost btn-circle btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </label>
                                <ul tabindex="0"
                                    class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li><a>Edit</a></li>
                                    <li><a>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <h2 class="card-title">{{ $announcement->title }}</h2>
                        <p>{{ $announcement->description }}</p>
                        @if ($announcement->file_dir)
                            <div class="mt-4 p-3 bg-base-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm">Attachment</span>
                                    </div>
                                    <a href="{{ asset($announcement->file_dir) }}"
                                        class="btn btn-ghost btn-sm">Download</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-10">
                <h3 class="text-lg font-medium text-gray-500">No announcements yet</h3>
            </div>
        @endif
    </div>
</x-slot>
