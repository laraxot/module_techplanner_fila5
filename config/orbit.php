<?php

declare(strict_types=1);

// use Modules\Tenant\Services\TenantService;

return [
    'default' => Illuminate\Support\Env::get('ORBIT_DEFAULT_DRIVER', 'md'),

    'drivers' => [
        // Optional legacy drivers remain declarative when Orbit is not installed.
        'md' => 'Orbit\\Drivers\\Markdown',
        'json' => 'Orbit\\Drivers\\Json',
        'yaml' => 'Orbit\\Drivers\\Yaml',
    ],

    'paths' => [
        'content' => base_path('config/database/content'),
        'cache' => base_path('config'),
    ],
];
