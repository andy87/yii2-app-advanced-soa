<?php declare(strict_types=1);

namespace app\console\components\handlers\items;

use app\console\models\items\PascalCase;
use app\console\models\forms\items\PascalCaseForm;
use app\frontend\models\search\items\PascalCaseSearch;
use app\common\components\traits\handlers\ConsoleHandler;
use app\console\components\services\items\PascalCaseService;
use app\frontend\components\producers\items\PascalCaseProducer;
use app\frontend\components\repository\items\PascalCaseRepository;
use app\frontend\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @method PascalCase processModelAdd( array $params )
 * @method PascalCase processModelUpdate( int $id, array $params )
 * @method PascalCase processFormAdd( array $params )
 * @method PascalCase processFormUpdate( int $id, array $params )
 * @method PascalCase processDelete( int $id )
 *
 * @package app\console\components\handlers\items
 *
 * @tag: #boilerplate #console #service #{{snake_case}}
 */
class PascalCaseHandler extends \app\common\components\handlers\items\PascalCaseHandler
{
    use ConsoleHandler;

    /**
     * @var array Настройки сервиса
     */
    public const SETTINGS_SERVICE = [
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