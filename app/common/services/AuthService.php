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
     * @tag #common #service #auth #handler #form #login
     */
    public function handlerLoginForm(LoginForm $loginForm, array $data = []): bool
    {
        try
        {
            if ( count($data) ) $loginForm->load( $data );

            return $this->login($loginForm);

        } catch (InvalidConfigException $e) {

            $loginForm->addError('username', $e->getMessage());
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
        $identity = $loginForm->getIdentity();

        if ( $identity && $loginForm->validate() )
        {
            $duration = $this->getRememberMeDuration($loginForm);

            return Yii::$app->user->login( $identity, $duration );
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