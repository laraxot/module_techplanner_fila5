<?php

declare(strict_types=1);
use Illuminate\Support\Env;

return [
    'limesurvey' => [
        'api' => [
            'url' => Env::get('LIMESURVEY_URL', ''),
            'username' => Env::get('LIMESURVEY_USERNAME', ''),
            'password' => Env::get('LIMESURVEY_PASSWORD', ''),
        ],
    ],
];
