<?php declare(strict_types=1);

namespace yii2\backend\controllers\items;

use yii2\common\components\enums\Action;
use yii2\backend\components\controllers\parents\BackendController;
use yii2\backend\components\resources\items\PascalCaseViewResource;
use yii2\backend\components\resources\items\PascalCaseIndexResource;
use yii2\backend\components\resources\items\PascalCaseCreateResource;
use yii2\backend\components\resources\items\PascalCaseUpdateResource;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property \yii2\backend\components\handlers\items\PascalCaseHandler $handler
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
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseViewResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
    ];
}