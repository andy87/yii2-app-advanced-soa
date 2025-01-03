<?php declare(strict_types=1);

namespace backend\components\controllers\parents;

use Yii;
use common\components\Layout;
use common\components\enums\Action;
use common\components\AccessControl;
use backend\controllers\SiteController;
use common\components\traits\handlers\BackendHandler;
use common\components\base\controllers\items\BaseWebHandlerController;

/**
 * < Backend > Родительский класс для контроллеров в окружении: `backend`
 *
 * @property BackendHandler $handler
 * @property array $resources
 *
 * @package yii2\backend\components\controllers\parents
 *
 * @tag: #abstract #backend #parent #controller
 */
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
                    'roles' => [AccessControl::ROLE_USER],
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