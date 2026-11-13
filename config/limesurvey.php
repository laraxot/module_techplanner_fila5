<?php

declare(strict_types=1);
use Illuminate\Support\Env;

return [
    /*
    |--------------------------------------------------------------------------
    | URL of your LimeSurvey install
    |--------------------------------------------------------------------------
    |
    | This is the URL of the LimeSurvey install that you are connecting to.
    |
    | By default, RemoteControl is not enabled, follow instructions at
    | https://manual.limesurvey.org/RemoteControl_2_API to enable
    |
    */
    'url' => Env::get('LIMESURVEY_URL', 'https://localhost/limesurvey/'),

    /*
    |--------------------------------------------------------------------------
    | Administrator Username to access the API With
    |--------------------------------------------------------------------------
    |
    | This can be any administrator account, but should probably be a generic
    | only used for this purpose
    |
    */
    'username' => Env::get('LIMESURVEY_USERNAME', ''),

    /*
    |--------------------------------------------------------------------------
    | Password of the account being used
    |--------------------------------------------------------------------------
    */
    'password' => Env::get('LIMESURVEY_PASSWORD', ''),
];
