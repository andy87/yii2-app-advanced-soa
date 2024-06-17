<?php declare(strict_types=1);

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\SignupForm;

/**
 * < Frontend > `AuthSignupResources`
 *
 * @package app\frontend\resources\auth
 *
 * @tag #resources #auth #signup
 */
class AuthSignupResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@app/views/auth/signup';

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