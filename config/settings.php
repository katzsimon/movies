<?php

return [

    /*
    |--------------------------------------------------------------------------
    | App Settings
    |--------------------------------------------------------------------------
    |
    |
    */

    'output'=>[
        'admin'=>env('OUTPUT_ADMIN', 'blade'),
        'app'=>env('OUTPUT_APP', 'blade')
    ],

    'url'=>env('MIX_APP_URL', env('APP_URL', '#')),

    'api_guard'=>env('API_GUARD', 'sanctum'),

    'protect'=>[
        'enabled'=>env('PROTECT_ENABLED', false),
        'password'=>env('PROTECT_PASSWORD', 'x1x@x1x')
    ],

];
