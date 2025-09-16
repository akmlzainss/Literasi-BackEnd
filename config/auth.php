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
            'provider' => 'siswa', // ✅ perbaiki di sini
        ],
        // Guard khusus API siswa (misal untuk Flutter)
        'siswa-api' => [
            'driver' => 'sanctum',
            'provider' => 'siswa', // ✅ harus sama
        ],
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'siswa' => [
            'driver'=> 'eloquent',
            'model'=> App\Models\Siswa::class,
        ],
    ],

    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'siswa' => [
            'provider' => 'siswa', // ✅ samakan
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
