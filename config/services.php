<?php

declare(strict_types=1);
use Illuminate\Support\Env;

return [
    'facebook' => [
        'client_id' => Env::get('FACEBOOK_CLIENT_ID'),
        'client_secret' => Env::get('FACEBOOK_CLIENT_SECRET'),
        'redirect' => Env::get('FACEBOOK_REDIRECT_URI'),
    ],
    'twitter' => [
        'client_id' => Env::get('TWITTER_CLIENT_ID'),
        'client_secret' => Env::get('TWITTER_CLIENT_SECRET'),
        'redirect' => Env::get('TWITTER_REDIRECT_URI'),
    ],
    'instagram' => [
        'client_id' => Env::get('INSTAGRAM_KEY'),
        'client_secret' => Env::get('INSTAGRAM_SECRET'),
        'redirect' => Env::get('INSTAGRAM_REDIRECT_URI'),
    ],
    'google' => [
        'client_id' => Env::get('GOOGLE_CLIENT_ID'),
        'client_secret' => Env::get('GOOGLE_CLIENT_SECRET'),
        'redirect' => Env::get('GOOGLE_REDIRECT_URI'),
        'maps_api_key' => Env::get('GOOGLE_MAPS_API_KEY'),
    ],
    'bing' => [
        'maps_api_key' => Env::get('BING_MAPS_API_KEY'),
    ],
    'netfun' => [
        'token' => Env::get('NETFUN_TOKEN'),
    ],
    'newsapi' => [
        'app_key' => Env::get('NEWSAPI_APP_KEY'),
    ],
    'telegram-bot-api' => [
        'token' => Env::get('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE'),
        'bot_url' => Env::get('TELEGRAM_BOT_URL'),
        'webhook' => Env::get('TELEGRAM_BOT_WEBHOOK'),
    ],
    'locationiq' => [
        'key' => Env::get('LOCATIONIQ_API_KEY'),
    ],
];
