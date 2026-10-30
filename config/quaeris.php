<?php

declare(strict_types=1);

return [
    'limesurvey' => [
        'api' => [
            'url' => Illuminate\Support\Env::get('LIMESURVEY_URL', ''),
            'username' => Illuminate\Support\Env::get('LIMESURVEY_USERNAME', ''),
            'password' => Illuminate\Support\Env::get('LIMESURVEY_PASSWORD', ''),
        ],
    ],
];
