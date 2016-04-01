<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SMS API Key
    |--------------------------------------------------------------------------
    */

    'api_key' => env('SMS_API_KEY', 'changeme'),

    /*
    |--------------------------------------------------------------------------
    | SMS API Secret
    |--------------------------------------------------------------------------
    |
    | Specify the length of time (in minutes) that the token will be valid for.
    | Defaults to 1 hour
    |
    */

    'secret' => env('SMS_API_SECRET', 'secret'),

];
