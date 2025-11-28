@props([
    'classroom' => null,
    'url' => null,
])


<x-dashboard.student.base>
    <x-notification-message />
    <div class="flex flex-col gap-2">
        <!-- Header: stack on mobile, inline on sm+; use min-w-0 + truncate to prevent overflow -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full gap-2">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold tracking-wider capitalize text-accent truncate">
                    {{ $classroom->name ?? 'Classroom' }} - <span
                        class="inline-block truncate">{{ $classroom->strand->acronym ?? 'Strand' }}</span>
                </h1>
                <p class="text-sm tracking-wide capitalize text-primary mt-1 sm:mt-0 truncate">
                    {{ $classroom->academicYear->name ?? 'Academic Year' }}
                </p>
            </div>
        </div>

        <!-- Tabs: horizontally scrollable on small screens, anchors are non-shrinking and nowrap -->
        <div class="flex items-center w-full rounded-lg border overflow-x-auto whitespace-nowrap -mx-2 px-2">
            <a href="{{ $url ?? '#' }}?tab=stream"
                class="inline-flex flex-none gap-2 items-center px-4 py-3 rounded-lg duration-150 hover:bg-primary hover:text-neutral">
                <span
                    class="text-lg font-bold tracking-wider capitalize text-accent whitespace-nowrap {{ request()->get('tab') == 'stream' || request()->get('tab') == null ? 'border-b-2 border-accent text-accent' : '' }}">Stream</span>
            </a>
            <a href="{{ $url ?? '#' }}?tab=tasks"
                class="inline-flex flex-none gap-2 items-center px-4 py-3 rounded-lg duration-150 hover:bg-primary hover:text-neutral">
                <span
                    class="text-lg font-bold tracking-wider capitalize text-accent whitespace-nowrap {{ request()->get('tab') == 'tasks' ? 'border-b-2 border-accent text-accent' : '' }}">Tasks</span>
            </a>
            <a href="{{ $url ?? '#' }}?tab=people"
                class="inline-flex flex-none gap-2 items-center px-4 py-3 rounded-lg duration-150 hover:bg-primary hover:text-neutral">
                <span
                    class="text-lg font-bold tracking-wider capitalize text-accent whitespace-nowrap {{ request()->get('tab') == 'people' ? 'border-b-2 border-accent text-accent' : '' }}">People</span>
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
