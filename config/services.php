<?php

declare(strict_types=1);

return [
    'facebook' => [
        'client_id' => Illuminate\Support\Env::get('FACEBOOK_CLIENT_ID'),
        'client_secret' => Illuminate\Support\Env::get('FACEBOOK_CLIENT_SECRET'),
        'redirect' => Illuminate\Support\Env::get('FACEBOOK_REDIRECT_URI'),
    ],
    'twitter' => [
        'client_id' => Illuminate\Support\Env::get('TWITTER_CLIENT_ID'),
        'client_secret' => Illuminate\Support\Env::get('TWITTER_CLIENT_SECRET'),
        'redirect' => Illuminate\Support\Env::get('TWITTER_REDIRECT_URI'),
    ],
    'instagram' => [
        'client_id' => Illuminate\Support\Env::get('INSTAGRAM_KEY'),
        'client_secret' => Illuminate\Support\Env::get('INSTAGRAM_SECRET'),
        'redirect' => Illuminate\Support\Env::get('INSTAGRAM_REDIRECT_URI'),
    ],
    'google' => [
        'client_id' => Illuminate\Support\Env::get('GOOGLE_CLIENT_ID'),
        'client_secret' => Illuminate\Support\Env::get('GOOGLE_CLIENT_SECRET'),
        'redirect' => Illuminate\Support\Env::get('GOOGLE_REDIRECT_URI'),
        'maps_api_key' => Illuminate\Support\Env::get('GOOGLE_MAPS_API_KEY'),
    ],
    'bing' => [
        'maps_api_key' => Illuminate\Support\Env::get('BING_MAPS_API_KEY'),
    ],
    'netfun' => [
        'token' => Illuminate\Support\Env::get('NETFUN_TOKEN'),
    ],
    'newsapi' => [
        'app_key' => Illuminate\Support\Env::get('NEWSAPI_APP_KEY'),
    ],
    'telegram-bot-api' => [
        'token' => Illuminate\Support\Env::get('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE'),
        'bot_url' => Illuminate\Support\Env::get('TELEGRAM_BOT_URL'),
        'webhook' => Illuminate\Support\Env::get('TELEGRAM_BOT_WEBHOOK'),
    ],
    'locationiq' => [
        'key' => Illuminate\Support\Env::get('LOCATIONIQ_API_KEY'),
    ],
];
