<?php declare(strict_types=1);

namespace backend\handlers\items;

use common\components\enums\Action;
use backend\models\items\PascalCase;
use backend\services\items\PascalCaseService;
use backend\models\forms\items\PascalCaseForm;
use backend\producers\items\PascalCaseProducer;
use backend\models\search\items\PascalCaseSearch;
use backend\repository\items\PascalCaseRepository;
use backend\resources\items\PascalCaseIndexResource;
use backend\resources\items\PascalCaseUpdateResource;
use backend\resources\items\PascalCaseCreateResource;
use common\dataProviders\items\PascalCaseDataProvider;
use common\components\base\resources\items\BaseTemplateResource;

/**
 * < Backend > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package yii2\backend\components\handlers\items
 *
 * @tag: #boilerplate #backend #service #{{snake_case}}
 */
class PascalCaseHandler extends \common\handlers\items\PascalCaseHandler
{
    /**
     * @var array Настройки сервиса
     */
    public const array SETTINGS_SERVICE = [
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

    /** @var array */
    public array $resources = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseIndexResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
        null => BaseTemplateResource::class,
    ];
}