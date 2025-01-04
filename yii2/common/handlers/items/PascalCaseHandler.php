<?php declare(strict_types=1);

namespace common\handlers\items;

use common\models\items\PascalCase;
use common\services\items\PascalCaseService;
use common\models\forms\items\PascalCaseForm;
use common\producers\items\PascalCaseProducer;
use common\models\search\items\PascalCaseSearch;
use common\repository\items\PascalCaseRepository;
use common\dataProviders\items\PascalCaseDataProvider;
use common\components\base\handlers\items\source\SourceHandler;

/**
 * < Common > Родительский класс для обработчиков: console/frontend/backend
 *
 * @property PascalCaseService $service
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
        PascalCaseDataProvider::class,
        PascalCaseService::class,
        PascalCaseProducer::class,
        PascalCaseRepository::class,
        [
            PascalCaseRepository::class => [ PascalCase::class, PascalCaseForm::class ]
        ]
    ];
}