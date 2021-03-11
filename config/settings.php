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

    'url'=>[
        'spa'=>env('SPA_URL', env('APP_URL', '#'))
    ]


];
