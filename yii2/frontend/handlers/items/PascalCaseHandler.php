<?php declare(strict_types=1);

namespace frontend\handlers\items;

use common\dataProviders\items\PascalCaseDataProvider;
use frontend\resources\items\PascalCaseIndexResource;
use frontend\resources\items\PascalCaseUpdateResource;
use frontend\services\items\PascalCaseService;
use yii2\common\components\base\resources\items\BaseTemplateResource;
use yii2\common\components\enums\Action;
use yii2\frontend\models\forms\items\PascalCaseForm;
use yii2\frontend\models\items\PascalCase;
use yii2\frontend\models\search\items\PascalCaseSearch;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package app\frontend\components\handlers\items
 *
 * @tag: #boilerplate #frontend #service #{{snake_case}}
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
        \frontend\producers\items\PascalCaseProducer::class,
        \frontend\repository\items\PascalCaseRepository::class,
        [
            \frontend\repository\items\PascalCaseRepository::class => [ PascalCase::class, PascalCaseForm::class ]
        ]
    ];

    /** @var array */
    public array $resources = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseIndexResource::class,
        Action::CREATE => \frontend\resources\items\PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
        null => BaseTemplateResource::class,
    ];
}