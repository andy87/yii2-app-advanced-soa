<?php declare(strict_types=1);

namespace backend\controllers\items;

use backend\handlers\items\PascalCaseHandler;
use backend\resources\items\PascalCaseCreateResource;
use backend\resources\items\PascalCaseViewResource;
use backend\components\controllers\parents\BackendController;
use common\components\enums\Action;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseHandler $handler
 *
 * @package app\backend\controllers\items
 *
 * @tag: #boilerplate #backend #controller #{{snake_case}}
 */
class PascalCaseController extends BackendController
{
    /** @var string Эндпоинт для URI */
    public const ENDPOINT = '{{kebab-case}}';

    /**
     * Массив с ресурсами
     *
     * @var array
     */
    protected array $resources = [
        Action::INDEX => \backend\resources\items\PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseViewResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => \backend\resources\items\PascalCaseUpdateResource::class,
    ];
}