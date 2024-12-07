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
     * @param int $id
     *
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function getModel(int $id): ?SourceModel
    {
        $query = $this->repository->find([ 'id' => $id ]);

        /** @var SourceModel $result */
        $result = $query->one($this->repository->connection);

        return $result;
    }

    /**
     * @param array $params
     *
     * @return ?SourceModel
     *
     * @throws DbException
     */
    public function createModel(array $params ): ?SourceModel
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
    public function updateModel( SourceModel $model, mixed $params ): bool
    {
        $model->load( $params, '' );

        return $model->save();
    }



    /**
     * @param int $id
     *
     * @return ?SourceModel
     *
     * @throws Exception
     */
    public function getForm(int $id): ?SourceModel
    {
        $query = $this->repository->findForm($id);

        /** @var ?SourceModel $result */
        $result = $query->one($this->repository->connection);

        return $result;
    }

    /**
     * @param array $params
     *
     * @return ?SourceModel
     *
     * @throws DbException
     */
    public function createForm(array $params ): ?SourceModel
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
    public function addForm(array $params ): ?SourceModel
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
    public function updateForm(SourceModel $form, mixed $params ): bool
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
    public function getActiveModel( int $id ): ?SourceModel
    {
        $query = $this->repository->findActive([ 'id' => $id ], $this->repository->modelClass );

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
    public function getActiveForm( int $id ): ?SourceModel
    {
        $query = $this->repository->findActive([ 'id' => $id ], $this->repository->formClass );

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
    public function getAllModels( string|array $criteria = [] ): ?SourceModel
    {
        $query = $this->repository->findCustom( $this->repository->modelClass, $criteria );

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
    public function getAllForms( string|array $criteria = [] ): ?SourceModel
    {
        $query = $this->repository->findCustom( $this->repository->formClass, $criteria );

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
    public function getAllActiveModels( string|array $criteria = [] ): ?SourceModel
    {
        $query = $this->repository->findActive( $criteria, $this->repository->modelClass );

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
    public function getAllActiveForms( string|array $criteria = [] ): ?SourceModel
    {
        $query = $this->repository->findActive( $criteria, $this->repository->formClass );

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