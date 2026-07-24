<?php

defined('YII_DEBUG') or define('YII_DEBUG', (getenv('YII_DEBUG') ?: 'true') === 'true');
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV') ?: 'dev');

// Legacy PHP 5.6 codebase on PHP 8: PHP deprecations (number_format(null), strlen(null), ...)
// would otherwise be escalated to 500 responses by Yii's error handler.
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/common/config/bootstrap.php');
require(__DIR__ . '/backend/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/common/config/main.php'),
    require(__DIR__ . '/common/config/main-local.php'),
    require(__DIR__ . '/backend/config/main.php'),
    require(__DIR__ . '/backend/config/main-local.php')
);

$application = new yii\web\Application($config);
$application->run();
