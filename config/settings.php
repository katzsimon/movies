<?php

return [

    /*
    |--------------------------------------------------------------------------
    | App Settings
    |--------------------------------------------------------------------------
    |
    |
    */

	// Set the default output for the Admin CRUD and App
	// Possible options: blade, vueapp, inertia, json
    'output'=>[
        'admin'=>env('OUTPUT_ADMIN', 'blade'),
        'app'=>env('OUTPUT_APP', 'blade')
    ],

	// Set the base path for API requests,
	// Allows you to use http://localhost:3000 for npm run watch while developing

    'url'=>env('MIX_APP_URL', env('APP_URL', '#')),

	// Choose between Sanctum or Passport authentication Tokens
    'api_guard'=>env('API_GUARD', 'sanctum'),

	// To enable the Password Protection for the app, just used for Demo purposes
	// Set to false to disable and clear session variable
    'protect'=>[
        'enabled'=>env('PROTECT_ENABLED', false),
        'password'=>env('PROTECT_PASSWORD', 'x1x@x1x')
    ],

];
