@php
    $links = [
        [
            'url' => 'admin.dashboard',
            'name' => 'dashboard',
            'icon' => '<i class="fi fi-rr-dashboard"></i>',
        ],
        [
            'url' => 'admin.academic-year.index',
            'name' => 'Academic Year',
            'icon' => '<i class="fi fi-rr-calendar"></i>',
        ],
        [
            'url' => 'admin.general-announcements.index',
            'name' => 'Announcements',
            'icon' => '<i class="fi fi-rr-bell"></i>',
        ],
        [
            'url' => 'admin.users.index',
            'name' => 'users',
            'icon' => '<i class="fi fi-rr-users-alt"></i>',
        ],
        [
            'url' => 'admin.strands.index',
            'name' => 'strands',
            'icon' => '<i class="fi fi-rr-e-learning"></i>',
        ],
        [
            'url' => 'admin.subjects.index',
            'name' => 'subjects',
            'icon' => '<i class="fi fi-rr-books"></i>',
        ],
        [
            'url' => 'admin.CMS.index',
            'name' => 'CMS',
            'icon' => '<i class="fi fi-rr-browser"></i>',
        ]
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
