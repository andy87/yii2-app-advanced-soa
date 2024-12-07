<?php declare(strict_types=1);

namespace app\common\components\base\services\items;

use Exception;
use Throwable;
use yii\db\StaleObjectException;
use yii\db\Exception as DbException;
use app\common\components\interfaces\CatcherInterface;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\interfaces\services\ServiceInterface;
use app\common\components\base\producers\items\source\SourceProducer;
use app\common\components\base\services\items\settings\ServiceSettings;
use app\common\components\base\repository\items\source\SourceRepository;
use app\common\components\base\dataProviders\items\source\SourceActiveDataProvider;

/**
 * < Common > Базовый абстрактный класс для всех сервисов
 *
 * @property CatcherInterface $logger
 * @property SourceProducer $producer
 * @property SourceRepository $repository
 * @property SourceActiveDataProvider $dataProvider
 * @property ServiceSettings $settings
 *
 * @package app\common\components\base\services\items
 *
 * @tag: #abstract #common #service #base #items
 */
abstract class BaseService extends BaseToolKit implements ServiceInterface
{
    /**
     * @param array $params
     *
     * @return ?SourceModel
     *
     * @throws DbException
     */
    public function modelCreate( array $params ): ?SourceModel
    {
        return $this->producer->modelCreate( $params );
    }

    /**
     * @param array $params
     *
     * @return ?SourceModel
     *
     * @throws DbException
     */
    public function addModel( array $params ): ?SourceModel
    {
        return $this->producer->modelAdd( $params );
    }

    /**
     * @param SourceModel $model
     * @param mixed $params
     *
     * @return bool
     *
     * @throws DbException
     */
    public function modelUpdate( SourceModel $model, mixed $params ): bool
    {
        $model->load( $params, '' );

        return $model->save();
    }


    /**
     * @param array $params
     *
     * @return ?SourceModel
     *
     * @throws DbException
     */
    public function formCreate( array $params ): ?SourceModel
    {
        return $this->producer->formCreate( $params );
    }

    /**
     * @param array $params
     *
     * @return ?SourceModel
     *
     * @throws DbException
     */
    public function formAdd( array $params ): ?SourceModel
    {
        return $this->producer->formAdd( $params );
    }

    /**
     * @param SourceModel $form
     * @param mixed $params
     *
     * @return bool
     *
     * @throws DbException
     */
    public function formUpdate( SourceModel $form, mixed $params ): bool
    {
        $form->load( $params, '' );

        return $form->save();
    }

    /**
     * @param int $id
     *
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function getOne(int $id ): ?SourceModel
    {
        $query = $this->repository->find([ 'id' => $id ]);

        /** @var ?SourceModel $result */
        $result = $query->one($this->repository->connection);

        return $result;
    }

    /**
     * @param int $id
     *
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function getOneActive( int $id ): ?SourceModel
    {
        $query = $this->repository->findActive([ 'id' => $id ]);

        /** @var ?SourceModel $result */
        $result = $query->one($this->repository->connection);

        return $result;
    }

    /**
     * @param string|array $criteria
     *
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function getAll( string|array $criteria = [] ): ?SourceModel
    {
        $query = $this->repository->find($criteria);

        /** @var ?SourceModel $result */
        $result = $query->all($this->repository->connection);

        return $result;
    }

    /**
     * @param string|array $criteria
     *
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function getAllActive( string|array $criteria = [] ): ?SourceModel
    {
        $query = $this->repository->findActive($criteria);

        /** @var ?SourceModel $result */
        $result = $query->all($this->repository->connection);

        return $result;
    }

    /**
     * @param SourceModel $model
     *
     * @return ?int
     *
     * @throws StaleObjectException|Throwable
     */
    public function delete( SourceModel $model ): ?int
    {
        return $model->delete();
    }
}