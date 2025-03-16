@props([
    'title' => 'sample',
    'back_url' => null,
    'create_url' => null,
])

<div class="flex justify-between items-center py-5 w-full">
    <div class="flex gap-5 items-center">
        @if ($back_url)
            <a href="{{ $back_url }}" class="btn btn-xs btn-accent">
                <i class="fi fi-rr-arrow-left"></i>
            </a>
        @endif
        <a href="http://"></a>
        <h1 class="text-2xl font-bold capitalize text-accent">
            {{ $title }}
        </h1>
    </div>

    <div>
        @if ($create_url)
            <a href="{{ $create_url }}" class="btn btn-sm btn-accent">create</a>
        @endif

        @if (isset($other))
            {{$other}}
        @endif
    </div>

</div>
