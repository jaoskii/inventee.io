<?php
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
            // Match deployed main-local: trust private proxies for X-Forwarded-Proto.
            'trustedHosts' => [
                '10.0.0.0/8',
                '172.16.0.0/12',
                '192.168.0.0/16',
                '127.0.0.1',
                '::1',
            ],
        ],
    ],
];
