@props([
    'count' => 0,
    'icon' => null,
    'label' => null,
    'icon_color' => 'primary',
    'link' => null,
])

<a href="{{ $link ?? '#' }}"
    class="flex items-center p-6 w-full h-40 rounded-lg shadow-lg transition-transform duration-300 bg-base-100 hover:scale-105">
    <div class="flex justify-center items-center w-16 h-16 rounded-full bg-{{ $icon_color }}/10">
        <i class="text-4xl {{ $icon }} text-{{ $icon_color }}"></i>
    </div>
    <div class="ml-4">
        <h1 class="text-lg font-semibold text-gray-600">{{ $label ?? 'Total Users' }}</h1>
        <p class="text-4xl font-bold text-{{ $icon_color }}">{{ $count ?? 120 }}</p>
    </div>
</a>
