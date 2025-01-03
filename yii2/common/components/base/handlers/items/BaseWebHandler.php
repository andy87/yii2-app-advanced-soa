<?php declare(strict_types=1);

namespace common\components\base\handlers\items;

use backend\resources\parents\crud\BackendCreateResource;
use backend\resources\parents\crud\BackendFormResource;
use backend\resources\parents\crud\BackendIndexResource;
use backend\resources\parents\crud\BackendViewResource;
use common\handlers\items\PascalCaseHandler;
use Exception;
use frontend\resources\parents\crud\FrontendCreateResource;
use frontend\resources\parents\crud\FrontendFormResource;
use frontend\resources\parents\crud\FrontendIndexResource;
use frontend\resources\parents\crud\FrontendViewResource;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use common\components\base\resources\crud\BaseCrudViewResource;
use common\components\base\resources\crud\BaseFormResource;
use common\components\base\resources\crud\BaseGridViewResource;
use common\components\base\resources\crud\BaseListViewResource;
use common\components\base\resources\items\BaseTemplateResource;
use common\components\base\services\items\BaseService;
use common\components\enums\Action;

/**
 * < Common > Родительский абстрактный класс для всех Web обработчиков
 *
 * @property BaseService $service;
 *
 * @package app\common\components\base\handlers\itemse
 *
 * @tag: #abstract #common #handler #base
 */
abstract class BaseWebHandler extends PascalCaseHandler
{
    /**
     * Массив с ресурсами для контроллера
     *
     * Переопределяются в дочерних контроллерах согласно имени модели с которой работает контроллер
     *
     * @example Для модели `UserRole` работающей с таблицей `user_role`
     * ```php
     *  public const RESOURCES = [
     *       Action::INDEX => UserRoleGridViewResource::class,
     *       Action::VIEW => UserRoleViewResource::class,
     *       Action::CREATE => UserRoleCreateResource::class,
     *       Action::UPDATE => UserRoleUpdateResource::class,
     *  ];
     *
     * @var array
     */
    public array $resources = [];



    /**
     * @return array
     */
    public function getCreateParams(): array
    {
        return $this->getPostRequestParams();
    }

    /**
     * @return array
     */
    public function getUpdateParams(): array
    {
        return $this->getPostRequestParams();
    }

    /**
     * @return array
     */
    public function getPostRequestParams(): array
    {
        return (Yii::$app->request->isPost) ? (array) Yii::$app->request->bodyParams : [];
    }

    /**
     * @param string $action
     *
     * @return BaseTemplateResource|BaseGridViewResource|BaseListViewResource|BaseFormResource|string
     */
    public function getResources( string $action ): BaseTemplateResource|BaseGridViewResource|BaseListViewResource|BaseFormResource|string
    {
        $classResource = $this->resources[$action] ?? $this->resources[null];

        return new $classResource();
    }

    /**
     * @param array $params
     *
     * @return BaseGridViewResource|BaseListViewResource
     *
     * @throws InvalidConfigException
     */
    public function processIndex(array $params): BaseGridViewResource|BaseListViewResource
    {
        /** @var BaseCrudViewResource|FrontendIndexResource|\backend\resources\parents\crud\BackendIndexResource $R */
        $R = $this->getResources(Action::INDEX);

        $R->searchModel = $this->service->settings->classSearchModel;

        $R->activeDataProvider = $this->service->getDataProvider( $params );

        return $R;
    }

    /**
     * @param array $params
     * @param string $key
     *
     * @return BaseFormResource
     *
     * @throws Exception
     */
    public function processCreateForm(array $params = [], string $key = '' ): BaseFormResource
    {
        /** @var BaseCrudViewResource|\frontend\resources\parents\crud\FrontendCreateResource|BackendCreateResource $R */
        $R = $this->getResources(Action::CREATE);

        $R->form = $this->service->producer->formCreate();

        if (count($params) && $R->form->load($params, $key))
        {
            $R->form->save();
        }

        return $R;
    }

    /**
     * @param int $id
     * @param array $params
     *
     * @return BaseFormResource
     *
     * @throws Exception
     */
    public function processUpdateForm( int $id, array $params = [] ): BaseFormResource
    {
        /** @var BaseCrudViewResource|\frontend\resources\parents\crud\FrontendFormResource|\backend\resources\parents\crud\BackendFormResource $R */
        $R = $this->getResources(Action::UPDATE);

        $R->form = $this->service->repository->findForm($id);

        if ( count($params) ) {
            $R->form->load( $params );
        }

        return $R;
    }

    /**
     * @param int $id
     *
     * @return BaseCrudViewResource
     *
     * @throws InvalidConfigException|Exception
     */
    public function processViewForm(int $id): BaseCrudViewResource
    {
        /** @var BaseCrudViewResource|\frontend\resources\parents\crud\FrontendViewResource|\backend\resources\parents\crud\BackendViewResource $R */
        $R = $this->getResources(Action::VIEW);

        $R->model = $this->service->getModel( $id );

        return $R;
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws InvalidConfigException|Exception|Throwable
     */
    public function processDelete(int $id ): bool
    {
        return $this->service->deleteItemByCriteria(['id' => $id])?->delete();
    }
}