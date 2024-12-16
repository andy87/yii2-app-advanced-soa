<?php declare(strict_types=1);

namespace yii2\frontend\components\handlers\items;

use yii2\common\components\enums\Action;
use yii2\frontend\models\items\PascalCase;
use yii2\frontend\models\forms\items\PascalCaseForm;
use yii2\frontend\models\search\items\PascalCaseSearch;
use yii2\frontend\components\services\items\PascalCaseService;
use yii2\frontend\components\producers\items\PascalCaseProducer;
use yii2\frontend\components\repository\items\PascalCaseRepository;
use yii2\frontend\components\resources\items\PascalCaseIndexResource;
use yii2\common\components\base\resources\items\BaseTemplateResource;
use yii2\common\components\dataProviders\items\PascalCaseDataProvider;
use yii2\frontend\components\resources\items\PascalCaseCreateResource;
use yii2\frontend\components\resources\items\PascalCaseUpdateResource;

/**
 * < Frontend > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package app\frontend\components\handlers\items
 *
 * @tag: #boilerplate #frontend #service #{{snake_case}}
 */
class PascalCaseHandler extends \yii2\common\components\handlers\items\PascalCaseHandler
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