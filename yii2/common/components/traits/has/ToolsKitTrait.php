<?php

namespace common\components\traits\has;

use Yii;
use yii\base\InvalidConfigException;
use common\components\system\Manager;
use common\components\base\producers\items\source\SourceProducer;
use common\components\base\repository\items\source\SourceRepository;
use common\components\base\services\items\settings\ServiceSettings;

/**
 * Trait ToolsKit
 *
 * @property-read SourceProducer $producer
 * @property-read SourceRepository $repository
 *
 * @package yii2\common\components\traits
 *
 * @tag #common #trait #singleton
 */
trait ToolsKitTrait
{

    /** @var ServiceSettings */
    public ServiceSettings $settings;


    /** @var ?SourceProducer */
    protected ?SourceProducer $_producer = null;

    /** @var ?SourceRepository */
    protected ?SourceRepository $_repository = null;



    /**
     * Magic method for getting properties `producer`
     *
     * P.S. Что бы собирать объект именно во время вызова, а не во время объявления
     *
     * @return SourceProducer
     *
     * @throws InvalidConfigException
     */
    public function getProducer(): SourceProducer
    {
        if ( !$this->_producer )
        {
            if (isset($this->settings->config[$this->settings->classProducer]))
            {
                $params = $this->settings->config[$this->settings->classProducer];

            } else {

                $params = [];

                if ( $this->settings->classModel ) {
                    $params[] = new Manager($this->settings->classModel);
                }

                if ( $this->settings->classForm ) {
                    $params[] = new Manager($this->settings->classForm);
                }
            }

            /** @var SourceProducer $_producer */
            $_producer = Yii::createObject([ 'class' => $this->settings->classProducer ], $params );

            $this->_producer = $_producer;
        }

        return $this->_producer;
    }

    /**
     * Magic method for getting properties `repository`
     *
     * P.S. Что бы собирать объект именно во время вызова, а не во время объявления
     *
     * @return SourceRepository
     *
     * @throws InvalidConfigException
     */
    public function getRepository(): SourceRepository
    {
        if ( !$this->_repository )
        {
            /** @var SourceRepository $_repository */
            $_repository = Yii::createObject(
                [ 'class' => $this->settings->classRepository ],
                $this->settings->config[$this->settings->classRepository] ?? []
            );

            $this->_repository = $_repository;
        }

        return $this->_repository;
    }
}