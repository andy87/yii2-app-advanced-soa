<?php

namespace yii2\common\components\core;

use yii\web\AssetBundle;

/**
 * < Common >
 *
 *      Base asset bundle.
 *
 * @package yii2\common\components\assets
 *
 * @tag #assets #base
 */
abstract class BaseAsset extends AssetBundle
{
    /** @var string Путь к корневой директории веб-приложения */
    public $basePath = '@webroot';

    /** @var string URL-адрес корневой директории веб-приложения */
    public $baseUrl = '@web';
}