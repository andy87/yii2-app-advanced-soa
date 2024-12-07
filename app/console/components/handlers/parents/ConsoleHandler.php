<?php declare(strict_types=1);

namespace app\console\components\handlers\parents;

use app\console\models\items\PascalCase;
use app\console\models\forms\items\PascalCaseForm;
use app\console\models\search\items\PascalCaseSearch;
use app\console\components\services\items\PascalCaseService;
use app\console\components\handlers\items\PascalCaseHandler;
use app\console\components\producers\items\PascalCaseProducer;
use app\console\components\repository\items\PascalCaseRepository;
use app\console\components\dataProviders\items\PascalCaseDataProvider;
use app\common\components\base\services\items\settings\ServiceSettings;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @property PascalCaseService $service
 *
 * @package app\console\components\handlers\parents
 *
 * @tag: #abstract #console #parent #boilerplate #handler
 */
abstract class ConsoleHandler extends PascalCaseHandler
{
    /**
     * @return ServiceSettings
     */
    public function getServiceSettings(): ServiceSettings
    {
        return new ServiceSettings(
            PascalCase::class,
            PascalCaseForm::class,
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