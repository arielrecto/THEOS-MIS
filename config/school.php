<?php

/*
| School identity shown across the portals (footers, headers, reports).
| Override per environment in .env.
*/

return [
    'name' => env('SCHOOL_NAME', 'Theos Higher Ground Academe'),

    'established' => env('SCHOOL_ESTABLISHED', 1997),

    // Public-site social links (footer). Leave empty to hide an icon.
    'social' => [
        'facebook' => env('SCHOOL_FACEBOOK_URL'),
        'instagram' => env('SCHOOL_INSTAGRAM_URL'),
        'youtube' => env('SCHOOL_YOUTUBE_URL'),
    ],

    // Wallpaper behind every portal page (admin, teacher, student, registrar, hr), relative to public/.
    'dashboard_background' => env('SCHOOL_DASHBOARD_BACKGROUND', 'bg6.JPEG'),
];
