<?php
return [
    /*
    |--------------------------------------------------------------------------
    | OFFICEGEST SEND EMAIL PARAMS
    |--------------------------------------------------------------------------
    |
    */

    'is_active' => env('OFFICEGEST_EMAIL_ACTIVE', false),
    'url' => env('OFFICEGEST_EMAIL_URL', ''),
    'user' => env('OFFICEGEST_EMAIL_USER', ''),
    'api_key' => env('OFFICEGEST_EMAIL_KEY', ''),
];
