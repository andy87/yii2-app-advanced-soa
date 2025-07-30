<?php declare(strict_types=1);

namespace yii2\frontend\viewModels\auth;

use yii2\common\components\viewModels\TemplateViewModel;
use yii2\frontend\models\forms\SignupForm;

/**
 * < Frontend > `AuthSignupViewModels`
 *
 * @package yii2\frontend\viewModels\auth
 *
 * @tag #viewModel #auth #signup
 */
class AuthSignupViewModel extends TemplateViewModel
{
    /** @var string Шаблон */
    public const TEMPLATE = '@app/views/auth/signup';

    /** @var SignupForm $signupForm */
    public SignupForm $signupForm;



    /**
     * AuthSignupViewModels constructor.
     *
     * @return void
     *
     * @tag #viewModel #constructor
     */
    public function __construct()
    {
        $this->signupForm = new SignupForm;
    }
}