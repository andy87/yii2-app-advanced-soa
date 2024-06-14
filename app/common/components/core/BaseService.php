<?php

namespace app\common\components\core;

use Yii;
use yii\base\Model;

/**
 * Class `BaseService`
 *
 * @package app\common\components\core
 */
abstract class BaseService extends BaseSingleton
{
    /**
     * @param string $method
     * @param string $message
     * @param Model $model
     * 
     * @return void
     */
    public function errorLog( string $method, string $message, Model $model ): void
    {
        Yii::error([
            'method' => $method,
            'message' => $message,
            'errors' => $model->errors,
            'attributes' => $model->attributes,
        ]);
    }
}