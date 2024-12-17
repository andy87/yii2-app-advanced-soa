<?php

namespace yii2\common\components\traits\services;

use Yii;
use yii\base\InvalidConfigException;
use yii2\common\components\base\services\items\source\SourceToolKit;
use yii2\common\components\base\services\items\settings\ServiceSettings;

/**
 * Trait HasService
 *
 * @property SourceToolKit $service
 *
 * @package app\common\components\traits\services
 *
 * @tag: #trait #service
 */
trait HasService
{
    /** @var ?SourceToolKit $_service */
    protected ?SourceToolKit $_service = null;



    /**
     * @return SourceToolKit
     *
     * @throws InvalidConfigException
     */
    public function getService(): SourceToolKit
    {
        if ( !$this->_service )
        {
            $this->_service = $this->constructService();
        }

        return $this->_service;
    }

    /**
     * @return SourceToolKit
     *
     * @throws InvalidConfigException
     */
    public function constructService(): SourceToolKit
    {
        $serviceSettings = $this->getServiceSettings();

        /** @var SourceToolKit $service */
        $service = Yii::createObject([
            'class' => $serviceSettings->classService,
            'settings' => $serviceSettings
        ]);

        return $service;
    }

    /**
     * @return ServiceSettings
     */
    abstract public function getServiceSettings(): ServiceSettings;
}