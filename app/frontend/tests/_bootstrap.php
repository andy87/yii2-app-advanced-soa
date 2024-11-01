<?php

use Dotenv\Dotenv;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');
defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', __DIR__.'/../../');

require_once __DIR__ . '/../../../vendor/autoload.php';

Dotenv::createImmutable( __DIR__ . '/../../', '.env')->load();

require_once __DIR__ . '/../../../vendor/yiisoft/yii2/Yii.php';
require_once YII_APP_BASE_PATH . '/common/config/bootstrap.php';
require_once __DIR__ . '/../config/bootstrap.php';