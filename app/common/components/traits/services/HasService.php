<?php

namespace app\common\components\traits\services;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\base\services\items\BaseService;
use app\common\components\base\services\items\settings\ServiceSettings;

/**
 * Trait HasService
 *
 * @property BaseService $service
 *
 * @package app\common\components\traits\services
 *
 * @tag: #trait #service
 */
trait HasService
{
    /** @var ?BaseService $_service */
    protected ?BaseService $_service = null;



    /**
     * @return BaseService
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
     * @return BaseService
     *
     * @throws InvalidConfigException
     */
    public function constructService(): BaseService
    {
        $serviceSettings = $this->getServiceSettings();

        /** @var BaseService $service */
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