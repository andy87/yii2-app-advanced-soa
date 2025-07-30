<?php

namespace yii2\backend\handlers;

use Yii;
use yii\base\InvalidConfigException;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\backend\services\controllers\AuthService;
use yii2\backend\viewModels\auth\AuthLoginViewModel;

/**
 * @property-read AuthService $service
 */
class AuthHandler extends \yii2\common\handlers\AuthHandler
{
    use LazyLoadTrait;

    public array $lazyLoadConfig = [
        'service' => AuthService::class
    ];



    /**
     * @return AuthLoginViewModel
     *
     * @throws InvalidConfigException
     */
    public function processLogin(): AuthLoginViewModel
    {
        $R = new AuthLoginViewModel;

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $this->service->authLoginForm($R->loginForm, $post);
        }

        return $R;
    }
}