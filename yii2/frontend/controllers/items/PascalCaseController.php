<?php declare(strict_types=1);

namespace frontend\controllers\items;

use common\components\enums\Action;
use frontend\handlers\items\PascalCaseHandler;
use common\interfaces\handlers\HandlerInterface;
use frontend\resources\items\PascalCaseExampleResource;
use frontend\resources\items\PascalCaseViewResource;
use frontend\resources\items\PascalCaseIndexResource;
use frontend\resources\items\PascalCaseCreateResource;
use frontend\resources\items\PascalCaseUpdateResource;
use frontend\components\controllers\parents\FrontendController;

/**
 * Boilerplate Контроллер для модели `PascalCase`
 *
 * @property PascalCaseHandler $handler
 *
 * @package yii2\frontend\controllers\items
 *
 * @tag: #boilerplate #frontend #controller #{{snake_case}}
 */
class PascalCaseController extends FrontendController
{
    /** @var string Эндпоинт для URI */
    public const string ENDPOINT = '{{kebab-case}}';

    public const string ACTION_EXAMPLE = 'example-action';

    protected HandlerInterface|string $handlerClass = PascalCaseHandler::class;



    protected array $resources = [
        Action::INDEX => PascalCaseIndexResource::class,
        Action::VIEW => PascalCaseViewResource::class,
        Action::CREATE => PascalCaseCreateResource::class,
        Action::UPDATE => PascalCaseUpdateResource::class,
        self::ACTION_EXAMPLE => PascalCaseExampleResource::class,
    ];



    /**
     * @return void
     */
    public function actionExampleAction()
    {
        $R = $this->getResource(self::ACTION_EXAMPLE);
    }
}