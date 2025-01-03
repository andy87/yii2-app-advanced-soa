<?php declare(strict_types=1);

namespace frontend\resources\auth;

use common\resources\TemplateResources;
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
    public const string TEMPLATE = '@app/views/auth/request-password-reset-token';

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