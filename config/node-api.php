<?php

return [
    'default' => env('FULLNODE_API_PROVIDER', 'getblock'),

    'providers' => [
        'getblock' => [
            'x-api-key' => env('GETBLOCK_X_API_KEY'),
            'endpoint'  => env('GTBLOCK_ENDPOINT'),
            'id'        => env('GETBLOCK_ID'),
        ]
    ]
];
