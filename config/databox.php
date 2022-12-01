<?php

return [

    // name of the default source, used when not passing a specific source name
    'default_source' => 'default',

    // should the data be pushed with a queued job?
    // default setting, can be overridden per source
    'queue' => false,

    // List of sources, you can create as many as you want, each with its
    // own token and queue setting
    'sources' => [

        'default' => [

            // The token generated in the databox UI
            'token' => env('DATABOX_TOKEN', ''),

            // Each source can override the queue setting.
            // null means use the default setting above
            'queue' => null,
        ],

        // More sources....
    ],
];
