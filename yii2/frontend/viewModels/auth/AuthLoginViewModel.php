<?php declare(strict_types=1);

namespace yii2\frontend\viewModels\auth;

use yii2\common\{ models\forms\LoginForm, components\viewModels\TemplateViewModel };

/**
 * < Frontend > `AuthLoginViewModels`
 *
 * @package yii2\frontend\viewModels\auth
 *
 * @tag #viewModel #auth #login
 */
class AuthLoginViewModel extends TemplateViewModel
{
    /** @var string Шаблон */
    public const TEMPLATE = '@app/views/auth/login';



    /** @var LoginForm $loginForm */
    public LoginForm $loginForm;



    /**
     * AuthLoginViewModels constructor.
     *
     * @return void
     *
     * @tag #viewModel #constructor
     */
    public function __construct()
    {
        $this->loginForm = new LoginForm;
    }
}