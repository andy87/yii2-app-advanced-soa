<?php

namespace common\components\traits\controllers;

use common\components\Action;
use common\components\actions\web\CrudViewAction;
use common\components\actions\web\CrudIndexAction;
use common\components\actions\web\CrudCreateAction;
use common\components\actions\web\CrudDeleteAction;
use common\components\actions\web\CrudUpdateAction;
use common\components\base\handlers\items\source\SourceHandler;

/**
 * Trait ActionTrait
 *
 * @package yii2\common\components\traits\controllers
 */
trait CrudTrait
{
    /** @var SourceHandler $handler */
    protected SourceHandler $handler;

    /** @var array $resources */
    protected array $resources;



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