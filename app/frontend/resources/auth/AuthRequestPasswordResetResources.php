<?php declare(strict_types=1);

namespace app\frontend\resources\auth;

use app\common\components\resources\TemplateResources;
use app\frontend\models\forms\PasswordResetRequestForm;

/**
 * < Frontend > `AuthRequestPasswordResetResources`
 *
 * @package app\frontend\resources\auth
 *
 * @tag #resources #auth #request #password #reset
 */
class AuthRequestPasswordResetResources extends TemplateResources
{
    /** @var string  */
    public const TEMPLATE = '@app/views/auth/request-password-reset-token';

    /** @var PasswordResetRequestForm  */
    public PasswordResetRequestForm $passwordResetRequestForm;



    /**
     * AuthRequestPasswordResetResources constructor.
     *
     * @return void
     *
     * @tag #resources #constructor
     */
    public function __construct()
    {
        $this->passwordResetRequestForm = new PasswordResetRequestForm;
    }
}