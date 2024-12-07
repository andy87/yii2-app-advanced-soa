<?php

namespace app\common\components\traits\handlers;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\base\handlers\items\source\SourceHandler;
use app\common\components\base\handlers\items\settings\HandlerSettings;

/**
 * Trait HasHandler
 *
 * @package app\common\components\traits\handler
 *
 * @tag: #trait #handler
 */
trait HasHandler
{
    /** @var ?SourceHandler `Обработчик` */
    protected ?SourceHandler $_handler = null;



    /**
     * @return SourceHandler
     *
     * @throws InvalidConfigException
     */
    public function getHandler(): SourceHandler
    {
        if ( !$this->_handler )
        {
            $this->_handler = $this->constructHandler();
        }

        return $this->_handler;
    }

    /**
     * @return SourceHandler
     *
     * @throws InvalidConfigException
     */
    public function constructHandler(): SourceHandler
    {
        $handlerSettings = $this->getHandlerSettings();

        /** @var SourceHandler $handler */
        $handler = Yii::createObject($handlerSettings->classHandler);

        return $handler;
    }

    /**
     * @return HandlerSettings
     */
    abstract public function getHandlerSettings(): HandlerSettings;
}