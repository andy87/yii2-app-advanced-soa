<?php declare(strict_types=1);

namespace yii2\common\components\handlers\items;

use yii2\common\components\base\handlers\items\source\SourceHandler;
use yii2\common\components\dataProviders\items\PascalCaseDataProvider;
use yii2\common\components\producers\items\PascalCaseProducer;
use yii2\common\components\repository\items\PascalCaseRepository;
use yii2\common\components\services\items\PascalCaseService;
use yii2\common\models\forms\items\PascalCaseForm;
use yii2\common\models\items\PascalCase;
use yii2\common\models\search\items\PascalCaseSearch;


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
     * @var array Настройки сервиса
     */
    public const SETTINGS_SERVICE = [
        PascalCase::class,
        PascalCaseForm::class,
        PascalCaseSearch::class,
        \yii2\common\components\dataProviders\items\PascalCaseDataProvider::class,
        PascalCaseService::class,
        \yii2\common\components\producers\items\PascalCaseProducer::class,
        PascalCaseRepository::class,
        [
            PascalCaseRepository::class => [ \yii2\common\models\items\PascalCase::class, PascalCaseForm::class ]
        ]
    ];
}