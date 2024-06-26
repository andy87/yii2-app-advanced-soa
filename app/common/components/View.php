<?php

namespace app\common\components;

/**
 * Class View
 *
 * @package app\common\components
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