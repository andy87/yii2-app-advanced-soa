<?php declare(strict_types=1);

namespace yii2\frontend\resources\auth;

use yii2\common\components\resources\TemplateResources;
use yii2\frontend\models\forms\PasswordResetRequestForm;

/**
 * < Frontend > `AuthRequestPasswordResetResources`
 *
 * @package yii2\frontend\resources\auth
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