@php
    $links = [
        [
            'url' => 'employee.dashboard',
            'name' => 'dashboard',
            'icon' => '<i class="fi fi-rr-dashboard"></i>',
            'is_active' => true,
        ],
        // [
        //     'url' => 'employee.attendance.index',
        //     'name' => 'attendance',
        //     'icon' => '<i class="fi fi-rr-time-check"></i>',
        // ],
        [
            'url' => 'employee.leaves.index',
            'name' => 'leaves',
            'icon' => '<i class="fi fi-rr-calendar"></i>',
            'is_active' => true,
        ],
        // [
        //     'url' => '#',
        //     'name' => 'reports',
        //     'icon' => '<i class="fi fi-rr-chart-histogram"></i>',
        // ],
    ];

    $user = Auth::user();

    $profile = $user->profile !== null ? route('teacher.profile.show', ['profile' => $user->profile->id]) : null;
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
