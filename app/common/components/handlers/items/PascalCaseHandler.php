<?php declare(strict_types=1);

namespace app\common\components\handlers\items;

use app\common\components\base\handlers\items\source\SourceHandler;
use app\common\components\dataProviders\items\PascalCaseDataProvider;
use app\common\components\producers\items\PascalCaseProducer;
use app\common\components\repository\items\PascalCaseRepository;
use app\common\components\services\items\PascalCaseService;
use app\common\models\forms\items\PascalCaseForm;
use app\common\models\items\PascalCase;
use app\common\models\search\items\PascalCaseSearch;


/**
 * < Common > Родительский класс для обработчиков: console/frontend/backend
 *
 * @property PascalCaseService $service
 *
 * @package app\app\common\services\components\handlers\items
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