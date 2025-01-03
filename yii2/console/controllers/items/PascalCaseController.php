<?php declare(strict_types=1);

namespace yii2\console\controllers\items;

use console\dataProviders\items\PascalCaseDataProvider;
use yii2\common\components\base\handlers\items\settings\HandlerSettings;
use yii2\console\components\controllers\parents\ConsoleHandlerController;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property \console\handlers\items\PascalCaseHandler $handler
 * @property HandlerSettings|string $handlerSetups
 *
 * @method int actionList(int $page = 1, int $limit = 10)
 * @method int actionModelAdd(string $json)
 * @method int actionModelView(int $id)
 * @method int actionModelUpdate(int $id, string $json)
 * @method int actionDelete(int $id)
 *
 * @package app\console\controllers\items
 *
 * @tag: #boilerplate #console #controller #{{snake_case}}
 */
class PascalCaseController extends ConsoleHandlerController
{
    public array $serviceSettings = [
        \console\handlers\items\PascalCaseHandler::class,
        \yii2\console\models\items\PascalCase::class,
        \yii2\console\models\forms\items\PascalCaseForm::class,
        \yii2\console\models\search\items\PascalCaseSearch::class,
        PascalCaseDataProvider::class,
        \console\services\items\PascalCaseService::class,
        \console\producers\items\PascalCaseProducer::class,
        \console\repository\items\PascalCaseRepository::class,
        [
            \console\repository\items\PascalCaseRepository::class => [
                \yii2\console\models\items\PascalCase::class,
                \yii2\console\models\forms\items\PascalCaseForm::class
            ]
        ]
    ];
}