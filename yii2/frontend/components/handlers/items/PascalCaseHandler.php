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
    public const SETTINGS_SERVICE = [
        PascalCase::class,
        \yii2\frontend\models\forms\items\PascalCaseForm::class,
        \yii2\frontend\models\search\items\PascalCaseSearch::class,
        \yii2\common\components\dataProviders\items\PascalCaseDataProvider::class,
        \yii2\frontend\components\services\items\PascalCaseService::class,
        \yii2\frontend\components\producers\items\PascalCaseProducer::class,
        \yii2\frontend\components\repository\items\PascalCaseRepository::class,
        [
            \yii2\frontend\components\repository\items\PascalCaseRepository::class => [ PascalCase::class, \yii2\frontend\models\forms\items\PascalCaseForm::class ]
        ]
    ];

    /** @var array */
    public array $resources = [
        Action::INDEX => \yii2\frontend\components\resources\items\PascalCaseIndexResource::class,
        Action::VIEW => \yii2\frontend\components\resources\items\PascalCaseIndexResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => \yii2\frontend\components\resources\items\PascalCaseUpdateResource::class,
        null => BaseTemplateResource::class,
    ];
}