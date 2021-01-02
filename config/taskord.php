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

    'tasks' => [
        'templates' => [
            'I just launched a new product! Check out #%s',
            'Check  out #%s, I just lauched it today! 🚀',
            'Welcome into the world #%s!',
        ],
    ],

];
