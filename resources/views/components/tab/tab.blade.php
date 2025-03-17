@props(['tabs', 'active'])

<div>
    <div class="flex pb-2 space-x-4 border-b">
        @foreach ($tabs as $key => $label)
            <a href="{{ request()->fullUrlWithQuery(['activeTab' => $key]) }}"
                class="px-4 py-2 focus:outline-none"
                :class="  request()->get('activeTab') == {{ $key }} ? 'text-accent border-b-2 border-accent' : ''">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $slot }}
    </div>
</div>