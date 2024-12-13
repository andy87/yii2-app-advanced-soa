<?php

namespace yii2\common\services;

use Yii;
use yii\base\InvalidConfigException;
use yii2\common\{ models\forms\LoginForm, components\core\BaseService };

/**
 * < Common > AuthService
 *
 * @package yii2\common\services
 *
 * @tag #common #services #AuthService
 */
class AuthService extends BaseService
{
    /**
     * @param LoginForm $loginForm
     *
     * @param array $data
     *
     * @return bool
     *
     * @throws InvalidConfigException
     *
     * @tag #common #service #auth #handler #form #login
     */
    public function handlerLoginForm(LoginForm $loginForm, array $data = []): bool
    {
        if ( count($data) ) $loginForm->load( $data );

        if ( $this->login($loginForm) ) return true;

        $loginForm->password = '';

        return false;
    }

    /**
     * @param LoginForm $loginForm
     *
     * @return bool
     *
     * @throws InvalidConfigException
     *
     * @tag #common #services #login
     */
    public function login(LoginForm $loginForm): bool
    {
        if ( $loginForm->validate() )
        {
            $duration = $this->getRememberMeDuration($loginForm);

            return Yii::$app->user->login( $loginForm->getIdentity(), $duration );
        }

        return false;
    }

    /**
     * @param LoginForm $loginForm
     *
     * @return int
     *
     * @tag #common #services #rememberMe #duration
     */
    public function getRememberMeDuration(LoginForm $loginForm): int
    {
        return ($loginForm->rememberMe)
            ? ( 3600 * 24 * Yii::$app->params['auth.rememberMeDuration.days'] )
            : 0;
    }

    /**
     * @return bool
     *
     * @tag #common #services #logout
     */
    public function logout(): bool
    {
        return Yii::$app->user->logout();
    }
}