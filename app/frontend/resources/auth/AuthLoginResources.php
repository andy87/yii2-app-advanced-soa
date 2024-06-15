<?php declare(strict_types=1);

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\common\models\forms\LoginForm;

/**
 * < Frontend > `AuthLoginResources`
 *
 * @package app\frontend\resources\auth
 *
 * @tag #resources #auth #login
 */
class AuthLoginResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@views/auth/login';



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