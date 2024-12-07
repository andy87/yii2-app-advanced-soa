<?php declare(strict_types=1);

namespace app\common\components\traits\handlers;

use app\common\components\enums\Action;
use app\common\components\base\services\items\BaseService;
use app\common\components\base\resources\items\BaseTemplateResource;
use app\frontend\components\resources\parents\crud\FrontendCreateResource;
use app\frontend\components\resources\parents\crud\FrontendIndexResource;
use app\frontend\components\resources\parents\crud\FrontendUpdateResource;
use app\frontend\components\resources\parents\crud\FrontendViewResource;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property BaseService $service
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