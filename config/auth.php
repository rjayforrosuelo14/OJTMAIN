<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Supported: "session"
    */
    'guards' => [
        // Web/Admin/User Guard
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Intern Guard
        'intern' => [
            'driver' => 'session',
            'provider' => 'interns',
        ],
        'supervisor' => [
            'driver' => 'session',
            'provider' => 'supervisors',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Define how users/interns are retrieved from your database.
    |
    | Supported drivers: "eloquent", "database"
    */
    'providers' => [
        // Admin/User provider
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Intern provider
        'interns' => [
            'driver' => 'eloquent',
            'model' => App\Models\Intern::class,
        ],
        'supervisors' => [
            'driver' => 'eloquent',
            'model' => App\Models\Supervisor::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Settings
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        // Reset for users
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        // Reset for interns (optional)
        'interns' => [
            'provider' => 'interns',
            'table' => 'intern_password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => 10800,

];
