<?php declare(strict_types=1);

namespace yii2\console\components\handlers\items;

use yii2\console\models\items\PascalCase;
use yii2\console\models\forms\items\PascalCaseForm;
use yii2\frontend\models\search\items\PascalCaseSearch;
use yii2\common\components\traits\handlers\ConsoleHandler;
use yii2\console\components\services\items\PascalCaseService;
use yii2\frontend\components\producers\items\PascalCaseProducer;
use yii2\frontend\components\repository\items\PascalCaseRepository;
use yii2\frontend\components\dataProviders\items\PascalCaseDataProvider;

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
 * @package app\console\components\handlers\items
 *
 * @tag: #boilerplate #console #service #{{snake_case}}
 */
class PascalCaseHandler extends \yii2\common\components\handlers\items\PascalCaseHandler
{
    use ConsoleHandler;

    /**
     * @var array Настройки сервиса
     */
    public const SETTINGS_SERVICE = [
        \yii2\console\models\items\PascalCase::class,
        PascalCaseForm::class,
        \yii2\frontend\models\search\items\PascalCaseSearch::class,
        \yii2\frontend\components\dataProviders\items\PascalCaseDataProvider::class,
        PascalCaseService::class,
        PascalCaseProducer::class,
        PascalCaseRepository::class,
        [
            \yii2\frontend\components\repository\items\PascalCaseRepository::class => [ \yii2\console\models\items\PascalCase::class, PascalCaseForm::class ]
        ]
    ];
}