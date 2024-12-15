<?php declare(strict_types=1);

namespace yii2\common\components\traits;

use Yii;
use Exception;
use yii\base\{ Model, InvalidConfigException };

/**
 * < Common > `Logger`
 *
 * @package yii2\common\components\trair
 */
trait Logger
{
    /**
     * @param string $method
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @throws InvalidConfigException
     *
     * @return void
     *
     */
    public function runtimeLogError(string $message, string $method, Model $model, array $data = []): void
    {
        $this->runtimeLogCore('error', $method, $message, $model, $data);
    }

    /**
     * @param string $method
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @throws InvalidConfigException
     *
     * @return void
     */
    public function runtimeLogInfo(string $method, string $message, Model $model, array $data = []): void
    {
        $this->runtimeLogCore('info', $method, $message, $model, $data);
    }

    /**
     * @param string $method
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @throws InvalidConfigException
     *
     * @return void
     */
    public function runtimeLogWarning(string $method, string $message, Model $model, array $data = []): void
    {
        $this->runtimeLogCore('warning', $method, $message, $model, $data);
    }

    /**
     * @param string $method
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @throws InvalidConfigException
     *
     * @return void
     */
    public function runtimeLogDebug(string $method, string $message, Model $model, array $data = []): void
    {
        $this->runtimeLogCore('debug', $method, $message, $model, $data);
    }

    /**
     * @param string $method
     * @param string $methodName
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @throws InvalidConfigException
     *
     * @return void
     */
    public function runtimeLogCore(string $method, string $methodName, string $message, Model $model, array $data = []): void
    {
        $log = [
            'method' => $methodName,
            'message' => $message,
            'errors' => $model->errors,
            'attributes' => $model->attributes,
        ];

        $log['data'] = $data;

        //Yii::error($log);
        Yii::{$method}($log);
    }

    /**
     * @param string $catch
     * @param Exception $e
     *
     * @return array
     */
    public function prepareException(string $catch, Exception $e): array
    {
        return [
            'catch' => $catch,
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ];
    }
}