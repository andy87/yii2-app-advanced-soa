<?php

namespace app\common\components\trair;

use Yii;
use yii\base\Model;

/**
 * Trait `YiiErrorLog`
 *
 * @package app\common\components\trair
 */
trait RuntimeLogs
{
    public string $runtimeLogError = 'runtimeLogError';
    public string $runtimeLogInfo = 'runtimeLogInfo';
    public string $runtimeLogWarning = 'runtimeLogWarning';
    public string $runtimeLogDebug = 'runtimeLogDebug';

    /**
     * @param string $method
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @return void
     */
    public function runtimeLogError(string $method, string $message, Model $model, array $data = []): void
    {
        $this->runtimeLogCore($this->runtimeLogError, $method, $message, $model, $data);
    }

    /**
     * @param string $method
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @return void
     */
    public function runtimeLogInfo(string $method, string $message, Model $model, array $data = []): void
    {
        $this->runtimeLogCore($this->runtimeLogInfo, $method, $message, $model, $data);
    }

    /**
     * @param string $method
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @return void
     */
    public function runtimeLogWarning(string $method, string $message, Model $model, array $data = []): void
    {
        $this->runtimeLogCore($this->runtimeLogWarning, $method, $message, $model, $data);
    }

    /**
     * @param string $method
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @return void
     */
    public function runtimeLogDebug(string $method, string $message, Model $model, array $data = []): void
    {
        $this->runtimeLogCore($this->runtimeLogDebug, $method, $message, $model, $data);
    }

    /**
     * @param string $type
     * @param string $method
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @return void
     */
    public function runtimeLogCore(string $type, string $method, string $message, Model $model, array $data = []): void
    {
        $log = [
            'method' => $method,
            'message' => $message,
            'errors' => $model->errors,
            'attributes' => $model->attributes,
        ];

        switch ($type) {
            case $this->runtimeLogError:
                Yii::error($log);
                break;

            case $this->runtimeLogInfo:
                Yii::info($log);
                break;

            case $this->runtimeLogWarning:
                Yii::warning($log);
                break;

            case $this->runtimeLogDebug:
                Yii::debug($log);
                break;
        }
    }
}