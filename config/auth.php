<?php

use App\Models\User;
use Modules\Center\Models\CenterUser;
use Modules\Student\Models\Student;
use Modules\Trainer\Models\Trainer;

return [

    'defaults' => [
        'guard'     => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        // Default web guard — existing User model (admin uses this)
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // Student guard
        'student' => [
            'driver'   => 'session',
            'provider' => 'students',
        ],

        // Trainer guard
        'trainer' => [
            'driver'   => 'session',
            'provider' => 'trainers',
        ],

        // Center guard
        'center' => [
            'driver'   => 'session',
            'provider' => 'center_users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => env('AUTH_MODEL', User::class),
        ],

        'students' => [
            'driver' => 'eloquent',
            'model'  => Student::class,
        ],

        'trainers' => [
            'driver' => 'eloquent',
            'model'  => Trainer::class,
        ],

        'center_users' => [
            'driver' => 'eloquent',
            'model'  => CenterUser::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire'   => 60,
            'throttle' => 60,
        ],

        'students' => [
            'provider' => 'students',
            'table'    => 'student_password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'trainers' => [
            'provider' => 'trainers',
            'table'    => 'trainer_password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],

        'center_users' => [
            'provider' => 'center_users',
            'table'    => 'center_password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
