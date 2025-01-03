<?php declare(strict_types=1);

namespace backend\controllers\items;

use common\components\enums\Action;
use common\models\items\PascalCase;
use backend\handlers\items\PascalCaseHandler;
use backend\resources\items\PascalCaseViewResource;
use backend\resources\items\PascalCaseIndexResource;
use backend\resources\items\PascalCaseCreateResource;
use backend\resources\items\PascalCaseUpdateResource;
use backend\components\controllers\parents\BackendController;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseHandler $handler
 *
 * @package yii2\backend\controllers\items
 *
 * @tag: #boilerplate #backend #controller #{{snake_case}}
 */
class PascalCaseController extends BackendController
{
    /** @var string Эндпоинт для URI */
    public const string ENDPOINT = '{{kebab-case}}';

    /**
     *
     */
    public const array LABELS = [
        Action::INDEX => PascalCase::PLURAL,
        Action::CREATE => 'Создание ' . PascalCase::SINGULAR,
        Action::UPDATE => 'Редактирование ' . PascalCase::SINGULAR,
        Action::UPDATE => 'Просмотр ' . PascalCase::SINGULAR,
    ];


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