<?php declare(strict_types=1);

namespace app\frontend\assets;

use yii\web\AssetBundle;

/**
 * < Frontend > `AppAsset`
 *
 *      Main frontend application asset bundle.
 *
 * @package app\frontend\assets
 *
 * @tag #assets #app
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
