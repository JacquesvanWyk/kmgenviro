<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Form Notification Email Addresses
    |--------------------------------------------------------------------------
    |
    | Configure which email address receives notifications for each form type.
    | You can set a single email or leave as default to use the main address.
    |
    */

    'emails' => [
        // General contact enquiries
        'contact' => env('FORM_EMAIL_CONTACT', 'jvw679@gmail.com'),

        // Quote/project requests
        'quote' => env('FORM_EMAIL_QUOTE', 'marabekg@kmgenviro.co.za'),

        // Training bookings
        'training' => env('FORM_EMAIL_TRAINING', 'bookings@kmgenviro.co.za'),

        // Equipment rental enquiries
        'equipment' => env('FORM_EMAIL_EQUIPMENT', 'rental@kmgenviro.co.za'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Fallback Email
    |--------------------------------------------------------------------------
    |
    | If a specific form email is not set, use this as the fallback.
    |
    */

    'default' => env('FORM_EMAIL_DEFAULT', 'info@kmgenviro.co.za'),
];
