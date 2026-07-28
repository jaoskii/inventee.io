<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '0EKJQsnAP86C9UUL_2LsNnrsRVtoxXgn',
            // Trust Railway/Docker private hops so X-Forwarded-Proto is kept (HTTPS URL generation).
            // index.php also sets $_SERVER['HTTPS'] from that header as a primary fallback.
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

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
/*    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];*/

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
