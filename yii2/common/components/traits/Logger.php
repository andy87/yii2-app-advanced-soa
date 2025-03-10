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
    public function addLogError(string $message, string $method, Model $model, array $data = []): void
    {
        $this->writeLogOnModel('error', $method, $message, $model, $data);
    }

    /**
     * @param string $type
     * @param string $method_name
     * @param string $message
     * @param Model $model
     * @param array $data
     *
     * @return void
     *@throws InvalidConfigException
     *
     */
    public function writeLogOnModel(string $type, string $method_name, string $message, Model $model, array $data = []): void
    {
        $log = [
            'method' => $method_name,
            'message' => $message,
            'errors' => $model->errors,
            'attributes' => $model->attributes,
        ];

        if ( count($data) ) $log['data'] = $data;

        $this->writeLogCore($type, $log );
    }

    /**
     * @param string $type
     * @param array $log
     *
     * @throws InvalidConfigException
     *
     * @return void
     */
    public function writeLogCore( string $type,  array $log = []): void
    {
        $log = array_merge([
            'date'  => date('Y-m-d H:i:s'),
        ], $log);

        Yii::{$type}($log);
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
    public function addLogInfo(string $method, string $message, Model $model, array $data = []): void
    {
        $this->writeLogOnModel('info', $method, $message, $model, $data);
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
    public function addLogWarning(string $method, string $message, Model $model, array $data = []): void
    {
        $this->writeLogOnModel('warning', $method, $message, $model, $data);
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
    public function addLogDebug(string $method, string $message, Model $model, array $data = []): void
    {
        $this->writeLogOnModel('debug', $method, $message, $model, $data);
    }

    /**
     * @param string $method
     * @param Exception $e
     * @param array $data
     *
     * @return void
     *
     * @throws InvalidConfigException
     */
    public function addLogCatch(string $method, Exception $e, array $data = []): void
    {
        $log = $this->prepareException($method, $e);

        if ( count($data) ) $log['data'] = $data;

        $this->writeLogCore( $method, $log );
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