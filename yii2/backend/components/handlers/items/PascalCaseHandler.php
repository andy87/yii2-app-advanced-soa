<?php declare(strict_types=1);

namespace yii2\backend\components\handlers\items;

use yii2\common\components\enums\Action;
use yii2\backend\models\items\PascalCase;
use yii2\backend\models\forms\items\PascalCaseForm;
use yii2\backend\models\search\items\PascalCaseSearch;
use yii2\backend\components\services\items\PascalCaseService;
use yii2\backend\components\producers\items\PascalCaseProducer;
use yii2\backend\components\repository\items\PascalCaseRepository;
use yii2\backend\components\resources\items\PascalCaseIndexResource;
use yii2\backend\components\resources\items\PascalCaseCreateResource;
use yii2\backend\components\resources\items\PascalCaseUpdateResource;
use yii2\common\components\base\resources\items\BaseTemplateResource;
use yii2\common\components\dataProviders\items\PascalCaseDataProvider;

/**
 * < Backend > Обработчик контроллеров работающих с сущностью `PascalCase`
 *
 * @property PascalCaseService $service
 *
 * @package app\backend\components\handlers\items
 *
 * @tag: #boilerplate #backend #service #{{snake_case}}
 */
class PascalCaseHandler extends \yii2\common\components\handlers\items\PascalCaseHandler
{
    /**
     * @var array Настройки сервиса
     */
    public const SETTINGS_SERVICE = [
        PascalCase::class,
        PascalCaseForm::class,
        \yii2\backend\models\search\items\PascalCaseSearch::class,
        \yii2\common\components\dataProviders\items\PascalCaseDataProvider::class,
        PascalCaseService::class,
        PascalCaseProducer::class,
        PascalCaseRepository::class,
        [
            PascalCaseRepository::class => [ \yii2\backend\models\items\PascalCase::class, PascalCaseForm::class ]
        ]
    ];

    /** @var array */
    public array $resources = [
        Action::INDEX => \yii2\backend\components\resources\items\PascalCaseIndexResource::class,
        Action::VIEW => \yii2\backend\components\resources\items\PascalCaseIndexResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => \yii2\backend\components\resources\items\PascalCaseUpdateResource::class,
        null => BaseTemplateResource::class,
    ];
}