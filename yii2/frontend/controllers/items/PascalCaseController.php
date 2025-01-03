<?php declare(strict_types=1);

namespace frontend\controllers\items;

use common\components\enums\Action;
use common\interfaces\dataProvider\DataProviderInterface;
use common\interfaces\handlers\HandlerInterface;
use common\interfaces\models\SearchModelInterface;
use common\interfaces\models\SourceModelInterface;
use common\interfaces\producers\ProducerInterface;
use common\interfaces\repository\RepositoryInterface;
use frontend\components\controllers\parents\FrontendController;
use frontend\handlers\items\PascalCaseHandler;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property \frontend\handlers\items\PascalCaseHandler $handler
 *
 * @package yii2\frontend\controllers\items
 *
 * @tag: #boilerplate #frontend #controller #{{snake_case}}
 */
class PascalCaseController extends FrontendController
{
    /** @var string Эндпоинт для URI */
    public const ENDPOINT = '{{kebab-case}}';


    protected HandlerInterface|string $classHandler = \frontend\handlers\items\PascalCaseHandler::class;
    protected SourceModelInterface|string $classModel = PascalCaseHandler::MODEL_CLASS;
    protected SearchModelInterface|string $classSearchModel = PascalCaseHandler::SEARCH_MODEL_CLASS;
    protected DataProviderInterface|string $classDataProvider = \frontend\handlers\items\PascalCaseHandler::DATA_PROVIDER_CLASS;
    protected ProducerInterface|string $classProducer = \frontend\handlers\items\PascalCaseHandler::PRODUCER_CLASS;
    protected RepositoryInterface|string $classRepository = PascalCaseHandler::REPOSITORY_CLASS;


    protected array $resources = [
        Action::INDEX => \frontend\resources\items\PascalCaseIndexResource::class,
        Action::VIEW => \frontend\resources\items\PascalCaseViewResource::class,
        Action::CREATE => \frontend\resources\items\PascalCaseCreateResource::class,
        Action::UPDATE => \frontend\resources\items\PascalCaseUpdateResource::class,
    ];
}