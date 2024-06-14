<?php

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\PasswordResetRequestForm;

/**
 * Class `AuthRequestPasswordResetResources`
 *
 * @package app\frontend\resources\auth
 */
class AuthRequestPasswordResetResources extends TemplateResources
{
    /** @var string  */
    public const TEMPLATE = '@views/auth/requestPasswordResetToken';

    /** @var PasswordResetRequestForm  */
    public PasswordResetRequestForm $passwordResetRequestForm;



    /**
     * AuthRequestPasswordResetResources constructor.
     */
    public function __construct()
    {
        $this->passwordResetRequestForm = new PasswordResetRequestForm;
    }
}