@php

$user = Auth::user();

$isEnrolled = $user->studentProfile !== null && $user->studentProfile->academicRecords()->exists();

    $links = [
        [
            'url' => 'student.dashboard',
            'name' => 'dashboard',
            'icon' => '<i class="fi fi-rr-dashboard"></i>',
            'is_active' => $isEnrolled,
        ],
        [
            'url' => 'student.announcements.index',
            'name' => 'announcements',
            'icon' => '<i class="fi fi-rr-bell"></i>',
            'is_active' => $isEnrolled,
        ],
        [
            'url' => 'student.classrooms.index',
            'name' => 'classrooms',
            'icon' => '<i class="fi fi-rr-users-alt"></i>',
            'is_active' => $isEnrolled,
        ],
        [
            'url' => 'student.tasks.index',
            'name' => 'tasks',
            'icon' => '<i class="fi fi-rr-list"></i>',
            'is_active' => $isEnrolled,
        ],
         [
            'url' => 'student.enrollment.index',
            'name' => 'requirements',
            'icon' => '<i class="fi fi-rr-list"></i>',
            'is_active' => $isEnrolled || !$user->studentProfile,
        ],
        [
            'url' => 'student.payments.index',
            'name' => 'payments',
            'icon' => '<i class="fi fi-rr-credit-card"></i>',
            'is_active' => $isEnrolled || !$user->studentProfile,
        ],
        // [
        //     'url' => 'student.attendances.index',
        //     'name' => 'attendance',
        //     'icon' => '<i class="fi fi-rr-calendar"></i>',
        // ],
        [
            'url' => 'student.settings.index',
            'name' => 'settings',
            'icon' => '<i class="fi fi-rr-settings"></i>',
            'is_active' => $isEnrolled,
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
