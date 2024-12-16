<?php

namespace yii2\common\components\base\assets;

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
    public $basePath = '@webroot';
    public $baseUrl = '@web';
}