<?php declare(strict_types=1);

namespace app\console\components\handlers\items;

use Exception;
use yii\base\InvalidConfigException;
use app\console\models\items\PascalCase;
use app\console\models\forms\items\PascalCaseForm;
use app\frontend\models\search\items\PascalCaseSearch;
use app\console\components\services\items\PascalCaseService;
use app\frontend\components\producers\items\PascalCaseProducer;
use app\frontend\components\repository\items\PascalCaseRepository;
use app\common\components\base\services\items\settings\ServiceSettings;
use app\frontend\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package app\console\components\handlers\items
 *
 * @tag: #boilerplate #console #service #{{snake_case}}
 */
class PascalCaseHandler extends \app\common\components\handlers\items\PascalCaseHandler
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
            PascalCaseRepository::class
        );
    }

    // {{Boilerplate}}
}