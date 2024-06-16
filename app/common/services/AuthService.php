<?php

namespace app\common\services;

use Yii;
use yii\base\InvalidConfigException;
use app\common\{ models\forms\LoginForm, components\core\BaseService };

/**
 * < Common > AuthService
 *
 * @package app\common\services
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
    public function handlerLoginForm(LoginForm $loginForm, array $data): bool
    {
        if ( $loginForm->load( $data ) && $loginForm->validate() )
        {
            return $this->login($loginForm);
        }

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
        $identity = $loginForm->getUser();
        $duration = $this->getRememberMeDuration($loginForm);

        if ( $loginForm->validate() )
        {
            if ( Yii::$app->user->login( $identity, $duration ) )
            {
                return true;
            }
        }

        $loginForm->addError('password', 'Incorrect username or password.');

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