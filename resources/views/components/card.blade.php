@props([
    'image' => null,
    'label' => 'Users',
    'total' => 0,
    'class' => ''
])

<div class="w-full h-full bg-white rounded-lg shadow-md shadow-secondary flex gap-2 p-5 {{$class}}">

    @if ($image)
        <img src="{{ $image }}" alt="" srcset="" class="object-cover w-1/3 h-full">
    @endif

    <div class="flex flex-col gap-2 justify-between w-full">
        <h1 class="text-2xl font-bold text-accent">
            {{ $label }}
        </h1>
        <p class="text-5xl text-accent font-bold text-ellipsis overflow-hidden flex justify-start">
            {{ $total }}
        </p>
    </div>
</div>
