<?php declare(strict_types=1);

namespace app\common\components\handlers\items;

use app\common\models\items\PascalCase;
use app\common\models\search\items\PascalCaseSearch;
use app\common\components\services\items\PascalCaseService;
use app\common\components\producers\items\PascalCaseProducer;
use app\common\components\repository\items\PascalCaseRepository;
use app\common\components\base\handlers\items\source\SourceHandler;
use app\common\components\dataProviders\items\PascalCaseDataProvider;
use app\common\components\base\services\items\settings\ServiceSettings;

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
     * @return ServiceSettings
     */
    public function getServiceSettings(): ServiceSettings
    {
        return new ServiceSettings(
            PascalCase::class,
            null,
            PascalCaseSearch::class,
            PascalCaseDataProvider::class,
            PascalCaseService::class,
            PascalCaseProducer::class,
            PascalCaseRepository::class,
            []
        );
    }

    // {{Boilerplate}}
}