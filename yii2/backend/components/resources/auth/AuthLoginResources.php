<?php

namespace yii2\backend\components\resources\auth;

use yii2\common\models\forms\LoginForm;
use yii2\common\components\resources\TemplateResources;

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