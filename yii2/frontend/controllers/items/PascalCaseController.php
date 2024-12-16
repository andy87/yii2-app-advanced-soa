<?php declare(strict_types=1);

namespace yii2\frontend\controllers\items;

use yii2\common\components\enums\Action;
use yii2\common\components\interfaces\handlers\HandlerInterface;
use yii2\common\components\interfaces\models\SearchModelInterface;
use yii2\common\components\interfaces\models\SourceModelInterface;
use yii2\common\components\interfaces\producers\ProducerInterface;
use yii2\common\components\interfaces\repository\RepositoryInterface;
use yii2\common\components\interfaces\dataProvider\DataProviderInterface;
use yii2\frontend\components\handlers\items\PascalCaseHandler;
use yii2\frontend\components\controllers\parents\FrontendController;
use yii2\frontend\components\resources\items\PascalCaseViewResource;
use yii2\frontend\components\resources\items\PascalCaseIndexResource;
use yii2\frontend\components\resources\items\PascalCaseUpdateResource;
use yii2\frontend\components\resources\items\PascalCaseCreateResource;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseHandler $handler
 *
 * @package app\frontend\controllers\items
 *
 * @tag: #boilerplate #frontend #controller #{{snake_case}}
 */
class PascalCaseController extends FrontendController
{
    /** @var string Эндпоинт для URI */
    public const ENDPOINT = '{{kebab-case}}';


    protected HandlerInterface|string $classHandler = \yii2\frontend\components\handlers\items\PascalCaseHandler::class;
    protected SourceModelInterface|string $classModel = PascalCaseHandler::MODEL_CLASS;
    protected SearchModelInterface|string $classSearchModel = PascalCaseHandler::SEARCH_MODEL_CLASS;
    protected DataProviderInterface|string $classDataProvider = PascalCaseHandler::DATA_PROVIDER_CLASS;
    protected ProducerInterface|string $classProducer = \yii2\frontend\components\handlers\items\PascalCaseHandler::PRODUCER_CLASS;
    protected RepositoryInterface|string $classRepository = PascalCaseHandler::REPOSITORY_CLASS;


    protected array $resources = [
        Action::INDEX => \yii2\frontend\components\resources\items\PascalCaseIndexResource::class,
        Action::VIEW => \yii2\frontend\components\resources\items\PascalCaseViewResource::class,
        Action::CREATE => \yii2\frontend\components\resources\items\PascalCaseCreateResource::class,
        Action::UPDATE => \yii2\frontend\components\resources\items\PascalCaseUpdateResource::class,
    ];
}