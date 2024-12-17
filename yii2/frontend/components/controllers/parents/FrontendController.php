<?php declare(strict_types=1);

namespace yii2\frontend\components\controllers\parents;

use Yii;
use yii\filters\AccessControl;
use yii2\common\components\Action;
use yii2\common\components\Layout;
use yii2\frontend\controllers\AuthController;
use yii2\frontend\controllers\SiteController;
use yii2\common\components\traits\handlers\FrontendHandler;
use yii2\common\components\base\controllers\items\BaseWebHandlerController;

/**
 * < Frontend > Родительский класс для контроллеров в окружении: `frontend`
 *
 * @property FrontendHandler $handler
 * @property array $resources
 *
 * @package app\frontend\components\controllers\parents
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
                    'roles' => ['?'], // unAuth
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
                'label' => SiteController::TITLES[Action::INDEX],
                'url' => [SiteController::getEndpoint(Action::INDEX)]
            ],
            [
                'label' => SiteController::TITLES[SiteController::ACTION_ABOUT],
                'url' => [SiteController::getEndpoint(SiteController::ACTION_ABOUT)]
            ],
            [
                'label' => SiteController::TITLES[SiteController::ACTION_CONTACT],
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