<?php

namespace app\common\components\assets;

use app\common\components\core\BaseAsset;

/**
 * < Common >
 *     Base web asset bundle.
 *
 * @package app\common\components\assets
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