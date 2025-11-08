@props([
    'links' => [],
])

@php
    use App\Models\Logo;

    // Get active main logo or default to logo-modified.png
    $mainLogo = Logo::where('type', 'main')->where('is_active', true)->latest()->first();

    $logoPath = $mainLogo ? Storage::url($mainLogo->path) : asset('logo.jpg');
@endphp

<div class="flex flex-col gap-4 px-5 py-6 w-1/6 h-full shadow-lg 4xl:rounded-lg bg-neutral">
    <div class="flex justify-center">
        <div class="flex flex-col gap-3 items-center w-auto h-auto">
            <img src="{{ $logoPath }}" alt="School Logo" class="object-contain w-24 h-24 rounded-full"
                {{-- Fallback if image fails to load --}}>
            <h1 class="text-lg font-semibold leading-tight text-center text-primary">
                Theos Higher Ground Academe
            </h1>
        </div>
    </div>

    <div class="flex flex-col gap-4 justify-between h-full">
        <ul class="flex flex-col gap-4 p-4 w-full h-full capitalize text-primary">
            @foreach ($links as $link)
                @if ($link['is_active'] ?? false)
                    <li>
                        <a href="{{ $link['url'] === '#' ? '#' : route($link['url']) }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 hover:bg-secondary hover:text-neutral {{ Route::is($link['url']) ? 'font-bold bg-primary text-neutral' : '' }}">
                            {!! $link['icon'] !!}
                            <span>
                                {{ $link['name'] }}
                            </span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
