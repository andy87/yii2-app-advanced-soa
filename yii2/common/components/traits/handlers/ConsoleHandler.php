<?php declare(strict_types=1);

namespace common\components\traits\handlers;

use console\services\items\PascalCaseService;
use Exception;
use Throwable;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use console\models\forms\items\PascalCaseForm;
use console\models\items\PascalCase;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property PascalCaseService $service
 *
 * @package yii2\console\components\handlers\parents
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
     * @throws Exception
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
     * @throws Exception
     */
    public function processModelUpdate(int $id, array $params ): ?PascalCase
    {
        $service = $this->service;

        if ( $model = $service->getModel($id) )
        {
            return $service->updateModel( $model, $params );
        }

        return null;
    }

    /**
     * @param array $params
     *
     * @return ?\yii2\common\models\forms\items\PascalCaseForm
     *
     */
    public function processFormCreate( array $params ): ?PascalCaseForm
    {
        return $this->service->createForm( $params );
    }

    /**
     * @param array $params
     *
     * @return PascalCaseForm
     *
     * @throws Exception
     */
    public function processFormAdd(array $params ): PascalCaseForm
    {
        return $this->service->addForm( $params );
    }

    /**
     * @param int $id
     * @param array $params
     *
     * @return ?PascalCaseForm
     *
     * @throws Exception
     */
    public function processFormUpdate(int $id, array $params ): ?PascalCaseForm
    {
        $service = $this->service;

        if ( $model = $service->getForm($id) )
        {
            return $service->updateForm( $model, $params );
        }

        return null;
    }

    /**
     * @param int $id
     * @param ?PascalCase|string $classModel
     *
     * @return ?int
     *
     * @throws StaleObjectException|Throwable
     */
    public function processDelete( int $id, PascalCase|string|null $classModel = null ): ?int
    {
        $service = $this->service;
        $repository = $service->repository;

        /** @var ActiveRecord $classModel  */
        $classModel = $classModel ?? $service->settings->classModel; //TODO: refactor this

        $query = $repository->findByModel( $classModel, $id );

        if ( $model = $query->one($repository->connection) )
        {
            return (int) $model->delete();
        }

        return null;
    }

    /**
     * @param int $id
     *
     * @return ?PascalCase
     */
    public function processViewModel(int $id): ?PascalCase
    {
        $service = $this->service;
        $repository = $service->repository;

        $query = $repository->findByModel( $service->settings->classModel, $id );

        /** @var ?PascalCase $model */
        if ( $model = $query->one($repository->connection) )
        {
            return $model;
        }

        return null;
    }

    /**
     * @param int $id
     *
     * @return ?PascalCaseForm
     */
    public function processViewForm(int $id): ?PascalCaseForm
    {
        $service = $this->service;
        $repository = $service->repository;

        $query = $repository->findByModel( $service->settings->classForm, $id );

        /** @var ?PascalCaseForm $model */
        if ( $model = $query->one($repository->connection) )
        {
            return $model;
        }

        return null;
    }
}