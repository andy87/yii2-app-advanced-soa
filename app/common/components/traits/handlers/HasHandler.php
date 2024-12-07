<?php

namespace app\common\components\traits\handlers;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\system\Manager;
use app\common\components\base\services\items\BaseService;
use app\console\components\handlers\parents\ConsoleHandler;
use app\common\components\base\handlers\items\settings\HandlerSettings;

/**
 * Trait HasHandler
 *
 * @property ConsoleHandler $handler
 *
 * @package app\common\components\traits\handler
 *
 * @tag: #trait #handler
 */
trait HasHandler
{
    /** @var ConsoleHandler `Обработчик` */
    protected ConsoleHandler $handler;


    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    public function setupHandler(): void
    {
        $this->handler = $this->constructHandler();
    }

    /**
     * @return ConsoleHandler
     *
     * @throws InvalidConfigException
     */
    public function constructHandler(): ConsoleHandler
    {
        $handlerSetups = $this->getHandlerSettings();

        $serviceConfig = [
            'class' => $handlerSetups->classService,
            'configProducer' => [
                ['class' => $handlerSetups->classProducer],
                [
                    new Manager($handlerSetups->classModel),
                    new Manager($handlerSetups->classForm)
                ]
            ],
            'configRepository' => [
                'class' => $handlerSetups->classRepository,
                'modelClass' => $handlerSetups->classModel
            ],
            'configDataProvider' => [
                'class' => $handlerSetups->classDataProvider,
                'modelClass' => $handlerSetups->classModel
            ],
        ];

        /** @var BaseService $service */
        $service = Yii::createObject( $serviceConfig );

        /** @var ConsoleHandler $handler */
        $handler = Yii::createObject($handlerSetups,[
            $service
        ]);

        return $handler;
    }

    /**
     * @return HandlerSettings
     */
    abstract public function getHandlerSettings(): HandlerSettings;
}