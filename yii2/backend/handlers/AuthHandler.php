<?php

namespace yii2\backend\handlers;

use Yii;
use yii\base\InvalidConfigException;
use andy87\lazy_load\yii2\LazyLoadTrait;
use yii2\backend\services\controllers\AuthService;
use yii2\backend\resources\auth\AuthLoginResources;

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
     * @return AuthLoginResources
     *
     * @throws InvalidConfigException
     */
    public function processLogin(): AuthLoginResources
    {
        $R = new AuthLoginResources;

        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();

            $this->service->authLoginForm($R->loginForm, $post);
        }

        return $R;
    }
}