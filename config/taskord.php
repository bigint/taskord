<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Taskord Configuration
    |--------------------------------------------------------------------------
    */

    'tasks' => [
        'templates' => [
            'I just launched a new product! Check out #%s',
            'Check  out #%s, I just launched it today! 🚀',
        ],
    ],

    'error' => [
        'deny' => "Oops! You can't perform this action",
        'rate-limit' => 'Oops! You are rate limited.',
    ],

    'reserved_slugs' => [
        'api',
        'launched',
        'new',
        'products',
        'unanswered',
        'popular',
        'admin',
        'staff',
        'stafftools',
        'tasks',
        'explore',
        'milestones',
        'help',
        'meetups',
        'settings',
        'deals',
        'open',
        'logout',
        'patron',
        'reputation',
        'notifications',
    ],

];
