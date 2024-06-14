<?php

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\SignupForm;

/**
 * Class `AuthSignupResources`
 *
 * @package app\frontend\resources\auth
 */
class AuthSignupResources extends TemplateResources
{
    /** @var string Шаблон */
    public const TEMPLATE = '@views/auth/signup';

    /** @var SignupForm $signupForm */
    public SignupForm $signupForm;



    /**
     * AuthSignupResources constructor.
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->signupForm = new SignupForm;
    }
}