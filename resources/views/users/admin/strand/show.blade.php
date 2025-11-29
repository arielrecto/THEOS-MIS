<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('Grade Level')"  :back_url="route('admin.strands.index')" />
    <div class="panel flex flex-col gap-4">

        <h1 class="text-lg sm:text-xl font-bold text-accent capitalize">
            {{$strand->acronym}} - {{ $strand->name }}
        </h1>

        <!-- Description: reduce fixed height, allow wrapping -->
        <div class="min-h-20 p-3 rounded-lg bg-gray-100 text-gray-500 text-sm">
            {{$strand->descriptions}}
        </div>

        <!-- Summary card(s) — responsive grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <x-card label="Classrooms" total="{{$strand->classrooms()->count()}}" class="shadow-none border border-accent"/>
        </div>

        <h2 class="text-lg font-bold text-accent mt-2">Classrooms</h2>

        <!-- Classrooms grid: responsive columns, cards adapt to small viewports (320px width) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($strand->classrooms as $classroom)
                <div class="rounded-lg border border-accent overflow-hidden flex flex-col">
                    <!-- Card header: image + text arranged horizontally on larger screens,
                         stacked on very small screens. No absolute positioning. -->
                    <a href="#"
                       class="block bg-accent p-3 sm:p-4 flex items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base sm:text-lg font-semibold text-primary capitalize leading-tight truncate">
                                {{ $classroom->strand->name }}
                            </h3>

                            <p class="text-sm text-primary mt-1 truncate">
                                {{ $classroom->teacher->name }}
                            </p>
                        </div>

                        <!-- Responsive avatar: smaller on narrow screens -->
                        <img src="{{ $classroom->teacher->profile->image }}" alt="teacher"
                             class="h-12 w-12 sm:h-16 sm:w-16 object-cover rounded-full flex-shrink-0">
                    </a>

                    <div class="p-3">
                        <h4 class="text-sm uppercase text-gray-700 truncate">
                            {{ $classroom->name }} - {{ $classroom->strand->acronym }}
                        </h4>
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-accent flex items-center justify-center p-6">
                    <p class="text-base font-semibold text-accent text-center">No Classrooms</p>
                </div>
            @endforelse
        </div>
    </div>
</x-dashboard.admin.base>
