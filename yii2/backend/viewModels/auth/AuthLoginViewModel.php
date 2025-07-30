<?php

namespace yii2\backend\viewModels\auth;

use yii2\common\models\forms\LoginForm;

/**
 * < Backend > `AuthLoginViewModels`
 *
 * @package yii2\backend\viewModels\auth
 *
 * @tag #backend #viewModel #auth
 */
class AuthLoginViewModel extends \yii2\common\components\viewModels\TemplateViewModel
{
    public const TEMPLATE = '@app/views/auth/login';

    public LoginForm $loginForm;

    /**
     * Constructor.
     *
     * @return void
     *
     * @tag #backend #viewModel #auth #constructor
     */
    public function __construct()
    {
        $this->loginForm = new LoginForm;
    }
}