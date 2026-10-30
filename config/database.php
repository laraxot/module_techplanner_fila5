<?php

declare(strict_types=1);

use Modules\Tenant\Services\TenantService;

return [
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => Illuminate\Support\Env::get('DB_HOST', '127.0.0.1'),
            'port' => Illuminate\Support\Env::get('DB_PORT', '3306'),
            'database' => Illuminate\Support\Env::get('DB_DATABASE', 'forge84'),
            'username' => Illuminate\Support\Env::get('DB_USERNAME', 'forge_mysql_25_2'),
            'password' => Illuminate\Support\Env::get('DB_PASSWORD', ''),
            // 'unix_socket' => '/Applications/MAMP/tmp/mysql/mysql.sock',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'mariadb' => [
            'driver' => 'mariadb',
            'url' => Illuminate\Support\Env::get('DB_URL'),
            'host' => Illuminate\Support\Env::get('DB_HOST', '127.0.0.1'),
            'port' => Illuminate\Support\Env::get('DB_PORT', '3306'),
            'database' => Illuminate\Support\Env::get('DB_DATABASE', 'laravel'),
            'username' => Illuminate\Support\Env::get('DB_USERNAME', 'root'),
            'password' => Illuminate\Support\Env::get('DB_PASSWORD', ''),
            'unix_socket' => Illuminate\Support\Env::get('DB_SOCKET', ''),
            'charset' => Illuminate\Support\Env::get('DB_CHARSET', 'utf8mb4'),
            'collation' => Illuminate\Support\Env::get('DB_COLLATION', 'utf8mb4_uca1400_ai_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => Illuminate\Support\Env::get('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],


        /*
        'user' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            // 'unix_socket' => '/Applications/MAMP/tmp/mysql/mysql.sock',
            'database' => env('DB_DATABASE_USER', 'forge86'),
            'username' => env('DB_USERNAME_USER', 'forgeforge_user_03'),
            'password' => env('DB_PASSWORD_USER', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],
        */


        'sqlite' => [
            'driver' => 'sqlite',
            'url' => Illuminate\Support\Env::get('DATABASE_URL'),
            'database' => Illuminate\Support\Env::get('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => Illuminate\Support\Env::get('DB_FOREIGN_KEYS', true),
        ],


    ], // end connections
];
