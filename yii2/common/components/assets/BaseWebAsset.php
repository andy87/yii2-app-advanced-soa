<?php

namespace common\components\assets;

use yii\web\YiiAsset;
use yii\bootstrap5\BootstrapAsset;
use common\components\base\assets\BaseAsset;

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
    /** @var array $css */
    public $css = [];

    /** @var array $js */
    public $js = [];


    /** @var array $depends */
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
    ];
}