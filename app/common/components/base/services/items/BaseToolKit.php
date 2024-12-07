<?php declare(strict_types=1);

namespace app\common\components\base\services\items;

use Yii;
use yii\base\InvalidConfigException;
use app\common\components\system\Manager;
use app\common\components\interfaces\CatcherInterface;
use app\common\components\interfaces\models\SearchModelInterface;
use app\common\components\base\services\items\source\SourceToolKit;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\services\items\settings\ServiceSettings;
use app\common\components\base\repository\items\source\SourceRepository;
use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common > Базовый абстрактный класс для всех сервисов
 *      использующих BaseModel
 *      требует установки провайдера и репозитория
 *
 * @property CatcherInterface $logger
 * @property SourceProducer $producer - получение объекта происходит через магический метод __get -> getProducer()
 * @property SourceRepository $repository - получение объекта происходит через магический метод __get -> getRepository()
 * @property SourceActiveDataProvider $dataProvider - получение объекта происходит через магический метод __get -> getDataProvider()
 *
 * @package app\common\components\base\services
 *
 * @tag: #abstract #common #service #base #items
 */
abstract class BaseToolKit extends SourceToolKit
{
    /** @var ServiceSettings */
    public ServiceSettings $settings;



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

                if ( $this->settings->classModel ) $params[] = new Manager($this->settings->classModel);

                if ( $this->settings->classForm ) $params[] = new Manager($this->settings->classForm);
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

    /**
     * Magic method for getting properties `dataProvider`
     *
     * P.S. Что бы собирать объект именно во время вызова, а не во время объявления
     *
     * @param array|null $queryParams
     *
     * @return SourceActiveDataProvider
     *
     * @throws InvalidConfigException
     */
    public function getDataProvider( ?array $queryParams = null ): SourceActiveDataProvider
    {
        if ($this->settings->classSearchModel)
        {
            if ( !$this->_dataProvider )
            {
                /** @var SearchModelInterface $searchModel */
                $searchModel = new $this->settings->classSearchModel();

                $_dataProvider = $searchModel->search( $queryParams ?? Yii::$app->request->queryParams );

                $this->_dataProvider = $_dataProvider;
            }

            return $this->_dataProvider;
        }

        throw new InvalidConfigException('Property `classSearchModel` is not set in the settings');
    }
}