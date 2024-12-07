<?php declare(strict_types=1);

namespace app\frontend\components\handlers\items;

use app\common\components\enums\Action;
use app\frontend\models\items\PascalCase;
use app\frontend\models\forms\items\PascalCaseForm;
use app\frontend\models\search\items\PascalCaseSearch;
use app\frontend\components\services\items\PascalCaseService;
use app\frontend\components\handlers\parents\FrontendHandler;
use app\frontend\components\producers\items\PascalCaseProducer;
use app\frontend\components\repository\items\PascalCaseRepository;
use app\frontend\components\resources\items\PascalCaseIndexResource;
use app\frontend\components\resources\items\PascalCaseCreateResource;
use app\frontend\components\resources\items\PascalCaseUpdateResource;
use app\common\components\base\resources\items\BaseTemplateResource;
use app\frontend\components\dataProviders\items\PascalCaseDataProvider;
use app\common\components\base\services\items\settings\ServiceSettings;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package app\frontend\components\handlers\items
 *
 * @tag: #boilerplate #frontend #service #{{snake_case}}
 */
class PascalCaseHandler extends FrontendHandler
{
    /** @var array */
    public array $resources = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseIndexResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
        null => BaseTemplateResource::class,
    ];

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
}