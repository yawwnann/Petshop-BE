<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | An HTTP or HTTPS URL to notify your application (a webhook) when the process is done.
    |
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'), // Contoh key lain

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Credentials
    |--------------------------------------------------------------------------
    |
    | Find your credentials in your Cloudinary Console.
    | Add the CLOUDINARY_URL to your .env file.
    | Format: cloudinary://{api_key}:{api_secret}@{cloud_name}
    |
    */
    'cloud' => [  // <-- PASTIKAN KEY 'cloud' INI ADA!
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'), // Pastikan ini mengambil dari .env
        'api_key' => env('CLOUDINARY_API_KEY'),    // Pastikan ini mengambil dari .env
        'api_secret' => env('CLOUDINARY_API_SECRET'), // Pastikan ini mengambil dari .env
    ],

    // URL configuration
    'url' => [
        'secure' => env('CLOUDINARY_SECURE', true),
        // ...etc
    ]

];