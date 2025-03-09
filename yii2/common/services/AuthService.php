<?php declare(strict_types=1);

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
    public function authLoginForm(LoginForm $loginForm, array $data = []): bool
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
    protected function login( LoginForm $loginForm ): bool
    {
        if ( $loginForm->validate() )
        {
            $identity = $loginForm->getIdentity();

            $duration = $this->getRememberMeDuration($loginForm);

            if ($identity) return Yii::$app->user->login( $identity, $duration );
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
    protected function getRememberMeDuration( LoginForm $loginForm ): int
    {
        return ($loginForm->rememberMe)
            ? ( 3600 * 24 * Yii::$app->params[ LoginForm::PARAM_REMEMBER_ME ] )
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