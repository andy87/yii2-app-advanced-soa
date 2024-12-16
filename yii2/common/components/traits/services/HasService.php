<?php

namespace yii2\common\components\traits\services;

use Yii;
use yii\base\InvalidConfigException;
use yii2\common\components\base\services\items\BaseService;
use yii2\common\components\base\services\items\settings\ServiceSettings;

/**
 * Trait HasService
 *
 * @property \yii2\common\components\base\services\items\BaseService $service
 *
 * @package app\common\components\traits\services
 *
 * @tag: #trait #service
 */
trait HasService
{
    /** @var ?\yii2\common\components\base\services\items\BaseService $_service */
    protected ?BaseService $_service = null;



    /**
     * @return \yii2\common\components\base\services\items\BaseService
     *
     * @throws InvalidConfigException
     */
    public function getService(): BaseService
    {
        if ( !$this->_service )
        {
            $this->_service = $this->constructService();
        }

        return $this->_service;
    }

    /**
     * @return \yii2\common\components\base\services\items\BaseService
     *
     * @throws InvalidConfigException
     */
    public function constructService(): BaseService
    {
        $serviceSettings = $this->getServiceSettings();

        /** @var \yii2\common\components\base\services\items\BaseService $service */
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