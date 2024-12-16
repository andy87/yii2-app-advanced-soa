<?php declare(strict_types=1);

namespace yii2\common\components\base\handlers\items;

use yii2\common\components\base\models\items\sources\SourceModel;
use Yii;
use Exception;
use Throwable;
use yii\base\InvalidConfigException;
use yii2\common\components\enums\Action;
use yii2\common\components\base\services\items\BaseService;
use yii2\common\components\handlers\items\PascalCaseHandler;
use yii2\common\components\base\resources\items\BaseTemplateResource;
use yii2\backend\components\resources\parents\crud\BackendFormResource;
use yii2\backend\components\resources\parents\crud\BackendViewResource;
use yii2\backend\components\resources\parents\crud\BackendIndexResource;
use yii2\backend\components\resources\parents\crud\BackendCreateResource;
use yii2\common\components\base\resources\crud\BaseFormResource;
use yii2\frontend\components\resources\parents\crud\FrontendViewResource;
use yii2\frontend\components\resources\parents\crud\FrontendFormResource;
use yii2\frontend\components\resources\parents\crud\FrontendIndexResource;
use yii2\frontend\components\resources\parents\crud\FrontendCreateResource;
use yii2\common\components\base\resources\crud\BaseListViewResource;
use yii2\common\components\base\resources\crud\BaseGridViewResource;
use yii2\common\components\base\resources\crud\BaseCrudViewResource;

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
     * @return BaseTemplateResource|\yii2\common\components\base\resources\crud\BaseGridViewResource|\yii2\common\components\base\resources\crud\BaseListViewResource|\yii2\common\components\base\resources\crud\BaseFormResource|string
     */
    public function getResources( string $action ): BaseTemplateResource|BaseGridViewResource|BaseListViewResource|BaseFormResource|string
    {
        $classResource = $this->resources[$action] ?? $this->resources[null];

        return new $classResource();
    }

    /**
     * @param array $params
     *
     * @return BaseGridViewResource|\yii2\common\components\base\resources\crud\BaseListViewResource
     *
     * @throws InvalidConfigException
     */
    public function processIndex(array $params): BaseGridViewResource|BaseListViewResource
    {
        /** @var BaseCrudViewResource|\yii2\frontend\components\resources\parents\crud\FrontendIndexResource|BackendIndexResource $R */
        $R = $this->getResources(Action::INDEX);

        $R->searchModel = $this->service->settings->classSearchModel;

        $R->activeDataProvider = $this->service->getDataProvider( $params );

        return $R;
    }

    /**
     * @param array $params
     * @param string $key
     *
     * @return \yii2\common\components\base\resources\crud\BaseFormResource
     *
     * @throws Exception
     */
    public function processCreateForm(array $params = [], string $key = '' ): BaseFormResource
    {
        /** @var BaseCrudViewResource|\yii2\frontend\components\resources\parents\crud\FrontendCreateResource|BackendCreateResource $R */
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
     * @return \yii2\common\components\base\resources\crud\BaseFormResource
     *
     * @throws Exception
     */
    public function processUpdateForm( int $id, array $params = [] ): BaseFormResource
    {
        /** @var BaseCrudViewResource|\yii2\frontend\components\resources\parents\crud\FrontendFormResource|BackendFormResource $R */
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
        /** @var BaseCrudViewResource|\yii2\frontend\components\resources\parents\crud\FrontendViewResource|BackendViewResource $R */
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