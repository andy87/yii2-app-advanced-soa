<?php declare(strict_types=1);

namespace backend\handlers\items;

use backend\producers\items\PascalCaseProducer;
use backend\resources\items\PascalCaseIndexResource;
use backend\resources\items\PascalCaseUpdateResource;
use backend\services\items\PascalCaseService;
use yii2\backend\models\forms\items\PascalCaseForm;
use yii2\backend\models\items\PascalCase;
use yii2\backend\models\search\items\PascalCaseSearch;
use yii2\common\components\base\resources\items\BaseTemplateResource;
use yii2\common\components\enums\Action;

/**
 * < Backend > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property \backend\services\items\PascalCaseService $service
 *
 * @package app\backend\components\handlers\items
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
        \common\dataProviders\items\PascalCaseDataProvider::class,
        \backend\services\items\PascalCaseService::class,
        PascalCaseProducer::class,
        \backend\repository\items\PascalCaseRepository::class,
        [
            \backend\repository\items\PascalCaseRepository::class => [ PascalCase::class, PascalCaseForm::class ]
        ]
    ];

    /** @var array */
    public array $resources = [
        Action::INDEX => \backend\resources\items\PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseIndexResource::class,
        Action::CREATE => \backend\resources\items\PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
        null => BaseTemplateResource::class,
    ];
}