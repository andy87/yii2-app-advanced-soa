<?php declare(strict_types=1);

namespace frontend\components\controllers\parents;

use Yii;
use common\components\Layout;
use common\components\enums\Action;
use frontend\components\Navigation;
use common\components\AccessControl;
use frontend\controllers\AuthController;
use frontend\controllers\SiteController;
use common\components\traits\handlers\FrontendHandler;
use common\components\base\controllers\items\BaseWebHandlerController;

/**
 * < Frontend > Родительский класс для контроллеров в окружении: `frontend`
 *
 * @property FrontendHandler $handler
 * @property array $resources
 *
 * @package yii2\frontend\components\controllers\parents
 *
 * @tag: #abstract #frontend #parent #controller
 */
abstract class FrontendController extends BaseWebHandlerController
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
                    'roles' => [AccessControl::ROLE_GUEST],
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
        $menuItems = [
            [
                'label' => Navigation::TITLES[Action::INDEX],
                'url' => [SiteController::getEndpoint(Action::INDEX)]
            ],
            [
                'label' => Navigation::TITLES[SiteController::ACTION_ABOUT],
                'url' => [SiteController::getEndpoint(SiteController::ACTION_ABOUT)]
            ],
            [
                'label' => Navigation::TITLES[SiteController::ACTION_CONTACT],
                'url' => [SiteController::getEndpoint(SiteController::ACTION_CONTACT)]
            ],
        ];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => AuthController::LABELS[AuthController::ACTION_SIGNUP],
                'url' => [AuthController::getEndpoint(AuthController::ACTION_SIGNUP)]
            ];
        }

        return $menuItems;
    }
}