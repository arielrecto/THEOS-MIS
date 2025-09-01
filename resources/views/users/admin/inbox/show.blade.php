<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :title="_('Inbox')" back_url="{{route('admin.inbox.index')}}" />



    <div class="flex flex-col p-2 rounded-lg shadow-lg">
        <h1 class="flex items-center gap-2 font-bold text-3xl">
            Full Name: {{ $inbox->full_name }}
        </h1>
        <h1 class="flex items-center gap-2 font-bold">
            Email: {{ $inbox->email }}
        </h1>

        <p class="min-h-60 bg-gray-50 rounded-lg  p-2">
            Message: {{ $inbox->message }}
        </p>
    </div>
</x-dashboard.admin.base>
