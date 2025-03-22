@props([
    'classroom' => null,
    'url' => null,
])


<x-dashboard.student.base>
    <x-notification-message />
    <div class="flex flex-col gap-2">
        <div class="flex items-center w-full rounded-lg">
            <h1 class="text-2xl font-bold tracking-wider capitalize text-accent">
                {{ $classroom->name ?? 'Classroom' }} - {{ $classroom->strand->acronym ?? 'Strand' }}
            </h1>
            <p class="text-sm tracking-wide capitalize text-primary">
                {{ $classroom->academicYear->name ?? 'Academic Year' }}
            </p>
        </div>


        <div class="flex items-center w-full rounded-lg border">
            <a href="{{ $url ?? '#' }}?tab=stream"
                class="flex gap-2 items-center px-4 py-3 rounded-lg duration-700 hover:bg-primary hover:text-neutral">
                <span
                    class="text-lg font-bold tracking-wider capitalize text-accent {{ request()->get('tab') == 'stream' || request()->get('tab') == null ? 'border-b-2 border-accent text-accent' : '' }}">Stream</span>
            </a>
            <a href="{{ $url ?? '#' }}?tab=tasks"
                class="flex gap-2 items-center px-4 py-3 rounded-lg duration-700 hover:bg-primary hover:text-neutral">
                <span
                    class="text-lg font-bold tracking-wider capitalize text-accent {{ request()->get('tab') == 'tasks' ? 'border-b-2 border-accent text-accent' : '' }}">Tasks</span>
            </a>
            <a href="{{ $url ?? '#' }}?tab=people"
                class="flex gap-2 items-center px-4 py-3 rounded-lg duration-700 hover:bg-primary hover:text-neutral">
                <span
                    class="text-lg font-bold tracking-wider capitalize text-accent {{ request()->get('tab') == 'people' ? 'border-b-2 border-accent text-accent' : '' }}">People</span>
            </a>
        </div>

        <div class="flex flex-col gap-2">
            @if (request()->get('tab') == 'stream' || request()->get('tab') == null)

                @if (isset($stream))
                    {{ $stream }}
                @endif
            @elseif (request()->get('tab') == 'tasks')
                @if (isset($tasks))
                    {{ $tasks }}
                @endif
            @elseif (request()->get('tab') == 'announcements')
                @if (isset($announcements))
                    {{ $announcements }}
                @endif
            @elseif (request()->get('tab') == 'people')
                @if (isset($people))
                    {{ $people }}
                @endif
            @endif
        </div>
    </div>


</x-dashboard.student.base>
