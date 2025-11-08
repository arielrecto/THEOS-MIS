@php
    $links = [
        [
            'url' => 'admin.dashboard',
            'name' => 'dashboard',
            'icon' => '<i class="fi fi-rr-dashboard"></i>',
            'is_active' => true,
        ],
        [
            'url' => 'admin.academic-year.index',
            'name' => 'Academic Year',
            'icon' => '<i class="fi fi-rr-calendar"></i>',
            'is_active' => true,
        ],
        [
            'url' => 'admin.general-announcements.index',
            'name' => 'Announcements',
            'icon' => '<i class="fi fi-rr-bell"></i>',
            'is_active' => true,
        ],
        [
            'url' => 'admin.users.index',
            'name' => 'users',
            'icon' => '<i class="fi fi-rr-users-alt"></i>',
            'is_active' => true,
        ],
        [
            'url' => 'admin.strands.index',
            'name' => 'Grade Level',
            'icon' => '<i class="fi fi-rr-e-learning"></i>',
            'is_active' => true,
        ],
        [
            'url' => 'admin.subjects.index',
            'name' => 'subjects',
            'icon' => '<i class="fi fi-rr-books"></i>',
            'is_active' => true,
        ],
        [
            'url' => 'admin.CMS.index',
            'name' => 'CMS',
            'icon' => '<i class="fi fi-rr-browser"></i>',
            'is_active' => true,
        ],
        [
            'url' => 'admin.inbox.index',
            'name' => 'Inbox',
            'icon' => '<i class="fi fi-rr-inbox"></i>',
            'is_active' => true,
        ],
        [
            'url' => 'admin.payment-accounts.index',
            'name' => 'Payment Accounts',
            'icon' => '<i class="fi fi-rr-credit-card"></i>',
            'is_active' => true,
        ],
        [
            'url' => 'admin.payments.index',
            'name' => 'Payments',
            'icon' => '<i class="fi fi-rr-money-check"></i>',
            'is_active' => true,
        ],
    ];
@endphp

<x-app-layout>
    <div class="flex justify-center w-full h-full bg-base-100">
        <div class="flex overflow-hidden w-full min-h-screen shadow-lg 4xl:rounded-lg 4xl:w-5/6">
            <x-dashboard.sidebar :links="$links" class="shadow-md bg-secondary text-primary" />
            <div class="flex flex-col gap-4 p-6 w-full h-full">
                <x-dashboard.navbar class="rounded-lg shadow-md bg-primary text-neutral" />

                <div class="p-6 bg-white rounded-lg shadow-md main">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
