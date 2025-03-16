@props([
    'type' => null,
    'url' => null,

])



@if($type === "png | jpeg | jpg")

    <img srct="{{url}}" class="w-full h-full"/>

@endif

