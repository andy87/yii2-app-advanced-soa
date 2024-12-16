<?php declare(strict_types=1);

namespace yii2\common\components\base\services\items;

use Exception;
use Throwable;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\db\Exception as DbException;
use yii2\common\components\interfaces\CatcherInterface;
use yii2\common\components\interfaces\services\ServiceInterface;
use yii2\common\components\base\producers\items\source\SourceProducer;
use yii2\common\components\base\services\items\settings\ServiceSettings;
use yii2\common\components\base\repository\items\source\SourceRepository;
use yii2\common\components\base\dataProviders\items\source\SourceActiveDataProvider;
use yii2\common\components\base\services\items\BaseToolKit;

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
     * @param int $page
     * @param int $perPage
     *
     * @return ActiveRecord[]
     *
     * @throws Exception
     */
    public function getList(int $page, int $perPage): array
    {
        $query = $this->repository->findModel();
        $query->limit($perPage)->offset(($page * $perPage));

        /** @var array $result */
        $result = $query->all($this->repository->connection);

        return $result;
    }

    /**
     * @param int $id
     *
     * @return ?ActiveRecord
     *
     * @throws Exception
     */
    public function getModel(int $id): ?ActiveRecord
    {
        $query = $this->repository->findModel([ 'id' => $id ]);

        /** @var ActiveRecord $result */
        $result = $query->one($this->repository->connection);

        return $result;
    }

    /**
     * @param array $params
     *
     * @return Model
     */
    public function createModel( array $params ): Model
    {
        return $this->producer->modelCreate( $params );
    }

    /**
     * @param array $params
     *
     * @return ?ActiveRecord
     *
     * @throws DbException
     */
    public function addModel( array $params ): ?ActiveRecord
    {
        return $this->producer->modelAdd( $params );
    }

    /**
     * @param ActiveRecord $activeRecord
     * @param mixed $params
     *
     * @return ?ActiveRecord
     *
     * @throws DbException
     */
    public function updateModel( ActiveRecord $activeRecord, mixed $params ): ?ActiveRecord
    {
        $activeRecord->load( $params, '' );

        return $activeRecord->save() ? $activeRecord : null;
    }



    /**
     * @param int $id
     *
     * @return ?ActiveRecord
     *
     * @throws Exception
     */
    public function getForm(int $id): ?ActiveRecord
    {
        $query = $this->repository->findForm($id);

        /** @var ?ActiveRecord $result */
        $result = $query->one($this->repository->connection);

        return $result;
    }

    /**
     * @param array $params
     *
     * @return Model
     */
    public function createForm(array $params ): Model
    {
        return $this->producer->formCreate( $params );
    }

    /**
     * @param array $params
     *
     * @return ActiveRecord
     *
     * @throws DbException
     */
    public function addForm(array $params ): ActiveRecord
    {
        return $this->producer->formAdd( $params );
    }

    /**
     * @param ActiveRecord $form
     * @param mixed $params
     *
     * @return ?ActiveRecord
     *
     * @throws DbException
     */
    public function updateForm(ActiveRecord $form, mixed $params ): ?ActiveRecord
    {
        $form->load( $params, '' );

        return $form->save() ? $form : null;
    }

    /**
     * @param int $id
     *
     * @return ?ActiveRecord
     *
     * @throws Exception
     */
    public function getActiveModel( int $id ): ?ActiveRecord
    {
        $query = $this->repository->findActive([ 'id' => $id ], $this->repository->modelClass );

        /** @var ?ActiveRecord $result */
        $result = $query->one($this->repository->connection);

        return $result;
    }

    /**
     * @param int $id
     *
     * @return ?ActiveRecord
     *
     * @throws Exception
     */
    public function getActiveForm( int $id ): ?ActiveRecord
    {
        $query = $this->repository->findActive([ 'id' => $id ], $this->repository->formClass );

        /** @var ?ActiveRecord $result */
        $result = $query->one($this->repository->connection);

        return $result;
    }

    /**
     * @param string|array $criteria
     *
     * @return ?ActiveRecord
     *
     * @throws Exception
     */
    public function getAllModels( string|array $criteria = [] ): ?ActiveRecord
    {
        $query = $this->repository->findByModel( $this->repository->modelClass, $criteria );

        /** @var ?ActiveRecord $result */
        $result = $query->all($this->repository->connection);

        return $result;
    }

    /**
     * @param string|array $criteria
     *
     * @return ?ActiveRecord
     *
     * @throws Exception
     */
    public function getAllForms( string|array $criteria = [] ): ?ActiveRecord
    {
        $query = $this->repository->findByModel( $this->repository->formClass, $criteria );

        /** @var ?ActiveRecord $result */
        $result = $query->all($this->repository->connection);

        return $result;
    }

    /**
     * @param string|array $criteria
     *
     * @return ?ActiveRecord
     *
     * @throws Exception
     */
    public function getAllActiveModels( string|array $criteria = [] ): ?ActiveRecord
    {
        $query = $this->repository->findActive( $criteria, $this->repository->modelClass );

        /** @var ?ActiveRecord $result */
        $result = $query->all($this->repository->connection);

        return $result;
    }

    /**
     * @param string|array $criteria
     *
     * @return ?ActiveRecord
     *
     * @throws Exception
     */
    public function getAllActiveForms( string|array $criteria = [] ): ?ActiveRecord
    {
        $query = $this->repository->findActive( $criteria, $this->repository->formClass );

        /** @var ?ActiveRecord $result */
        $result = $query->all($this->repository->connection);

        return $result;
    }

    /**
     * @param ActiveRecord $model
     *
     * @return ?int
     *
     * @throws StaleObjectException|Throwable
     */
    public function delete( ActiveRecord $model ): ?int
    {
        return $model->delete();
    }
}