<?php

namespace yii2\common\components;

/**
 * Class View
 *
 * @package yii2\common\components
 */
class View extends \yii\web\View
{
    /**
     * @param string $filePath
     *
     * @return string
     */
    public function attrDataTemplate(string $filePath): string
    {
        return (YII_ENV_DEV) ? ' data-template="' . $filePath . '" ' : '';
    }
}