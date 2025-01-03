<?php declare(strict_types=1);

namespace console\handlers\items;

use console\models\items\PascalCase;
use console\services\items\PascalCaseService;
use console\models\forms\items\PascalCaseForm;
use console\producers\items\PascalCaseProducer;
use console\models\search\items\PascalCaseSearch;
use console\repository\items\PascalCaseRepository;
use common\components\traits\handlers\ConsoleHandler;
use console\dataProviders\items\PascalCaseDataProvider;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @method PascalCase processModelAdd( array $params )
 * @method PascalCase processModelUpdate(int $id, array $params )
 * @method PascalCase processFormAdd(array $params )
 * @method PascalCase processFormUpdate(int $id, array $params )
 * @method PascalCase processDelete(int $id )
 *
 * @package yii2\console\components\handlers\items
 *
 * @tag: #boilerplate #console #service #{{snake_case}}
 */
class PascalCaseHandler extends \common\handlers\items\PascalCaseHandler
{
    use ConsoleHandler;

    /**
     * @var array Настройки сервиса
     */
    public const array SETTINGS_SERVICE = [
        PascalCase::class,
        PascalCaseForm::class,
        PascalCaseSearch::class,
        PascalCaseDataProvider::class,
        PascalCaseService::class,
        PascalCaseProducer::class,
        PascalCaseRepository::class,
        [
            PascalCaseRepository::class => [ PascalCase::class, PascalCaseForm::class ]
        ]
    ];
}