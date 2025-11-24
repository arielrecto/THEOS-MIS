<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Inbox')" />

    <div class="bg-base-100 shadow-xl">
        <div class="flex flex-col gap-2">
            @if ($inboxs->count() > 0)
                <!-- Table view for md and up -->
                <div class="overflow-x-auto hidden md:block">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>From</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inboxs as $message)
                                <tr class="{{ !$message->is_read ? 'bg-base-200 font-medium' : '' }}">
                                    <td>
                                        @if (!$message->is_read)
                                            <div class="badge badge-accent">Unread</div>
                                        @else
                                            <div class="badge badge-ghost">Read</div>
                                        @endif
                                    </td>
                                    <td>{{ $message->full_name }}</td>
                                    <td>
                                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $message->email }}"
                                            target="_blank" class="link link-hover text-accent">
                                            {{ $message->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <p class="truncate max-w-md">
                                            {{ Str::limit($message->message, 50) }}
                                        </p>
                                    </td>
                                    <td>
                                        <span class="text-sm text-gray-600" title="{{ $message->created_at }}">
                                            {{ $message->created_at->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.inbox.show', $message->id) }}"
                                                class="btn btn-sm btn-ghost text-accent">
                                                <i class="fi fi-rr-eye"></i>
                                            </a>
                                            <button onclick="delete_modal_{{ $message->id }}.showModal()"
                                                class="btn btn-sm btn-ghost text-error">
                                                <i class="fi fi-rr-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile card view for small screens -->
                <div class="md:hidden space-y-3">
                    @foreach ($inboxs as $message)
                        <div
                            class="card bg-base-100 shadow-sm p-4 {{ !$message->is_read ? 'ring-2 ring-accent' : '' }}">
                            <div class="flex justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        @if (!$message->is_read)
                                            <div class="badge badge-accent">Unread</div>
                                        @else
                                            <div class="badge badge-ghost">Read</div>
                                        @endif
                                        <div class="ml-1 font-medium">{{ $message->full_name }}</div>
                                    </div>
                                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $message->email }}"
                                        target="_blank" class="link link-hover text-accent text-sm">
                                        {{ $message->email }}
                                    </a>
                                    <p class="mt-2 text-sm text-gray-600">{{ Str::limit($message->message, 120) }}</p>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="text-xs text-gray-600"
                                        title="{{ $message->created_at }}">{{ $message->created_at->diffForHumans() }}</span>
                                    <div class="flex flex-col items-end gap-2">
                                        <a href="{{ route('admin.inbox.show', $message->id) }}"
                                            class="btn btn-xs btn-ghost text-accent">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                        <button onclick="delete_modal_{{ $message->id }}.showModal()"
                                            class="btn btn-xs btn-ghost text-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Delete dialogs (single set, used by both views) -->
                @foreach ($inboxs as $message)
                    <dialog id="delete_modal_{{ $message->id }}" class="modal">
                        <div class="modal-box">
                            <h3 class="font-bold text-lg text-error">Delete Message</h3>
                            <p class="py-4">Are you sure you want to delete this message? This action
                                cannot be undone.</p>
                            <div class="modal-action">
                                <form method="dialog">
                                    <button class="btn btn-ghost">Cancel</button>
                                </form>
                                <form action="{{ route('admin.inbox.destroy', $message->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error">Delete</button>
                                </form>
                            </div>
                        </div>
                        <form method="dialog" class="modal-backdrop">
                            <button>close</button>
                        </form>
                    </dialog>
                @endforeach

                <div class="mt-4">
                    {{ $inboxs->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <div class="flex justify-center mb-4">
                        <i class="fi fi-rr-inbox text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No messages yet</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        When you receive messages, they will appear here.
                    </p>
                </div>
            @endif
        </div>
    </div>


</x-dashboard.admin.base>
