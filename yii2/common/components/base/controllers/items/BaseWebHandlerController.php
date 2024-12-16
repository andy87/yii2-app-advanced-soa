<?php declare(strict_types=1);

namespace yii2\common\components\base\controllers\items;

use yii2\common\components\enums\Action;
use yii2\common\components\actions\web\CrudViewAction;
use yii2\common\components\actions\web\CrudIndexAction;
use yii2\common\components\actions\web\CrudCreateAction;
use yii2\common\components\actions\web\CrudDeleteAction;
use yii2\common\components\actions\web\CrudUpdateAction;
use yii2\common\components\base\handlers\items\BaseWebHandler;
use yii2\common\components\interfaces\handlers\HandlerInterface;
use yii2\common\components\interfaces\models\SearchModelInterface;
use yii2\common\components\interfaces\models\SourceModelInterface;
use yii2\common\components\interfaces\producers\ProducerInterface;
use yii2\common\components\interfaces\repository\RepositoryInterface;
use yii2\common\components\interfaces\dataProvider\DataProviderInterface;
use yii2\common\components\interfaces\controllers\ControllerHandlerInterface;

/**
 * < Common > Родительский класс для всех контроллеров с сервисом
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #items #web #handler
 */
abstract class BaseWebHandlerController extends BaseWebController implements ControllerHandlerInterface
{
    /** @var BaseWebHandler `Обработчик` */
    protected BaseWebHandler $handler;

    /** @var array $resources */
    protected array $resources = [];


    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();

        $actions[Action::INDEX] = [
            'class' => CrudIndexAction::class,
            'handler' => $this->handler,
            'resource' => $this->resources[Action::INDEX],
        ];

        $actions[Action::CREATE] = [
            'class' => CrudCreateAction::class,
            'handler' => $this->handler,
            'resource' => $this->resources[Action::CREATE],
        ];

        $actions[Action::UPDATE] = [
            'class' => CrudUpdateAction::class,
            'handler' => $this->handler,
            'resource' => $this->resources[Action::UPDATE],
        ];

        $actions[Action::VIEW] = [
            'class' => CrudViewAction::class,
            'handler' => $this->handler,
            'resource' => $this->resources[Action::VIEW],
        ];

        $actions[Action::DELETE] = [
            'class' => CrudDeleteAction::class,
            'handler' => $this->handler,
            'resource' => $this->resources[Action::DELETE],
        ];

        return $actions;
    }
}