<?php declare(strict_types=1);

namespace app\common\components\traits;

use Yii;
use yii\base\{ Model, InvalidConfigException };

/**
 * < Common > `Logger`
 *
 * @package app\common\components\trair
 */
trait Logger
{
    /** @var string $runtimeLogError */
    public string $runtimeLogError = 'error';

    /** @var string $runtimeLogInfo */
    public string $runtimeLogInfo = 'info';

    /** @var string $runtimeLogWarning */
    public string $runtimeLogWarning = 'warning';

    /** @var string $runtimeLogDebug */
    public string $runtimeLogDebug = 'debug';


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
     * @throws InvalidConfigException
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
     * @throws InvalidConfigException
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
     * @throws InvalidConfigException
     *
     * @return void
     */
    public function runtimeLogDebug(string $method, string $message, Model $model, array $data = []): void
    {
        $this->runtimeLogCore($this->runtimeLogDebug, $method, $message, $model, $data);
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

        //print_r([__METHOD__ . '(' . __LINE__ . ')', $log ]);die;

        Yii::{$method}($log);
    }
}