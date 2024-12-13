<?php declare(strict_types=1);

namespace yii2\frontend\resources\auth;

use yii2\common\components\resources\TemplateResources;
use yii2\frontend\models\forms\SignupForm;

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