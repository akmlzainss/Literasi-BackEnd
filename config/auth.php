<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'admins',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'siswa' => [ // Guard ini untuk web/session based
            'driver' => 'session',
            'provider' => 'siswas',
        ],
        // TAMBAHKAN GUARD INI KHUSUS UNTUK API FLUTTER
        'siswa-api' => [
            'driver' => 'sanctum',
            'provider' => 'siswas',
        ],
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'siswas' => [
            'driver'=> 'eloquent',
            'model'=> App\Models\Siswa::class,
        ]
    ],

    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'siswas' => [
            'provider' => 'siswas',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
