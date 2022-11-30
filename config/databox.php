<?php

return [

    'default_source' => 'default',

    'queue' => false,

    'sources' => [
        'default' => [
            'token' => env('DATABOX_TOKEN', ''),
            'queue' => null // use default
        ]
    ]
];
