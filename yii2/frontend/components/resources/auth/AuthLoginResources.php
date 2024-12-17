<?php declare(strict_types=1);

namespace yii2\frontend\components\resources\auth;

use yii2\common\{components\resources\TemplateResources, models\forms\LoginForm};

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
    public const string TEMPLATE = '@app/views/auth/login';



    /** @var LoginForm $loginForm */
    public LoginForm $loginForm;



    /**
     * AuthLoginResources constructor.
     *
     * @return void
     *
     * @tag #resources #constructor
     */
    public function __construct( array $config = [] )
    {
        parent::__construct( $config );

        $this->loginForm = new LoginForm;
    }
}