<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Taskord Configuration
    |--------------------------------------------------------------------------
    */

    'discord' => [
        'webhook' => env('DISCORD_WEBHOOK'),
    ],

    'app' => [
        'version_key' => env('APP_VERSION_KEY'),
    ],

];
