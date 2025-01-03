<?php declare(strict_types=1);

namespace frontend\resources\auth;

use common\resources\TemplateResources;
use frontend\models\forms\SignupForm;

/**
 * < Frontend > `AuthSignupResources`
 *
 * @package yii2\frontend\resources\auth
 *
 * @tag #resources #auth #signup
 */
class AuthSignupResources extends TemplateResources
{
    /** @var string Шаблон */
    public const string TEMPLATE = '@app/views/auth/signup';

    /** @var SignupForm $signupForm */
    public SignupForm $signupForm;



    /**
     * AuthSignupResources constructor.
     *
     * @return void
     *
     * @tag #resources #constructor
     */
    public function __construct()
    {
        $this->signupForm = new SignupForm;
    }
}