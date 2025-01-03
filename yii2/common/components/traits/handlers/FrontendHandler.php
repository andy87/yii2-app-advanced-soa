<?php declare(strict_types=1);

namespace yii2\common\components\traits\handlers;

use frontend\resources\parents\crud\FrontendCreateResource;
use frontend\resources\parents\crud\FrontendIndexResource;
use frontend\resources\parents\crud\FrontendUpdateResource;
use frontend\resources\parents\crud\FrontendViewResource;
use yii2\common\components\base\resources\items\BaseTemplateResource;
use yii2\common\components\base\services\items\BaseService;
use yii2\common\components\enums\Action;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property BaseService $service
 * @method BaseTemplateResource|FrontendIndexResource|FrontendViewResource|FrontendCreateResource|FrontendUpdateResource|string getResources(string $action)
 * @method FrontendIndexResource processIndex(array $params)
 * @method FrontendViewResource processViewForm(int $id)
 * @method FrontendCreateResource processCreateForm(array $params = [], string $key = '')
 * @method FrontendUpdateResource processUpdateForm(int $id, array $params)
 * @method int processDelete(int $id)
 *
 * @package app\frontend\components\handlers\parents
 *
 * @tag: #abstract #frontend #parent #handler
 */
trait FrontendHandler
{
    /**
     * @var array
     */
    public array $resources = [
        Action::INDEX => FrontendIndexResource::class,
        Action::VIEW => FrontendViewResource::class,
        Action::CREATE => FrontendCreateResource::class,
        Action::UPDATE => FrontendUpdateResource::class,
        null => BaseTemplateResource::class,
    ];
}