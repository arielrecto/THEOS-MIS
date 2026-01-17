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
            'url' => 'admin.tuition-fee.index',
            'name' => 'Tuition Fee Brackets',
            'icon' => '<i class="fi fi-rr-wallet"></i>',
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
    <div class="min-h-screen bg-base-100">
        <div class="mx-auto w-full 4xl:w-5/6">
            <div class="flex h-screen overflow-hidden">
                <!-- Sidebar (desktop) -->
                <x-dashboard.sidebar :links="$links" class="shadow-md bg-secondary text-primary" />

                <!-- Main content area -->
                <div class="flex-1 flex flex-col">
                    <!-- Top navbar -->
                    <header class="w-full z-20">
                        <x-dashboard.navbar class="rounded-lg shadow-md bg-primary text-neutral" />
                    </header>

                    <!-- Page content: add bottom padding to avoid mobile bottom nav overlap -->
                    <main class="flex-1 overflow-auto p-4 md:p-6">
                        <div class="p-2 md:p-6 bg-white rounded-lg shadow-md main pb-28 md:pb-6">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
