{{-- Wall calendar with date grid, used for date summaries. --}}
<svg {{ $attributes->merge(['class' => 'w-14 h-14']) }} viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <rect x="6" y="10" width="44" height="40" rx="5" fill="#fff" stroke="#3b6fd8" stroke-width="2.4" />
    <path d="M6 15a5 5 0 0 1 5-5h34a5 5 0 0 1 5 5v6H6v-6Z" fill="#dbe6fd" stroke="#3b6fd8" stroke-width="2.4" />
    <rect x="15" y="5" width="4" height="10" rx="2" fill="#3b6fd8" />
    <rect x="37" y="5" width="4" height="10" rx="2" fill="#3b6fd8" />
    @foreach ([28, 35, 42] as $y)
        @foreach ([13, 21, 29, 37] as $x)
            <rect x="{{ $x }}" y="{{ $y }}" width="5" height="4" rx="1" fill="#5b8def" />
        @endforeach
    @endforeach
</svg>
