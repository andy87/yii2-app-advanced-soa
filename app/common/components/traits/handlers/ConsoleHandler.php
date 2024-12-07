<?php declare(strict_types=1);

namespace app\common\components\traits\handlers;

use Throwable;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\StaleObjectException;
use app\console\models\items\PascalCase;
use app\console\models\forms\items\PascalCaseForm;
use app\console\components\services\items\PascalCaseService;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property PascalCaseService $service
 *
 * @package app\console\components\handlers\parents
 *
 * @tag: #abstract #console #parent #boilerplate #handler
 */
Trait ConsoleHandler
{
    /**
     * @param int $page
     * @param int $perPage
     *
     * @return PascalCase[]
     *
     * @throws \Exception
     */
    public function processList( int $page, int $perPage ): array
    {
        return $this->service->getList( ($page - 1), $perPage );
    }

    /**
     * @param array $params
     *
     * @return PascalCase
     */
    public function processModelCreate( array $params ): PascalCase
    {
        return $this->service->createModel( $params );
    }

    /**
     * @param array $params
     *
     * @return ?PascalCase
     *
     * @throws Exception
     */
    public function processModelAdd( array $params ): ?PascalCase
    {
        return $this->service->addModel( $params );
    }

    /**
     * @param int $id
     * @param array $params
     *
     * @return ?PascalCase
     *
     * @throws \Exception
     */
    public function processModelUpdate(int $id, array $params ): ?PascalCase
    {
        if ( $model = $this->service->getModel($id) )
        {
            return $this->service->updateModel( $model, $params );
        }

        return null;
    }

    /**
     * @param array $params
     *
     * @return ?\app\common\models\forms\items\PascalCaseForm
     *
     */
    public function processFormCreate( array $params ): ?PascalCaseForm
    {
        return $this->service->createForm( $params );
    }

    /**
     * @param array $params
     *
     * @return ActiveRecord
     *
     * @throws Exception
     */
    public function processFormAdd(array $params ): ActiveRecord
    {
        return $this->service->addForm( $params );
    }

    /**
     * @param int $id
     * @param array $params
     *
     * @return ?ActiveRecord
     *
     * @throws \Exception
     */
    public function processFormUpdate(int $id, array $params ): ?ActiveRecord
    {
        if ( $model = $this->service->getForm($id) )
        {
            return $this->service->updateForm( $model, $params );
        }

        return null;
    }

    /**
     * @param int $id
     * @param ?ActiveRecord|string $classModel
     *
     * @return ?int
     *
     * @throws StaleObjectException|Throwable
     */
    public function processDelete( int $id, ActiveRecord|string|null $classModel = null ): ?int
    {
        $classModel = $classModel ?? $this->service->settings->classModel;

        $query = $this->service->repository->findByModel( $classModel, $id );

        if ( $model = $query->one($this->service->repository->connection) )
        {
            return (int) $model->delete();
        }

        return null;
    }

    /**
     * @param int $id
     *
     * @return ?ActiveRecord
     */
    public function processViewModel(int $id): ?ActiveRecord
    {
        $query = $this->service->repository->findByModel( $this->service->settings->classModel, $id );

        if ( $model = $query->one($this->service->repository->connection) )
        {
            return $model;
        }

        return null;
    }

    /**
     * @param int $id
     *
     * @return ?ActiveRecord
     */
    public function processViewForm(int $id): ?ActiveRecord
    {
        $query = $this->service->repository->findByModel( $this->service->settings->classForm, $id );

        if ( $model = $query->one($this->service->repository->connection) )
        {
            return $model;
        }

        return null;
    }
}