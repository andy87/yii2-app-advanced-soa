<?php declare(strict_types=1);

namespace yii2\backend\components\controllers\parents;

use Yii;
use yii\filters\AccessControl;
use yii2\common\components\Action;
use yii2\common\components\Layout;
use yii2\backend\controllers\SiteController;
use yii2\common\components\traits\handlers\BackendHandler;
use yii2\common\components\base\controllers\items\BaseWebHandlerController;

/**
 * < Backend > Родительский класс для контроллеров в окружении: `backend`
 *
 * @property BackendHandler $handler
 * @property array $resources
 *
 * @package app\backend\components\controllers\parents
 *
 * @tag: #abstract #backend #parent #controller
* \ */
abstract class BackendController extends BaseWebHandlerController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'], //user
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return void
     */
    protected function setupLayoutNavBarConfig(): void
    {
        Layout::$navBarConfig = [
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => Layout::$class['navBar'],
            ],
        ];
    }

    /**
     * @return void
     */
    protected function setupLayoutNavConfig(): void
    {
        Layout::$navConfig = [
            'options' => ['class' => Layout::$class['nav']],
            'items' => $this->setupLayoutNavItems(),
        ];
    }

    /**
     * @return array
     */
    protected function setupLayoutNavItems(): array
    {
        return [
            [
                'label' => SiteController::LABELS[Action::INDEX],
                'url' => [SiteController::getEndpoint(Action::INDEX)]
            ],
        ];
    }
}