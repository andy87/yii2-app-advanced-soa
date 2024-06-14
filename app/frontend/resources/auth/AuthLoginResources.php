<?php

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\common\models\LoginForm;

/**
 * Class `AuthLoginResources`
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
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->loginForm = new LoginForm;
    }
}