<?php

/*
| School identity shown across the portals (footers, headers, reports).
| Override per environment in .env.
*/

return [
    'name' => env('SCHOOL_NAME', 'Theos Higher Ground Academe'),

    'established' => env('SCHOOL_ESTABLISHED', 1997),

    // Wallpaper behind every portal page (admin, teacher, student, registrar, hr), relative to public/.
    'dashboard_background' => env('SCHOOL_DASHBOARD_BACKGROUND', 'bg6.JPEG'),
];
