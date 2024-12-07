<?php

namespace app\common\components\traits\services;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\system\Manager;
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
    /** @var BaseService $service */
    protected BaseService $service;



    /**
     * @return void
     *
     * @throws InvalidConfigException
     */
    public function setupService(): void
    {
        $this->service = $this->constructService();
    }

    /**
     * @return BaseService
     *
     * @throws InvalidConfigException
     */
    public function constructService(): BaseService
    {
        $serviceSettings = $this->getServiceSettings();

        $serviceConfig = [
            'class' => $serviceSettings->classService,
            'configProducer' => [
                ['class' => $serviceSettings->classProducer],
                [
                    new Manager($serviceSettings->classModel),
                    new Manager($serviceSettings->classForm)
                ]
            ],
            'configRepository' => [
                'class' => $serviceSettings->classRepository,
                'modelClass' => $serviceSettings->classModel
            ],
            'configDataProvider' => [
                'class' => $serviceSettings->classDataProvider,
                'modelClass' => $serviceSettings->classModel
            ],
        ];

        /** @var BaseService $service */
        $service = Yii::createObject( $serviceConfig );

        return $service;
    }

    /**
     * @return ServiceSettings
     */
    abstract public function getServiceSettings(): ServiceSettings;
}