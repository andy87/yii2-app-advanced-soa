<?php declare(strict_types=1);

namespace console\handlers\items;

use console\services\items\PascalCaseService;
use frontend\repository\items\PascalCaseRepository;
use common\components\traits\handlers\ConsoleHandler;
use console\models\forms\items\PascalCaseForm;
use console\models\items\PascalCase;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @method PascalCase processModelAdd( array $params )
 * @method \yii2\console\models\items\PascalCase processModelUpdate(int $id, array $params )
 * @method \yii2\console\models\items\PascalCase processFormAdd(array $params )
 * @method \yii2\console\models\items\PascalCase processFormUpdate(int $id, array $params )
 * @method \yii2\console\models\items\PascalCase processDelete(int $id )
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
    public const SETTINGS_SERVICE = [
        \yii2\console\models\items\PascalCase::class,
        PascalCaseForm::class,
        \yii2\frontend\models\search\items\PascalCaseSearch::class,
        \frontend\dataProviders\items\PascalCaseDataProvider::class,
        \console\services\items\PascalCaseService::class,
        \frontend\producers\items\PascalCaseProducer::class,
        PascalCaseRepository::class,
        [
            \frontend\repository\items\PascalCaseRepository::class => [ \yii2\console\models\items\PascalCase::class, PascalCaseForm::class ]
        ]
    ];
}