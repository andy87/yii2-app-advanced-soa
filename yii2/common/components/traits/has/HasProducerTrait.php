<?php

namespace common\components\traits\has;

use Yii;
use yii\base\InvalidConfigException;
use common\components\base\producers\items\source\SourceProducer;

/**
 * Trait HasHandler
 *
 * @property-read SourceProducer $producer
 *
 * @package yii2\common\components\traits\handler
 *
 * @tag: #trait #handler
 */
trait HasProducerTrait
{
    /** @var ?SourceProducer `Обработчик` */
    protected ?SourceProducer $_producer = null;



    /**
     * @return SourceProducer
     *
     * @throws InvalidConfigException
     */
    public function getProducer(): SourceProducer
    {
        if ( !$this->_producer )
        {
            $this->_producer = $this->constructHandler();
        }

        return $this->_producer;
    }

    /**
     * @return SourceProducer
     *
     * @throws InvalidConfigException
     */
    public function constructHandler(): SourceProducer
    {
        $producerSettings = $this->getProducerSettings();

        /** @var SourceProducer $producer */
        $producer = Yii::createObject($producerSettings);

        return $producer;
    }

    /**
     * @return array
     */
    abstract public function getProducerSettings(): array;
}