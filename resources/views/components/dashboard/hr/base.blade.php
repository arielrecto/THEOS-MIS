@php
    $links = [
        [
            'url' => 'hr.dashboard',
            'name' => 'dashboard',
            'icon' => '<i class="fi fi-rr-dashboard"></i>',
        ],
        [
            'url' => 'hr.employees.index',
            'name' => 'employees',
            'icon' => '<i class="fi fi-rr-users"></i>',
        ],
        [
            'url' => 'hr.departments.index',
            'name' => 'departments',
            'icon' => '<i class="fi fi-rr-users"></i>',
        ],
        [
            'url' => 'hr.positions.index',
            'name' => 'positions',
            'icon' => '<i class="fi fi-rr-briefcase"></i>',
        ],
        [
            'url' => '#',
            'name' => 'leaves',
            'icon' => '<i class="fi fi-rr-calendar"></i>',
        ],
        [
            'url' => '#',
            'name' => 'attendance',
            'icon' => '<i class="fi fi-rr-time-check"></i>',
        ],
        [
            'url' => '#',
            'name' => 'reports',
            'icon' => '<i class="fi fi-rr-chart-histogram"></i>',
        ],
    ];

    $user = Auth::user();

    $profile = $user->profile !== null ? '#' : null;
@endphp


<x-app-layout>
    <div class="flex justify-center w-full h-full bg-base-100">
        <div class="flex overflow-hidden w-full min-h-screen shadow-lg 4xl:rounded-lg 4xl:w-5/6">
            <x-dashboard.sidebar :links="$links" class="shadow-md bg-secondary text-primary" />
            <div class="flex flex-col gap-4 p-6 w-full h-full">
                <x-dashboard.navbar :profile_url="$profile" class="rounded-lg shadow-md bg-primary text-neutral" />

                <div class="p-6 bg-white rounded-lg shadow-md main">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
