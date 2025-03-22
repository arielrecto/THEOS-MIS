@php
    $links = [
        [
            'url' => 'student.dashboard',
            'name' => 'dashboard',
            'icon' => '<i class="fi fi-rr-dashboard"></i>',
        ],
        [
            'url' => 'student.announcements.index',
            'name' => 'announcements',
            'icon' => '<i class="fi fi-rr-bell"></i>',
        ],
        [
            'url' => 'student.classrooms.index',
            'name' => 'classrooms',
            'icon' => '<i class="fi fi-rr-users-alt"></i>',
        ],
        [
            'url' => 'student.tasks.index',
            'name' => 'tasks',
            'icon' => '<i class="fi fi-rr-list"></i>',
        ],
        [
            'url' => '#',
            'name' => 'attendance',
            'icon' => '<i class="fi fi-rr-calendar"></i>',
        ],
        [
            'url' => 'student.settings.index',
            'name' => 'settings',
            'icon' => '<i class="fi fi-rr-settings"></i>',
        ],
    ];

    $user = Auth::user();

    $profile =  $user->profile !== null ? route('student.profile.show', ['profile' => $user->profile->id]) : null;
@endphp


<x-app-layout>
    <div class="flex justify-center w-full h-full bg-base-100">
        <div class="flex overflow-hidden w-full min-h-screen shadow-lg 4xl:rounded-lg 4xl:w-5/6">
            <x-dashboard.sidebar :links="$links" class="shadow-md bg-secondary text-primary"/>
            <div class="flex flex-col gap-4 p-6 w-full h-full">
                <x-dashboard.navbar :profile_url="$profile" class="rounded-lg shadow-md bg-primary text-neutral"/>

                <div class="p-6 bg-white rounded-lg shadow-md main">
                    {{$slot}}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
