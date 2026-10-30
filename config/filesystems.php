<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => Illuminate\Support\Env::get('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => Illuminate\Support\Env::get('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => url('/storage'),
            'visibility' => 'public',
        ],
        'public_html' => [
            'driver' => 'local',
            'root' => public_path('/'),
            // 'url' => url('/'),
            //'url' => url('/'),
            // 'url' => url('/'),
            'url' => '/',
            'visibility' => 'public',
        ],
        'videos' => [
            'driver' => 'local',
            'root' => public_path('/videos'),
            'url' => '/',
            'visibility' => 'public',
        ],
        /*
        'photos' => [
            'driver' => 'local',
            'root' => public_path('/photos'),
            'visibility' => 'public',
        ],
        */
        'photos' => [
            'driver' => 'ftp',
            'host' => 'ftpupload.net',
            'username' => 'epiz_29396204',
            'password' => 'tMY84nuxwMUD8',
            'url' => 'http://xotimagetest.infinityfreeapp.com',
            // Optional FTP Settings...
            // 'port' => 21,
            'root' => '/htdocs/photos/geek_local',
            // 'passive' => true,
            // 'ssl' => true,
            // 'timeout' => 30,
        ],

        'cache' => [
            'driver' => 'local',
            // 'root' => storage_path('app/public'),
            'root' => base_path('../cache'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => Illuminate\Support\Env::get('AWS_ACCESS_KEY_ID'),
            'secret' => Illuminate\Support\Env::get('AWS_SECRET_ACCESS_KEY'),
            'region' => Illuminate\Support\Env::get('AWS_DEFAULT_REGION'),
            'bucket' => Illuminate\Support\Env::get('AWS_BUCKET'),
            'url' => Illuminate\Support\Env::get('AWS_URL'),
        ],

        'dropbox' => [
            'driver' => 'dropbox',
            'authorizationToken' => 'aaa',
        ],

        'uploads' => [
            'driver' => 'local',
            'root' => public_path('/uploads/photos'),
            'url' => '/uploads/photos',
            'visibility' => 'public',
        ],
    ],
];
