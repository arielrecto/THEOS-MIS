<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Inbox')" back_url="{{ route('admin.inbox.index') }}" />

    <div class="max-w-3xl mx-auto w-full p-3 sm:p-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="px-4 py-3 sm:px-6 sm:py-4 border-b">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h1 class="text-lg sm:text-2xl font-semibold text-gray-800 truncate">
                            {{ $inbox->full_name }}
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                            {{ optional($inbox->created_at)->format('F j, Y g:i A') }}
                        </p>
                    </div>

                    <div class="hidden sm:flex items-center gap-2">
                        <a href="{{ route('admin.inbox.index') }}" class="btn btn-ghost btn-sm">Back</a>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="p-4 sm:p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-gray-500">Email</dt>
                        <dd class="text-sm font-medium break-words">{{ $inbox->email }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs text-gray-500">Subject</dt>
                        <dd class="text-sm font-medium break-words">{{ $inbox->subject ?? '—' }}</dd>
                    </div>
                </dl>

                <div class="mt-4">
                    <h3 class="text-sm text-gray-600 mb-2">Message</h3>
                    <div class="bg-gray-50 rounded p-3 max-h-72 overflow-auto text-sm text-gray-700 whitespace-pre-wrap break-words">
                        {{ $inbox->message }}
                    </div>
                </div>
            </div>

            <!-- Footer actions (mobile visible) -->
            <div class="px-4 py-3 sm:px-6 sm:py-4 border-t flex items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.inbox.index') }}" class="btn btn-ghost btn-sm sm:hidden">Back</a>
                </div>

                <div class="text-xs text-gray-400">
                    <!-- keep for metadata / actions later -->
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
