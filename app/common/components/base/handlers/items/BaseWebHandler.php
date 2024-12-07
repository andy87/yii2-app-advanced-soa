<?php declare(strict_types=1);

namespace app\common\components\base\handlers\items;

use app\common\components\base\moels\items\source\SourceModel;
use Yii;
use Exception;
use Throwable;
use yii\base\InvalidConfigException;
use app\common\components\enums\Action;
use app\common\components\base\services\items\BaseService;
use app\common\components\handlers\items\PascalCaseHandler;
use app\common\components\base\resources\items\BaseTemplateResource;
use app\backend\components\resources\parents\crud\BackendFormResource;
use app\backend\components\resources\parents\crud\BackendViewResource;
use app\backend\components\resources\parents\crud\BackendIndexResource;
use app\backend\components\resources\parents\crud\BackendCreateResource;
use app\common\components\base\services\resources\crud\BaseFormResource;
use app\frontend\components\resources\parents\crud\FrontendViewResource;
use app\frontend\components\resources\parents\crud\FrontendFormResource;
use app\frontend\components\resources\parents\crud\FrontendIndexResource;
use app\frontend\components\resources\parents\crud\FrontendCreateResource;
use app\common\components\base\services\resources\crud\BaseListViewResource;
use app\common\components\base\services\resources\crud\BaseGridViewResource;
use app\common\components\base\services\resources\crud\BaseCrudViewResource;

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
        return (Yii::$app->request->isPost)
            ? (array) Yii::$app->request->bodyParams
            : [];
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
        /** @var BaseCrudViewResource|FrontendIndexResource|BackendIndexResource $R */
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
        /** @var BaseCrudViewResource|FrontendCreateResource|BackendCreateResource $R */
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
        /** @var BaseCrudViewResource|FrontendFormResource|BackendFormResource $R */
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
        /** @var BaseCrudViewResource|FrontendViewResource|BackendViewResource $R */
        $R = $this->getResources(Action::VIEW);

        $R->model = $this->service->getModel( $id, $this->service->settings->classForm );

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