<?php declare(strict_types=1);

namespace app\frontend\assets;

use app\common\components\assets\BaseWebAsset;

/**
 * < Frontend > `AppAsset`
 *
 *      Main frontend application asset bundle.
 *
 * @package app\frontend\assets
 *
 * @tag #assets #app
 */
class AppAsset extends BaseWebAsset
{
    public $css = [ 'css/site.css' ];
}
