<?php

namespace yii2\common\components\traits\has;

use Yii;
use yii\base\InvalidConfigException;
use yii2\common\components\base\handlers\items\settings\HandlerSettings;
use yii2\common\components\base\handlers\items\source\SourceHandler;

/**
 * Trait HasHandler
 *
 * @package app\common\components\traits\handler
 *
 * @tag: #trait #handler
 */
trait HasHandlerTrait
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