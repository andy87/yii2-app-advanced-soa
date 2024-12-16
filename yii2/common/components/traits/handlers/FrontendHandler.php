<?php declare(strict_types=1);

namespace yii2\common\components\traits\handlers;

use yii2\common\components\enums\Action;
use yii2\common\components\base\services\items\BaseService;
use yii2\common\components\base\resources\items\BaseTemplateResource;
use yii2\frontend\components\resources\parents\crud\FrontendCreateResource;
use yii2\frontend\components\resources\parents\crud\FrontendIndexResource;
use yii2\frontend\components\resources\parents\crud\FrontendUpdateResource;
use yii2\frontend\components\resources\parents\crud\FrontendViewResource;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property \yii2\common\components\base\services\items\BaseService $service
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