<?php

namespace backend\resources\auth;

use common\resources\TemplateResources;
use yii2\common\models\forms\LoginForm;

/**
 * < Backend > `AuthLoginResources`
 *
 * @package yii2\backend\resources\auth
 *
 * @tag #backend #resources #auth
 */
class AuthLoginResources extends TemplateResources
{
    public const string TEMPLATE = '@app/views/auth/login';



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