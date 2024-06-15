<?php

namespace app\backend\assets;

use yii\web\AssetBundle;

/**
 * <Backend > `AppAsset`
 *
 * @package app\backend\assets
 *
 * @tag #backend #asset #app
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
