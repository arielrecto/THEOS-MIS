{{-- Student avatar in a blue disc, used for student counts. --}}
<svg {{ $attributes->merge(['class' => 'w-16 h-16']) }} viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <circle cx="32" cy="32" r="30" fill="#5b8def" stroke="#dbe6fd" stroke-width="3" />
    <defs>
        <clipPath id="student-avatar-clip">
            <circle cx="32" cy="32" r="28.5" />
        </clipPath>
    </defs>
    <g clip-path="url(#student-avatar-clip)">
        <!-- shoulders -->
        <path d="M12 62c0-11 9-18 20-18s20 7 20 18" fill="#e8efff" stroke="#1e3a8a" stroke-width="1.8" stroke-linejoin="round" />
        <path d="M26 45l6 7 6-7" fill="none" stroke="#1e3a8a" stroke-width="1.8" stroke-linejoin="round" />
        <!-- neck -->
        <path d="M28 38v6h8v-6" fill="#fde7d8" stroke="#1e3a8a" stroke-width="1.8" stroke-linejoin="round" />
    </g>
    <!-- head -->
    <ellipse cx="32" cy="27" rx="9.5" ry="11" fill="#fde7d8" stroke="#1e3a8a" stroke-width="1.8" />
    <!-- hair -->
    <path d="M22.5 26c-1-8 4-13 10-13s10.5 4 9.5 12c-3-1-6-4-7-7-3 4-8 7-12.5 8Z" fill="#1e3a8a" />
</svg>
