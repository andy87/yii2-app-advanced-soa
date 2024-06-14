<?php

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\PasswordResetRequestForm;

/**
 * Class `AuthRequestPasswordResetResources`
 *
 * @package app\frontend\resources\auth
 *
 * @tag #resources #auth #request #password #reset
 */
class AuthRequestPasswordResetResources extends TemplateResources
{
    /** @var string  */
    public const TEMPLATE = '@views/auth/request-password-reset-token';

    /** @var PasswordResetRequestForm  */
    public PasswordResetRequestForm $passwordResetRequestForm;



    /**
     * AuthRequestPasswordResetResources constructor.
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->passwordResetRequestForm = new PasswordResetRequestForm;
    }
}