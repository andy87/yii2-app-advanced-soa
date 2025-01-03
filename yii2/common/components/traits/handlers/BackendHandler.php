<?php declare(strict_types=1);

namespace common\components\traits\handlers;

use backend\resources\parents\crud\BackendCreateResource;
use backend\resources\parents\crud\BackendIndexResource;
use backend\resources\parents\crud\BackendUpdateResource;
use backend\resources\parents\crud\BackendViewResource;
use common\components\base\handlers\items\BaseWebHandler;
use common\components\base\resources\items\BaseTemplateResource;
use common\components\enums\Action;

/**
 * < Backend > Родительский класс для обработчиков контроллеров в окружения: `backend`
 *
 * @property \common\components\base\services\items\BaseService $service;
 *
 * @method BaseTemplateResource|BackendIndexResource|BackendViewResource|BackendCreateResource|BackendUpdateResource|string getResources(string $action)
 * @method BackendIndexResource processIndex(array $params)
 * @method BackendViewResource processViewForm(int $id)
 * @method BackendCreateResource processCreateForm(array $params = [], string $key = '')
 * @method BackendUpdateResource processUpdateForm(int $id, array $params)
 * @method int processDelete(int $id)
 *
 * @package yii2\backend\components\handlers\parents
 *
 * @tag: #abstract #backend #parent #handler
 */
abstract class BackendHandler extends BaseWebHandler
{
    /**
     * {@inheritDoc}
     *
     * @var array
     */
    public array $resources = [
        Action::INDEX => BackendIndexResource::class,
        Action::VIEW => BackendViewResource::class,
        Action::CREATE => BackendCreateResource::class,
        Action::UPDATE => BackendUpdateResource::class,
        null => BaseTemplateResource::class,
    ];
}