@props([
    'links' => [],
])

@php
    use App\Models\Logo;

    // Get active main logo or default to logo-modified.png
    $mainLogo = Logo::where('type', 'main')->where('is_active', true)->latest()->first();
    $logoPath = $mainLogo ? Storage::url($mainLogo->path) : asset('logo.jpg');
@endphp

{{-- Desktop / Tablet Sidebar --}}
<aside class="hidden md:flex flex-col gap-4 px-5 py-6 w-64 h-full shadow-lg 4xl:rounded-lg bg-neutral">
    <div class="flex justify-center">
        <div class="flex flex-col gap-3 items-center w-auto h-auto">
            <img src="{{ $logoPath }}" alt="School Logo" class="object-contain w-20 h-20 rounded-full">
            <h1 class="text-lg font-semibold leading-tight text-center text-primary">
                Theos Higher Ground Academe
            </h1>
        </div>
    </div>

    <div class="flex flex-col gap-4 justify-between h-full">
        <ul class="flex flex-col gap-2 p-2 w-full h-full capitalize text-primary overflow-y-auto">
            @foreach ($links as $link)
                @if ($link['is_active'] ?? false)
                    <li>
                        <a href="{{ $link['url'] === '#' ? '#' : route($link['url']) }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-secondary hover:text-neutral
                                  {{ Route::is($link['url']) ? 'font-bold bg-primary text-neutral' : '' }}">
                            {!! $link['icon'] !!}
                            <span class="truncate">{{ $link['name'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>

{{-- Mobile Bottom Navigation --}}
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-neutral border-t shadow-inner">
    <div class="flex justify-between items-center px-2 py-1">
        @foreach ($links as $link)
            @continue(!($link['is_active'] ?? false))
            @php
                $isActive = Route::is($link['url']);
                // build url (allow '#' as placeholder)
                $href = $link['url'] === '#' ? '#' : route($link['url']);
            @endphp
            <a href="{{ $href }}" class="flex-1">
                <div
                    class="flex flex-col items-center justify-center gap-1 py-2 px-1 rounded-lg transition-colors duration-150
                            {{ $isActive ? 'bg-primary text-neutral' : 'text-primary hover:bg-secondary hover:text-neutral' }}">
                    <div class="text-lg">
                        {!! $link['icon'] !!}
                    </div>
                    <span class="text-xs truncate text-center w-full">{{ $link['name'] }}</span>
                </div>
            </a>
        @endforeach
    </div>
</nav>
