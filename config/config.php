<?php

declare(strict_types=1);

return [
    'name' => 'TechPlanner',
    'icon' => 'techplanner-icon',
    'guard' => [
        'web' => 'web',
        'api' => 'api',
    ],
    'routes' => [
        'web' => [
            'prefix' => 'techplanner',
            'middleware' => ['web'],
        ],
        'api' => [
            'prefix' => 'api/techplanner',
            'middleware' => ['api'],
        ],
    ],
    'providers' => [
        // Module Service Providers
    ],
    'permissions' => [
        'manage' => 'techplanner.manage',
        'create' => 'techplanner.create',
        'edit' => 'techplanner.edit',
        'delete' => 'techplanner.delete',
    ],
];
