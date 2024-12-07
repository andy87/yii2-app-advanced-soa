<?php

namespace app\common\components\traits\handlers;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\base\services\items\BaseService;
use app\common\components\interfaces\handlers\HandlerInterface;
use app\common\components\base\services\items\settings\ServiceSettings;
use app\common\components\base\handlers\items\settings\HandlerSettings;

/**
 * Trait HasHandler
 *
 * @property HandlerInterface $handler
 *
 * @package app\common\components\traits\handler
 *
 * @tag: #trait #handler
 */
trait HasHandler
{
    /** @var ?HandlerInterface `Обработчик` */
    protected ?HandlerInterface $_handler;



    /**
     * @return HandlerInterface
     *
     * @throws InvalidConfigException
     */
    public function getHandler(): HandlerInterface
    {
        if ( !$this->_handler )
        {
            $this->_handler = $this->constructHandler();
        }

        return $this->_handler;
    }

    /**
     * @return HandlerInterface
     *
     * @throws InvalidConfigException
     */
    public function constructHandler(): HandlerInterface
    {
        $handlerSettings = $this->getHandlerSettings();

        /** @var BaseService $service */
        $service = Yii::createObject([
            'class' => $handlerSettings->classService,
            'settings' => new ServiceSettings(
                $handlerSettings->classModel,
                $handlerSettings->classForm,
                $handlerSettings->classSearchModel,
                $handlerSettings->classDataProvider,
                $handlerSettings->classService,
                $handlerSettings->classProducer,
                $handlerSettings->classRepository,
                [
                    $handlerSettings->classRepository => [
                        $handlerSettings->classModel,
                        $handlerSettings->classForm
                    ]
                ]
            )
        ]);

        /** @var HandlerInterface $handler */
        $handler = Yii::createObject($handlerSettings->classHandler,[
            $service
        ]);

        return $handler;
    }

    /**
     * @return HandlerSettings
     */
    abstract public function getHandlerSettings(): HandlerSettings;
}