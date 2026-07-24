<?php
use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../../.env');

return [
     'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host='.($_ENV['DB_HOST'] ?? '127.0.0.1').';port='.($_ENV['DB_PORT'] ?? '3306').';dbname='.$_ENV['DB_SCHEMA'], //sbc_standard
            'username' => $_ENV['DB_USER'], //sbc_erick
            'password' => $_ENV['DB_PASS'], //solutionbase
            'charset' => $_ENV['DB_CHARSET'],
            // Legacy app written for MySQL 5.x: relax MySQL 8 strict defaults
            // (ONLY_FULL_GROUP_BY, NO_ZERO_DATE, STRICT_TRANS_TABLES) per session.
            'on afterOpen' => function ($event) {
                $event->sender->createCommand("SET SESSION sql_mode='NO_ENGINE_SUBSTITUTION'")->execute();
            },
        ],
    ],
];
