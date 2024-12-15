<?php declare(strict_types=1);

namespace yii2\backend\assets;

use yii2\common\components\assets\BaseWebAsset;

/**
 * <Backend > `AppAsset`
 *
 * @package yii2\backend\assets
 *
 * @tag #assets #app
 */
class AppAsset extends BaseWebAsset
{
    public $css = [ 'css/site.css' ];
}
