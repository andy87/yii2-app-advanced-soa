<?php declare(strict_types=1);

namespace common\handlers\items;

use common\services\items\PascalCaseService;
use common\components\base\handlers\items\source\SourceHandler;
use common\models\forms\items\PascalCaseForm;
use common\models\items\PascalCase;
use common\models\search\items\PascalCaseSearch;


/**
 * < Common > Родительский класс для обработчиков: console/frontend/backend
 *
 * @property \common\services\items\PascalCaseService $service
 *
 * @package yii2\app\common\services\components\handlers\items
 *
 * @tag: #boilerplate #common #service #{{snake_case}}
 */
class PascalCaseHandler extends SourceHandler
{
    /**
     * @var array Настройки сервиса
     */
    public const SETTINGS_SERVICE = [
        PascalCase::class,
        PascalCaseForm::class,
        PascalCaseSearch::class,
        \common\dataProviders\items\PascalCaseDataProvider::class,
        \common\services\items\PascalCaseService::class,
        \common\producers\items\PascalCaseProducer::class,
        \common\repository\items\PascalCaseRepository::class,
        [
            \common\repository\items\PascalCaseRepository::class => [ \common\models\items\PascalCase::class, PascalCaseForm::class ]
        ]
    ];
}