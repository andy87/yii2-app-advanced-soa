<?php declare(strict_types=1);

namespace yii2\frontend\resources\auth;

use yii2\common\{ models\forms\LoginForm, components\resources\TemplateResources };

/**
 * < Frontend > `AuthLoginResources`
 *
 * @package yii2\frontend\resources\auth
 *
 * @tag #resources #auth #login
 */
class AuthLoginResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@app/views/auth/login';



    /** @var LoginForm $loginForm */
    public LoginForm $loginForm;



    /**
     * AuthLoginResources constructor.
     *
     * @return void
     *
     * @tag #resources #constructor
     */
    public function __construct()
    {
        $this->loginForm = new LoginForm;
    }
}