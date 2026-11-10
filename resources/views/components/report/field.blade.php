@props(['label'])

<div>
    <p class="field-label">{{ $label }}</p>
    <p {{ $attributes->merge(['class' => 'font-semibold text-gray-800']) }}>{{ $slot }}</p>
</div>
