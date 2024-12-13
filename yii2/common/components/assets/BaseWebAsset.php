<?php

namespace yii2\common\components\assets;

use yii2\common\components\core\BaseAsset;

/**
 * < Common >
 *     Base web asset bundle.
 *
 * @package yii2\common\components\assets
 *
 * @tag #assets #base
 */
abstract class BaseWebAsset extends BaseAsset
{
    public $css = [];
    public $js = [];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}