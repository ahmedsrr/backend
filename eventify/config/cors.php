<?php

return [
<<<<<<< HEAD
=======

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */
    'allowed_origins' => [
        'http://localhost:3000' ,
        'http://127.0.0.1:3000' ,
        ],
>>>>>>> f13ca709289e4f41531592e10cb44d905cf2220d
    'paths' => ['api/*', 'login','logout', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // ERREUR ICI AVANT : Vous aviez peut-être ['*']
    // CORRECTION : On liste explicitement l'adresse du Frontend
    'allowed_origins' => [
        'http://localhost:3000', 
        'http://127.0.0.1:3000'
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

<<<<<<< HEAD
    'supports_credentials' => true, 
];
=======
    'supports_credentials' => true,

];
>>>>>>> f13ca709289e4f41531592e10cb44d905cf2220d
