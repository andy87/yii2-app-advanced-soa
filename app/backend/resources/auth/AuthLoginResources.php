<?php

namespace app\backend\resources\auth;

use app\common\models\forms\LoginForm;

/**
 * < Backend > `AuthLoginResources`
 *
 * @package app\backend\resources\auth
 *
 * @tag #backend #resources #auth
 */
class AuthLoginResources extends \app\common\components\resources\TemplateResources
{
    public const TEMPLATE = '@app/views/auth/login';

    public LoginForm $loginForm;

    /**
     * Constructor.
     *
     * @return void
     *
     * @tag #backend #resources #auth #constructor
     */
    public function __construct()
    {
        $this->loginForm = new LoginForm;
    }
}