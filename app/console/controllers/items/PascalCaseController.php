<?php declare(strict_types=1);

namespace app\console\controllers\items;

use app\console\models\items\PascalCase;
use app\console\models\forms\items\PascalCaseForm;
use app\console\models\search\items\PascalCaseSearch;
use app\console\components\services\items\PascalCaseService;
use app\console\components\handlers\items\PascalCaseHandler;
use app\console\components\producers\items\PascalCaseProducer;
use app\console\components\repository\items\PascalCaseRepository;
use app\common\components\base\handlers\items\settings\HandlerSettings;
use app\console\components\dataProviders\items\PascalCaseDataProvider;
use app\console\components\controllers\parents\ConsoleHandlerController;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseHandler $handler
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
        PascalCaseHandler::class,
        PascalCase::class,
        PascalCaseForm::class,
        PascalCaseSearch::class,
        PascalCaseDataProvider::class,
        PascalCaseService::class,
        PascalCaseProducer::class,
        PascalCaseRepository::class,
        [
            PascalCaseRepository::class => [
                PascalCase::class,
                PascalCaseForm::class
            ]
        ]
    ];
}