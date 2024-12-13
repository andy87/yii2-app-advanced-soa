<?php declare(strict_types=1);

namespace yii2\frontend\assets;

use yii2\common\components\assets\BaseWebAsset;

/**
 * < Frontend > `AppAsset`
 *
 *      Main frontend application asset bundle.
 *
 * @package yii2\frontend\assets
 *
 * @tag #assets #app
 */
class AppAsset extends BaseWebAsset
{
    public $css = [ 'css/site.css' ];
}
