{{-- Stacked folders with an archive box, used for "archived" summaries. --}}
<svg {{ $attributes->merge(['class' => 'w-20 h-16']) }} viewBox="0 0 80 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <!-- back folder -->
    <path d="M14 8h14l4 5h22a3 3 0 0 1 3 3v24H14V8Z" fill="#c7d7fb" stroke="#1e3a8a" stroke-width="1.6" stroke-linejoin="round" />
    <!-- papers -->
    <rect x="22" y="12" width="26" height="20" rx="1.5" fill="#fff" stroke="#1e3a8a" stroke-width="1.4" />
    <rect x="26" y="9" width="26" height="20" rx="1.5" fill="#fff" stroke="#1e3a8a" stroke-width="1.4" />
    <!-- front open folder -->
    <path d="M6 22a3 3 0 0 1 3-3h14l4 5h24a3 3 0 0 1 3 3v24a3 3 0 0 1-3 3H9a3 3 0 0 1-3-3V22Z" fill="#5b8def" stroke="#1e3a8a" stroke-width="1.6" stroke-linejoin="round" />
    <path d="M6 31l6-6h44l-2 26H9" fill="#3b6fd8" stroke="#1e3a8a" stroke-width="1.6" stroke-linejoin="round" />
    <!-- archive box -->
    <path d="M46 36l14-6 14 6-14 6-14-6Z" fill="#dbe6fd" stroke="#1e3a8a" stroke-width="1.6" stroke-linejoin="round" />
    <path d="M46 36v16l14 7V42l-14-6Z" fill="#9db9f5" stroke="#1e3a8a" stroke-width="1.6" stroke-linejoin="round" />
    <path d="M74 36v16l-14 7V42l14-6Z" fill="#7aa1f0" stroke="#1e3a8a" stroke-width="1.6" stroke-linejoin="round" />
    <rect x="63" y="46" width="7" height="3" rx="1" transform="rotate(-26 63 46)" fill="#1e3a8a" />
</svg>
