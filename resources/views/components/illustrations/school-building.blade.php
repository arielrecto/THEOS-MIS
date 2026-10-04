{{-- School building with graduation cap, used in the portal footer. --}}
<svg {{ $attributes->merge(['class' => 'w-16 h-12']) }} viewBox="0 0 80 60" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <!-- cap -->
    <path d="M40 2l11 5-11 5-11-5 11-5Z" fill="#3b6fd8" stroke="#1e3a8a" stroke-width="1.2" stroke-linejoin="round" />
    <path d="M33 9v4c0 2 3 3.5 7 3.5s7-1.5 7-3.5V9" fill="#5b8def" stroke="#1e3a8a" stroke-width="1.2" />
    <!-- roof -->
    <path d="M8 30l32-12 32 12H8Z" fill="#9db9f5" stroke="#1e3a8a" stroke-width="1.4" stroke-linejoin="round" />
    <!-- body -->
    <rect x="12" y="30" width="56" height="24" fill="#dbe6fd" stroke="#1e3a8a" stroke-width="1.4" />
    @foreach ([17, 26, 47, 56] as $x)
        <rect x="{{ $x }}" y="35" width="6" height="7" fill="#5b8def" stroke="#1e3a8a" stroke-width="1" />
    @endforeach
    <!-- door -->
    <path d="M35 54V42a5 5 0 0 1 10 0v12" fill="#3b6fd8" stroke="#1e3a8a" stroke-width="1.2" />
    <!-- steps -->
    <rect x="6" y="54" width="68" height="3" rx="1" fill="#9db9f5" stroke="#1e3a8a" stroke-width="1.2" />
</svg>
