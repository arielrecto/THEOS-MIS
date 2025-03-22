@php
    $links = [
        [
            'url' => 'teacher.dashboard',
            'name' => 'dashboard',
            'icon' => '<i class="fi fi-rr-dashboard"></i>',
        ],
        [
            'url' => 'teacher.classrooms.index',
            'name' => 'classrooms',
            'icon' => '<i class="fi fi-rr-users-alt"></i>',
        ],
        [
            'url' => 'teacher.announcements.index',
            'name' => 'announcements',
            'icon' => '<i class="fi fi-rr-bell"></i>',
        ],
        [
            'url' => 'teacher.student.index',
            'name' => 'students',
            'icon' => '<i class="fi fi-rr-student"></i>',
        ],
        [
            'url' => 'teacher.grades.index',
            'name' => 'grades',
            'icon' => '<i class="fi fi-rr-list-check"></i>',
        ],
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
